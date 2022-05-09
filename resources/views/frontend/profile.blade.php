@extends('frontend.app')
@section('content')
    <div class="px-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-0">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
            </ol>
        </nav>
        <div class="row my-5">
            <div class="col-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile">Thông tin cá nhân</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#change-password">Đổi mật khẩu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#order-history">Lịch sử đặt hàng</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="profile">
                        <div class="row">
                            <div class="col-sm-9 mx-auto">
                                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input id="file-upload" onchange="loadFile(event)" name="avatar" type="file" class="d-none">
                                        <div class="avatar-profile mx-auto">
                                            <img class="thumbnail-upload" src="{{ $customer->avatar_path }}" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label text-right">Tên</label>
                                        <input id="name" value="{{ old('name', $customer->name) }}" type="name" class="col-sm-9 form-control @error('name') is-invalid @enderror" name="name" tabindex="1">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-3 col-form-label text-right">Email</label>
                                        <input id="email" value="{{ old('email', $customer->email) }}" type="email" class="col-sm-9 form-control @error('email') is-invalid @enderror" name="email" tabindex="1" >
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-3 col-form-label text-right">Số điện thoại</label>
                                        <input id="phone" value="{{ old('phone', $customer->phone) }}" type="text" class="col-sm-9 form-control @error('phone') is-invalid @enderror" name="phone" tabindex="1" >
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-3 col-form-label text-right">Địa chỉ</label>
                                        <input id="address" value="{{ old('address', $customer->address) }}" type="text" class="col-sm-9 form-control @error('address') is-invalid @enderror" name="address" tabindex="1" >
                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-3 col-form-label text-right">Mật khẩu</label>
                                        <input id="password" type="password" class="col-sm-9 form-control @error('password') is-invalid @enderror" name="password" tabindex="2" >
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-sm-3 col-form-label text-right">Xác nhận mật khẩu</label>
                                        <input id="password_confirmation" type="password" class="col-sm-9 form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" tabindex="2" >
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-5">
                                        <button class="btn btn-primary">Cập nhật</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="change-password">...</div>
                    <div class="tab-pane container fade" id="order-history">
                        <table class="table" id="cart">
                            <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $item)
                                    <tr>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->total_money }}</td>
                                        <td>
                                            @if($item->status == 'success')
                                                <span class="badge badge-success">Thành công</span>
                                            @else
                                                <span class="badge badge-warning">Đang chờ xử lý</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('order.detail', $item) }}">Xem chi tiết</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        function loadFile(event) {
            var output = document.getElementsByClassName('thumbnail-upload')[0];
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

        $('.thumbnail-upload').click(function () {
            $('#file-upload').click();
        });


    </script>
@endsection
