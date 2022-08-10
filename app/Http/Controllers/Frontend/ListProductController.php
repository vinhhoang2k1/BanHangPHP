<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListProductController extends Controller
{
    public function index(Request $request) {

        $categories = Category::withCount(['products' => function(Builder $builder) {
            $builder->where('status', 'active');
        }])->where('status', 'active')->limit(8)->get();

        $categoryID = $request->query('category_id');

        $query = Product::where('status', 'active');
        if ($categoryID) {
            $query = $query->where('category_id', $categoryID);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        $products = $query->paginate(6)->withQueryString();

//        dd($categories);
        return view('frontend.list',
            compact('categories', 'products')
        );
    }

    public function getMoreCategory($idx) {
        $categories = Category::withCount(['products' => function(Builder $builder) {
            $builder->where('status', 'active');
        }])->where('status', 'active')->offset(8 + ($idx * 5))->limit(5)->get();

        return response()->json($categories);
    }
}
