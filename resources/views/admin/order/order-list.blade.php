@extends('admin.app')
@section('title', 'Danh sách đơn hàng')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Quản lý đơn hàng</a></div>
        <div class="breadcrumb-item active">Danh sách đơn hàng</div>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-md">
                        <table class="table table-striped" id="table-my">
                            <thead>
                                <tr>
                                <th class="text-center">Mã</th>
                                <th>Tên khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Tổng tiền</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->code }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->customer->phone }}</td>
                                    <td>{{ $order->total_money }}</td>
                                    <td class="text-center">
                                        @if($order->status == 'success')
                                            <span class="badge badge-success">Thành công</span>
                                        @else
                                            <span class="badge badge-warning">Đang chờ xử lý</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.detail', $order) }}" class="text-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    @dump($userDB)--}}
@endsection

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">@endsection
@section('scripts')
    <script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>

        $(document).ready(function () {
            let dataTable = $("#table-my").dataTable({
                // dom: '<"top display-flex justify-content-between"lBf>t<ip>',
                language: {
                    paginate: {
                        next: 'Trước',
                        previous: 'Tiếp theo'
                    },
                    "lengthMenu": "Hiển thị _MENU_",
                    "search":         "Tìm kiếm:",
                    "emptyTable": 'Chưa có dữ liệu',
                    "info":           "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "infoEmpty":           "Hiển thị 0 đến 0 của 0 mục",
                    "zeroRecords":    "Không khớp với dữ nào",
                    // "processing":     loader,
                    "infoFiltered":   "(lọc từ _MAX_ mục)",
                },
                columnDefs: [
                    {
                        orderable: false,
                        targets: [1, 2, 3, 4, 5]
                    }
                ],
                "order": [[ 0, "desc" ]],
            });
        });
    </script>
@endsection
