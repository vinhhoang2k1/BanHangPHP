<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\UploadService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductController extends Controller
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

        $products = Product::all();

        return view('admin.product.product-list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.product.product-create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            $data['thumbnail'] = $this->uploadService->upload($data['thumbnail'] ?? '', 'product');
            Product::create($data);
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Thêm thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());

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
     * @param  \App\Models\Category  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.product.product-edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(CreateProductRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $model = Product::find($id);
            $data = $request->validated();
            if (empty($data['selling_product'])) {
                $data['selling_product'] = 0;
            }

            if (empty($data['new_product'])) {
                $data['new_product'] = 0;
            }

            if (empty($data['common'])) {
                $data['common'] = 0;
            }
            $data['thumbnail'] = $this->uploadService->handleFileUpdate($data['thumbnail'] ?? '', $model->thumbnail, 'category');
            $product = Product::where('id', $id)->update($data);

//            dd($product);
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Sửa thành công');
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
            $category = Product::find($id);
            $this->uploadService->delete([$category->thumbnail]);
            Product::destroy($id);
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', 'Xóa thất bại');
        }
    }
}
