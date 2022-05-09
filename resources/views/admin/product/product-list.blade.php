@extends('admin.app')
@section('title', 'Danh sách danh mục')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Quản lý sản phẩm</a></div>
        <div class="breadcrumb-item active">Danh sách sản phẩm</div>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav">
                        <li class="ml-auto mb-3">
                            <a href="{{ route('products.create') }}" class="btn btn-primary" >
                                <i class="fas fa-plus-circle"></i> Thêm mới
                            </a>
                        </li>
                    </ul>
                    <div class="table-responsive-md">
                        <table class="table table-striped" id="table-my">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Name</th>
                                <th>Hình ảnh</th>
                                <th>Ngày tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="text-center">{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img src="{{ asset($product->thumbnailPath) }}" alt="" style="width: 50px; height: 50px; object-fit: cover">
                                    </td>
                                    <td>{{ $product->created_at }}</td>
                                    <td class="text-center">
                                        @if($product->status == 'active')
                                            <span class="badge badge-info">Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('products.edit', $product) }}" class="text-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form class="d-inline-block ml-2" method="post" id="form-delete" action="{{ route('products.destroy', $product) }}">
                                            @method('DELETE')
                                            @csrf
                                            <a type="button" onclick="deleteRow()" title="Xóa" class="text-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </form>
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

        function loadFile(event) {
            var output = document.getElementsByClassName('thumbnail-upload')[0];
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

        function deleteRow() {
            swal({
                title: "Bạn có muốn xóa?",
                text: "Hành động này sẽ xóa đi dữ liệu!",
                icon: 'warning',
                buttons: {
                    cancel: {
                        text: "Hủy",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    delete: 'Đồng ý'
                },
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $('#form-delete').submit();
                }
            })
        }
    </script>
@endsection
