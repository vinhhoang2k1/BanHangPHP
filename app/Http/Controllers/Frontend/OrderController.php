<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function cart() {
        return view('frontend.cart');
    }

    public function order(Request $request) {
        DB::beginTransaction();
        try {
            $cart = $request->input('cart');
            $cart = json_decode($cart, true);

            $dataOrder = [
                'customer_id' => Auth::guard('customer')->id(),
                'code' => Str::upper(Str::random(8)),
            ];

            $order = Order::create($dataOrder);


            $totalMoney = 0;
            foreach ($cart as $item) {
                $totalMoney += ($item['price'] * $item['quantity']);
                $dataOrderItem = [
                    'order_id' => $order->id,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'product_id' => $item['id'],
                    'total_money' => $item['price'] * $item['quantity']
                ];
                OrderItem::create($dataOrderItem);
            }

            Order::where('id', $order->id)->update(['total_money' => $totalMoney]);
            DB::commit();

            return response()->json(['result' => true]);
        } catch (\Exception $exception) {
            return response()->json(['result' => $exception->getMessage()]);
            DB::rollBack();

            return response()->json(['result' => false]);
        }
    }

    public function detail($id) {

        $orderItems = OrderItem::with('product')->where('order_id', $id)->get();

        return view('frontend.order-detail', compact('orderItems'));
    }
}
