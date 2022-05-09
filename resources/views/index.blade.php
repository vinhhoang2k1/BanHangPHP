@extends('frontend.app')
@section('content')
    <div id="slideshow" style="margin-top: 15px;">
        @foreach($sliders as $item)
            <div class="row slide-item">
                <div class="col-m-6 col-l-7 col-0">
                    <div class="slide_item_left">
                        <h2 class="title_slide">{{ $item->title }}</h2>
                        <p class="slide_content">
                           {{ $item->description }}
                        </p>

                        <button class="btn-slide">Xem chi tiết</button>
                    </div>
                </div>

                <div class="col-m-6 col-l-5 col-12">
                    <div class="slide_item_right">
                        <div class="shape"></div>
                        <div class="img">
                            <img src="{{ asset($item->image_path) }}" alt="">

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="slide_activity">
            <span id="prev-slide"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
            <span id="slide-current"> <span class="slider-active"></span> / <span>{{ $sliders->count() }}</span></span>
            <span id="next-slide"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
        </div>
    </div>
    <div class="policy">
        <div class="row">
            <div class="col-l-3 col-m-6 col-12">
                <div class="policy-item">
                    <div style="display: flex; align-items: center;">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <span class="title">Miễn phí giao hàng</span> <br>
                        <span>Miến phí với đơn hàng > 239k</span>
                    </div>
                </div>

            </div>
            <div class="col-l-3 col-m-6 col-12">
                <div class="policy-item">
                    <div style="display: flex; align-items: center;">
                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <span class="title">Thanh toán COD</span> <br>
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </div>
                </div>

            </div>
            <div class="col-l-3 col-m-6 col-12">
                <div class="policy-item">
                    <div style="display: flex; align-items: center;">
                        <i class="fa fa-diamond" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <span class="title">Khách hàng VIP</span> <br>
                        <span>Ưu đãi dành cho khách hàng VIP</span>
                    </div>
                </div>

            </div>
            <div class="col-l-3 col-m-6 col-12">
                <div class="policy-item">
                    <div style="display: flex; align-items: center;">
                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    </div>
                    <div class="content">
                        <span class="title">Hỗ trợ đổi hàng</span> <br>
                        <span>Đổi sửa lại tất cả store</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="top-product">
        <h3 class="title">Top sản phẩm bán chạy hàng đầu</h3>

        <div class="row">
            @foreach($sellingProducts as $item)
                <div class="col-l-3 col-m-6 col-12 mb-3">
                    <div class="top-product-item" style="text-align: center;">
                        <div class="img-product">
                            <img src="{{ asset($item->thumbnailPath) }}" alt="">
                        </div>
                        <div class="product-info">
                            <span class="product_name">{{ $item->name }}</span> <br>
                            <span class="product-price-sale">{{ number_format($item->price) }}</span>
{{--                            <span class="product-price">{{ $item->price }}</span>--}}
                        </div>

                        <button class="btn-product">Chọn mua</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="top-product">
        <h3 class="title">Sản phẩm mới</h3>

        <div class="row">
            @foreach($newProducts as $item)
                <div class="col-l-3 col-m-6 col-12 mb-3">
                    <div class="top-product-item" style="text-align: center;">
                        <div class="img-product">
                            <img src="{{ asset($item->thumbnailPath) }}" alt="">
                        </div>
                        <div class="product-info">
                            <span class="product_name">{{ $item->name }}</span> <br>
                            <span class="product-price-sale">{{ number_format($item->price) }}</span>
                            {{--                            <span class="product-price">{{ $item->price }}</span>--}}
                        </div>

                        <button class="btn-product">Chọn mua</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="banner" style="padding: 0 15px;">
        <div class="row">
            <div class="col-l-12">
                <img src="{{ asset('frontend/asset/images/banner.png') }}" alt="">
            </div>
        </div>
    </div>

    <div class="top-product">
        <h3 class="title">Phổ biến</h3>
        <div class="row">
            @foreach($commonProducts as $item)
                <div class="col-l-3 col-m-6 col-12 mb-3">
                    <div class="top-product-item" style="text-align: center;">
                        <div class="img-product">
                            <img src="{{ asset($item->thumbnailPath) }}" alt="">
                        </div>
                        <div class="product-info">
                            <span class="product_name">{{ $item->name }}</span> <br>
                            <span class="product-price-sale">{{ number_format($item->price) }}</span>
                            {{--                            <span class="product-price">{{ $item->price }}</span>--}}
                        </div>

                        <button class="btn-product">Chọn mua</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
