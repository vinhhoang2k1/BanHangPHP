<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderInfo;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        $order = Order::with(['orderItems.product', 'customer'])->where('id', $id)->first();

        return view('admin.order.order-detail', compact('order'));
    }

    public function updateStatus(Request $request) {
        $status = $request->input('status');
        $orderId = $request->input('id');

        Order::where('id', $orderId)->update(['status' => $status]);
        if ($status == 'success') {
            $orderItems = OrderItem::where('order_id', $orderId)->get();
            foreach ($orderItems as $item) {
                Product::where('id', $item->product_id)->decrement('quantity', $item->quantity);
            }
        }

        $order = Order::with(['orderItems.product', 'customer'])->where('id', $orderId)->first();

        Mail::to($order->customer)->queue(new OrderInfo($order));

        return response()->json(['result' => true]);
    }
}
