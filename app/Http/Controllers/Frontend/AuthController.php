<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->middleware('guest:customer');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }


    public function viewRegister() {
        return view('frontend.auth.register');
    }

    public function register(CustomerRequest $request) {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            unset($data['password_confirmation']);
            $data['password'] = Hash::make($data['password']);
            $data['avatar'] = $this->uploadService->upload($data['avatar'] ?? '', 'avatar');
            Customer::create($data);
            DB::commit();

            return redirect()->route('frontend.login')->with('success', 'Thêm thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', 'Thêm thất bại');
        }
    }

    public function login() {
        return view('frontend.auth.login');
    }

    public function authenticate(LoginRequest $request) {
        $validate = $request->validated();
        $remember = $request->remember ?? false;
//        $status   = User::value('status');
//        $validate['status'] = $status;

        if (Auth::guard('customer')->attempt($validate, $remember)) {

            return redirect('/');
        }

        return back()->with('error', 'Email hoặc mật khẩu không chính xác');
    }

    public function logout(Request $request) {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function forgot() {
        return view('frontend.auth.forgot-password');
    }

    public function sendLink(Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {
                $customer->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $customer->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('frontend.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
