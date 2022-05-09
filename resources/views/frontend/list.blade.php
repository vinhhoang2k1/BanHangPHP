@extends('frontend.app')
@section('content')
    <div class="px-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-0">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-4">
                <div class="border rounded">
                    <h5 class="text-center py-3 border-bottom">Lọc sản phẩm</h5>
                    <ul class="nav flex-column" id="list-category">
                        @foreach($categories as $item)
                            <li class="nav-item">
                                <a href="{{ route('list-product.index', ['category_id' => $item->id]) }}" class="nav-link border-bottom text-dark">{{ $item->name }}
                                    <span class="text-secondary float-right" style="font-size: 0.8rem">({{ $item->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <p class="text-center mt-3 mx-auto font-weight-bold" id="see-more">Xem thêm</p>
                <div class="mt-4">
                    <img src="{{ asset('frontend/asset/images/banner.png') }}" class="img-fluid" alt="">
                    <img src="{{ asset('frontend/asset/images/banner2.jpg') }}" class="d-block mt-3" height="200" width="100%" alt="">
                </div>
            </div>
            <div class="col-md-8">
                <div>
                    <img height="300px" class="img-fluid" src="{{ asset('frontend/asset/images/banner1.jpg') }}" alt="">
                </div>
                <div class="row mt-5">
                     @forelse($products as $item)
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <div class="top-product-item" style="text-align: center;">
                                <a href="{{ route('product.detail', ['slug' => $item->slug]) }}">
                                    <div class="img-product">
                                        <img src="{{ $item->thumbnail_path }}" alt="">
                                    </div>
                                    <div class="product-info">
                                        <span class="product_name">{{ $item->name }}</span> <br>
                                        <span class="product-price-sale">{{ $item->price_format }}₫</span>
                                        {{--                                    <span class="product-price">399,000</span>--}}
                                    </div>
                                </a>

                                <button class="btn-product">Chọn mua</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-danger w-100">Không có dữ liệu</p>
                    @endforelse
                </div>

                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let idx = 0;
        let seeMore = $('#see-more');
        seeMore.click(function () {
            console.log('abc')
            $.get('/list-product/getMoreCategory/'+ idx +'', function (data) {
                if (data.length == 0) {
                    seeMore.hide();
                }
                let htmlCategory = '';
                for (let i = 0; i < data.length; i++) {
                    htmlCategory += '<li class="nav-item">\n' +
        '                                <a href="" class="nav-link border-bottom text-dark">'+ data[i].name +'\n' +
        '                                    <span class="text-secondary float-right" style="font-size: 0.8rem">('+ data[i].products_count +')</span>\n' +
        '                                </a>\n' +
        '                            </li>';
                }
                $('#list-category').append(htmlCategory);
                idx++;
            })
        })
    </script>
@endsection
