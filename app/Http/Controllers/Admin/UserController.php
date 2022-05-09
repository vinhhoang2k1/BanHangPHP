<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UploadService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();

        $id = $request->query('id');
        $userDB = User::find($id);

//        dd($user);

        return view('admin.user.user-list', compact('users', 'userDB'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();
            unset($data['password_confirmation']);
            $data['password'] = Hash::make($data['password']);
            $data['avatar'] = $this->uploadService->upload($data['avatar'] ?? '', 'avatar');
            User::create($data);
            DB::commit();

            return redirect()->route('users.index')->with('success', 'Thêm thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', 'Thêm thất bại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $model = User::find($id);
            $data = $request->validated();
            unset($data['password_confirmation']);
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
//            dd($data['avatar']);
            $data['avatar'] = $this->uploadService->handleFileUpdate($data['avatar'] ?? '', $model->avatar, 'avatar');
            User::where('id', $id)->update($data);
            DB::commit();

            return redirect()->route('users.index')->with('success', 'Sửa thành công');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            DB::rollBack();

            return back()->with('error', 'Sửa thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);
            $this->uploadService->delete([$user->avatar]);
            User::destroy($id);
            DB::commit();

            return redirect()->route('users.index')->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', 'Xóa thất bại');
        }
    }
}
