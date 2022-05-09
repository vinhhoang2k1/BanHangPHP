<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index() {
//        return Auth::guard('customer')->id();
        $sellingProducts = Product::where('status', 'active')->where('selling_product', 1)->get();
        $commonProducts = Product::where('status', 'active')->where('common', 1)->get();
        $newProducts = Product::where('status', 'active')->where('new_product', 1)->get();
        $sliders = Slider::where('status', 'active')->get();
//        dd($commonProducts);
        return view('index', compact('sellingProducts', 'commonProducts', 'newProducts', 'sliders'));
    }
}
