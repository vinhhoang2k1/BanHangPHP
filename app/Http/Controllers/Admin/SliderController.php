<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\SliderRequest;
use App\Models\Category;
use App\Models\Slider;
use App\Models\User;
use App\Services\UploadService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SliderController extends Controller
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
        $sliders = Slider::all();

        $id = $request->query('id');
        $sliderDB = Slider::find($id);

        return view('admin.slider.slider-list', compact('sliders', 'sliderDB'));
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
    public function store(SliderRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();
            $data['slug'] = Str::slug($data['title']);
            $data['image'] = $this->uploadService->upload($data['image'] ?? '', 'image');
            Slider::create($data);
            DB::commit();

            return redirect()->route('sliders.index')->with('success', 'Thêm thành công');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
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
    public function edit(Category $category)
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
    public function update(SliderRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $model = Slider::find($id);
            $data = $request->validated();
            $data['image'] = $this->uploadService->handleFileUpdate($data['image'] ?? '', $model->image, 'slider');
            Slider::where('id', $id)->update($data);
            DB::commit();

            return redirect()->route('sliders.index')->with('success', 'Sửa thành công');
        } catch (\Exception $exception) {
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
            $slider= Slider::find($id);
            $this->uploadService->delete([$slider->image]);
            Slider::destroy($id);
            DB::commit();

            return redirect()->route('sliders.index')->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', 'Xóa thất bại');
        }
    }
}
