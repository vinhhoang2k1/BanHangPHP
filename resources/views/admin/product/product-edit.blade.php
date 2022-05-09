@extends('admin.app')
@section('title', 'Sửa sản phẩm')
@section('header')
    <h1></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Quản lý sản phẩm</a></div>
        <div class="breadcrumb-item "><a href="#">Sửa sản phẩm</a></div>
    </div>
@endsection
@section('main-content')
    <div class="row">
        <ul class="nav align-items-center my-4 w-100">
            <li>
                <h4 class="title">Thông tin sản phẩm</h4>
            </li>
        </ul>
        <div class="card w-100">
            <div class="card-body">
                <form action="{{ route('products.update', $product)}}" method="post" enctype="multipart/form-data" id="my-form">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('name', $product->name) }}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên sản phẩm">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <select name="category_id" class="form-control select2" style="width:100%;">
                                    @foreach($categories as $category)
                                        @if(old('post_category_id', $product->post_category_id) == $category['id'])
                                            <option selected value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @else
                                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    @foreach(config('constants.status') as $key => $value)
                                        @if(old('status', $product->status) == $key)
                                            <option selected value="{{ $key }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Mô tả ngắn</label>
                                <textarea name="short_content" id="short_content" class="form-control @error('short_content') is-invalid @enderror" placeholder="Nhập mô tả ngắn">{{ old('short_content', $product->short_content) }}</textarea>
                                @error('short_content')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Giá sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('price', $product->price) }}" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Nhập tên giá">
                                @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Số lượng sản phẩm<span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('quantity', $product->quantity) }}" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="Nhập giá sản phẩm">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" id="text" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" value="1" @if(old('selling_product', $product->selling_product)) checked @endif name="selling_product" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Sản phẩm bán chạy</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" value="1" @if(old('new_product', $product->new_product)) checked @endif name="new_product" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Sản phẩm mới</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" value="1" name="common" @if(old('common', $product->common)) checked @endif class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Phổ biến</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hình thumbnail</label>
                        <div class="thumbnail">
                            <input type="file" name="thumbnail" onchange="loadFile(event)" id="file-upload" class="d-none">
                            <img class="img-fluid thumbnail-upload" style="width: 100px; height: 130px; object-fit: cover; object-position: center" src="{{ asset( $product->thumbnailPath) }}" alt="">
                        </div>
                    </div>
                    <div class="form-group">
                        <ul class="nav">
                            <li class="ml-auto">
                                <button type="submit" class="btn btn-primary ">
                                    <svg class="icon-action" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16L21 8V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M17 21V13H7V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7 3V8H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="pl-1">Lưu</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js')}}"></script>
    <script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js')}}"></script>
    <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
    <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('assets/js/page/forms-advanced-forms.js')}}"></script>

    <script src={{ url('ckeditor/ckeditor.js') }}></script>
    <script>
        CKEDITOR.replace( 'text', {
            filebrowserBrowseUrl     : "{{ route('ckfinder_browser') }}",
            filebrowserImageBrowseUrl: "{{ route('ckfinder_browser') }}?type=Images&token=123",
            filebrowserFlashBrowseUrl: "{{ route('ckfinder_browser') }}?type=Flash&token=123",
            filebrowserUploadUrl     : "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Files",
            filebrowserImageUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images",
            filebrowserFlashUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Flash",
        } );

        function loadFile(event) {
            var output = document.getElementsByClassName('thumbnail-upload')[0];
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

        $('.btn-save').click(function () {
            $('#my-form').submit();
        })
    </script>
    @include('ckfinder::setup')
@endsection

