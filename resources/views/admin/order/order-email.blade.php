<div>
    <h3>Xin chào {{ $order->customer->name }}</h3>
    <h4>Chúng tôi gửi thông tin đơn hàng của bạn</h4>
    <table class="table table-striped table-hover table-md">
        <tbody>
        <tr>
            <th style="text-align: center; width: 40px;">#</th>
            <th>Tên sản phẩm</th>
            <th style="text-align: center">Hình ảnh</th>
            <th style="text-align: center">Giá</th>
            <th style="text-align: center">Số lượng</th>
            <th style="text-align: center">Tổng</th>
        </tr>
        @foreach($order->orderItems as $key => $item)
            <tr>
                <td style="text-align: center">{{ $key + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>
                    <img src="{{$message->embed(asset($item->product->thumbnail_path)) }}" style="width: 60px; height: 60px; object-fit: contain" alt="">
                </td>
                <td style="text-align: center">{{ $item->price_format }}đ</td>
                <td style="text-align: center">{{ $item->quantity }}</td>
                <td style="text-align: center">{{ $item->total_money_format }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <hr>
    <h4>Tổng tiền: {{ $order->total_money_format }} đ</h4>
    <h4>Cảm ơn đã tin tưởng sản phẩm của chúng tôi.</h4>
</div>
