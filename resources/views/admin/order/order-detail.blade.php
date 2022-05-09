@extends('admin.app')
@section('title', 'Danh sách đơn hàng')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Quản lý đơn hàng</a></div>
        <div class="breadcrumb-item active">Chi tiết đơn hàng</div>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h2>Hóa đơn</h2>
                                        <div class="invoice-number">Mã đơn hàng #12345</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>Thông tin khách hàng:</strong><br>
                                                {{ $order->customer->name }}<br>
                                                {{ $order->customer->email }}<br>
                                                {{ $order->customer->phone }}<br>
                                                {{ $order->customer->address }}
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Địa chỉ nhận hàng:</strong><br>
                                                {{ $order->customer->name }}<br>
                                                {{ $order->customer->email }}<br>
                                                {{ $order->customer->phone }}<br>
                                                {{ $order->customer->address }}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>Phương thức thanh toán:</strong><br>
                                                Thanh toán khi nhận hàng<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Ngày đặt:</strong><br>
                                                {{ $order->created_at }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">Tóm tắt đơn hàng</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tbody>
                                            <tr>
                                                <th data-width="40" style="width: 40px;">#</th>
                                                <th>Tên sản phẩm</th>
                                                <th class="">Hình ảnh</th>
                                                <th class="text-center">Giá</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-right">Tổng</th>
                                            </tr>
                                            @foreach($order->orderItems as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>
                                                        <img src="{{ asset($item->product->thumbnail_path) }}" style="width: 60px; height: 60px; object-fit: contain" alt="">
                                                    </td>
                                                    <td class="text-center">{{ $item->price_format }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-right">{{ $item->total_money_format }}</td>
                                                </tr>
                                            @endforeach

                                            </tbody></table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-8">
                                            <div class="section-title">Payment Method</div>
                                            <p class="section-lead">The payment method that we provide is to make it easier for you to pay invoices.</p>
                                            <div class="images">
                                                <img src="{{ asset('assets/img/visa.png') }}" alt="visa">
                                                <img src="{{ asset('assets/img/jcb.png') }}" alt="jcb">
                                                <img src="{{ asset('assets/img/mastercard.png') }}" alt="mastercard">
                                                <img src="{{ asset('assets/img/paypal.png') }}" alt="paypal">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Tổng</div>
                                                <div class="invoice-detail-value">{{ $order->total_money_format }}</div>
                                            </div>
{{--                                            <div class="invoice-detail-item">--}}
{{--                                                <div class="invoice-detail-name">Shipping</div>--}}
{{--                                                <div class="invoice-detail-value">$15</div>--}}
{{--                                            </div>--}}
                                            <hr class="mt-2 mb-2">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Tổng tiền</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">{{ $order->total_money_format }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <h5>Trạng thái đơn hàng</h5>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="pending" @if($order->status == 'pending') checked @endif id="pending" name="status" class="custom-control-input">
                                <label class="custom-control-label" for="pending">Đang chờ xử lý</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="success" @if($order->status == 'success') checked @endif onclick="confirmation(this)" id="success" name="status" class="custom-control-input">
                                <label class="custom-control-label" for="success">Thành công</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" value="cancel" @if($order->status == 'cancel') checked @endif onclick="confirmation(this)" id="cancel" name="status" class="custom-control-input">
                                <label class="custom-control-label" for="cancel">Hủy</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('links')
@section('scripts')
    <script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
     <script>

         @if($order->status != 'pending')
             $("input[name='status']").prop('disabled', true);
         @endif
         function confirmation(obj) {
             swal({
                 title: 'Thay đổi trạng thái?',
                 text: 'Sau khi đổi trạng thái bạn sẽ không thể thay đổi lại!',
                 icon: 'warning',
                 buttons: true,
                 dangerMode: true,
             })
             .then((willDelete) => {
                 let status = $(obj).val();
                 let orderId = {{ $order->id }};
                 if (willDelete) {
                     $.post('/admin/orders/update-status', {id: orderId, status: status}, function (data) {
                         if (data.result == true) {
                             iziToast.success({
                                 position: 'topRight',
                                 message: 'Thay đổi trạng thái thành công',
                             });
                             $("input[name='status']").prop('disabled', true);
                         }
                     })
                 } else {
                     $('#pending').prop('checked', true);
                 }
             });
         }
    </script>
@endsection
