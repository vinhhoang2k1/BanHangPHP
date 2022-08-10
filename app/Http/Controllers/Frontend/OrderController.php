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
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method != 'vnpay' ? 1 : 0,
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
            $methodPay = $request->input('payment_method');
            DB::commit();

            return response()->json(['result' => true, 'order' => $order, 'methodPay' => $methodPay]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json(['result' => false]);
        }
    }

    public function detail($id) {

        $orderItems = OrderItem::with('product')->where('order_id', $id)->get();

        return view('frontend.order-detail', compact('orderItems'));
    }

    public function vnPayPayment($id)
    {
        $order = Order::find($id);
        $vnp_TmnCode = env('VNP_TMNCODE'); //Mã website tại VNPAY
        $vnp_HashSecret = env('VNP_HASHSECRET'); //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://fashion-accessories.test/return-vnpay/" . $order->id;
        $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->total_money * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request, $id) {
        if ($request->vnp_ResponseCode == '00') {

            Order::where('id', $id)->update(['payment_status' => 1]);
            return redirect()->route('cart')->with('success', 'Giao dịch thành công');
        }
        else {
            return redirect()->route('cart')->with('success', 'Giao dịch thất bại');
        }
    }
}
