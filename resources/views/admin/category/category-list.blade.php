@extends('admin.app')
@section('title', 'Danh sách danh mục')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Quản lý danh mục</a></div>
        <div class="breadcrumb-item active">Danh sách danh mục</div>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav">
                        <li class="ml-auto mb-3">
                            <a href="#myModal" class="btn btn-primary" data-toggle="modal">
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
                                @foreach($categories as $category)
                                <tr>
                                    <td class="text-center">{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <img src="{{ asset($category->thumbnailPath) }}" alt="" style="width: 50px; height: 50px; object-fit: cover">
                                    </td>
                                    <td>{{ $category->created_at }}</td>
                                    <td class="text-center">
                                        @if($category->status == 'active')
                                            <span class="badge badge-info">Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('categories.index', ['id' => $category]) }}" class="text-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form class="d-inline-block ml-2" method="post" id="form-delete-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}">
                                            @method('DELETE')
                                            @csrf
                                            <a type="button" onclick="deleteRow({{ $category->id }})" title="Xóa" class="text-danger">
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
{{--    @dump($userDB)--}}
@endsection
@section('modal')
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm mới danh mục</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    @foreach(config('constants.status') as $key => $status)
                                        <option @if($key == old('status')) selected @endif @empty($key) disabled @endif value="{{ $key }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <div class="avatar">
                                    <input type="file" name="thumbnail" onchange="loadFile(event)" id="file-upload" class="d-none">
                                    <img class="thumbnail-upload" src="{{ asset('assets/img/thumbnail.png') }}" alt="">
                                </div>
                                @error('thumbnail')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-info" >Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty(!$categoryDB)
        <div class="modal" id="myModal-update">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('categories.update', $categoryDB) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="id" value="{{ $categoryDB->id }}" class="d-none">
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Sửa danh mục</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="name">Tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $categoryDB->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(config('constants.status') as $key => $status)
                                            <option @if($key == old('status', $categoryDB->status)) selected @endif @empty($key) disabled @endif value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Ảnh đại diện</label>
                                    <div class="avatar">
                                        <input type="file" name="thumbnail" onchange="loadFileUpdate(event)" id="file-upload-update" class="d-none">
                                        <img class="thumbnail-upload-update" src="{{ asset($categoryDB->thumbnailPath) }}" alt="">
                                    </div>
                                    @error('thumbnail')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-info" >Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endempty
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

        function loadFileUpdate(event) {
            var output = document.getElementsByClassName('thumbnail-upload-update')[0];
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

        @if($errors->any())
            $('#myModal').modal('show');
        @endif

        $('.thumbnail-upload-update').click(function () {
            $('#file-upload-update').click();
        });

        @if($errors->any())
        $('#myModal-update').modal('show');
        @endif

        @empty(!$categoryDB)
            $('#myModal-update').modal('show');
        @endempty

        function deleteRow(id) {
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
                    $('#form-delete-' + id).submit();
                }
            })
        }
    </script>
@endsection
