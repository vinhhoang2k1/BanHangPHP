@extends('admin.app')
@section('title', 'Danh sách Khách hàng')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Quản lý Khách hàng</a></div>
        <div class="breadcrumb-item">Danh sách Khách hàng</div>
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
                                <th class="text-center">ID</th>
                                <th class="text-center">Ảnh đại diện</th>
                                <th>Tên</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Email</th>
                                <th class="text-center">Trạng thái</th>
{{--                                <th class="text-center">Tác vụ</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td class="text-center">{{ $customer->id }}</td>
                                    <td class="text-center">
                                        <figure class="avatar mr-2">
                                            <img src="{{ asset($customer->avatarPath) }}"  alt="">
                                        </figure>
                                    </td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td class="text-center">
                                        @if($customer->status == 'active')
                                            <span class="badge badge-info">Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
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
