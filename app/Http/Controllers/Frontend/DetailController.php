<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detail($slug) {

        $product = Product::where('slug', $slug)->first();
        $categories = Category::where('status', 'active')->orderByDesc('id')->limit(5)->get();

        return view('frontend.detail',
            compact('product', 'categories')
        );
    }
}
