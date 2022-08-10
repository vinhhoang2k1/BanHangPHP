@extends('admin.app')
@section('title', 'Danh sách người dùng')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Quản lý người dùng</a></div>
        <div class="breadcrumb-item">Danh sách người dùng</div>
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
                                <th class="text-center">Ảnh đại diện</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td class="text-center">
                                        <figure class="avatar mr-2">
                                            <img src="{{ asset($user->avatarPath) }}"  alt="">
                                        </figure>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        @if($user->status == 'active')
                                            <span class="badge badge-info">Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('users.index', ['id' => $user]) }}" class="text-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form class="d-inline-block ml-2" method="post" id="form-delete-{{ $user->id }}" action="{{ route('users.destroy', $user) }}">
                                            @method('DELETE')
                                            @csrf
                                            <a type="button" onclick="deleteRow({{ $user->id }})" title="Xóa" class="text-danger">
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
                <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm mới người dùng</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
                                <label>Chức vụ <span class="text-danger">*</span></label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror">
                                    <option disabled selected value="">Chọn chức vụ</option>
                                    @foreach($roles as $key => $role)
                                        <option @if($role->id == old('role')) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <div class="avatar">
                                        <input type="file" name="avatar" onchange="loadFile(event)" id="file-upload" class="d-none">
                                        <img class="thumbnail-upload" src="{{ asset('assets/img/avatar/avatar-1.png') }}" alt="">
                                    </div>
                                    @error('avatar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
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
    @empty(!$userDB)
        <div class="modal" id="myModal-update">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('users.update', $userDB) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="id" value="{{ $userDB->id }}" class="d-none">
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Sửa người dùng</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $userDB->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $userDB->email) }}" id="email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(config('constants.status') as $key => $status)
                                            <option @if($key == old('status', $userDB->status)) selected @endif @empty($key) disabled @endif value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Chức vụ <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        @foreach($roles as $key => $role)
                                            <option @if($role->id == old('role', $userDB->roles->first()->id)) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Ảnh đại diện</label>
                                        <div class="avatar">
                                            <input type="file" name="avatar" onchange="loadFileUpdate(event)" id="file-upload-update" class="d-none">
                                            <img class="thumbnail-upload-update" src="{{ asset($userDB->avatarPath) }}" alt="">
                                        </div>
                                        @error('avatar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
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
        $('.thumbnail-upload').click(function () {
            $('#file-upload').click();
        });
        $('.thumbnail-upload-update').click(function () {
            $('#file-upload-update').click();
        });

        @if($errors->any())
        $('#myModal-update').modal('show');
        @endif

        @empty(!$userDB)
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
