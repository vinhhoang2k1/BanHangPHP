<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderInfo;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('customer')->get();

        return view('admin.order.order-list', compact('orders'));
    }

    public function detail($id) {
        $order = Order::with(['orderItems.product', 'customer'])->first();

        return view('admin.order.order-detail', compact('order'));
    }

    public function updateStatus(Request $request) {
        $status = $request->input('status');
        $orderId = $request->input('id');

        Order::where('id', $orderId)->update(['status' => $status]);

        if ($status == 'success') {
            $order = Order::with(['orderItems.product', 'customer'])->first();

            Mail::to($order->customer)->queue(new OrderInfo($order));
        }

        return response()->json(['result' => true]);
    }
}
