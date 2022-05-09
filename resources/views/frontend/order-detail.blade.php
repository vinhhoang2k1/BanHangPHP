@extends('frontend.app')
@section('content')
    <div class="px-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-0">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
            </ol>
        </nav>
        <div class="row">
             <div class="col-12">
                    <div class="cart-table">
                        <table class="table" id="cart">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product_id }}</td>
                                        <td>
                                            <img src="{{ asset($item->product->thumbnail_path) }}" style="width: 60px; height: 60px; object-fit: contain" alt="">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
             </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
    </script>
@endsection
