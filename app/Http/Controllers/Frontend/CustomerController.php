<?php


namespace App\Http\Controllers\Frontend;


use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends \App\Http\Controllers\Controller
{
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function profile() {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('customer_id', Auth::id())->get();

        return view('frontend.profile', compact('customer', 'orders'));
    }

    public function update(CustomerRequest $request) {
        DB::beginTransaction();
        try {
            $model = Auth::guard('customer')->user();
            $data = $request->validated();
            unset($data['password_confirmation']);
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $data['avatar'] = $this->uploadService->handleFileUpdate($data['avatar'] ?? '', $model->avatar, 'avatar');
            Customer::where('id', $model->id)->update($data);
            DB::commit();

            return redirect()->route('profile')->with('success', 'Sửa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', 'Sửa thất bại');
        }
    }
}
