@extends('frontend.app')
@section('content')
    <div class="px-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-0">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-4 col-md-3">
                <img class="img-fluid" src="{{ asset($product->thumbnail_path) }}" alt="">
            </div>
            <div class="col-lg-5 col-md-6">
                <h3 class="font-weight-bold">{{ $product->name }}</h3>
                <h5 class="text-danger font-weight-bold">Giá: {{ $product->price_format }}</h5>
                <h5>Có sẵn: <span class="quantity-product">{{$product->quantity}}</span></h5>
                <p>{{ $product->short_content }}</p>
                <div>
                    <div class="d-inline-flex border-success border text-center" style="height: 30px; font-size: 20px">
                        <span class="border-success border-right amount-minus" style="width: 30px">-</span>
                        <span class="quantity" style="width: 80px">1</span>
                        <span class="border-success border-left amount-plus" style="width: 30px">+</span>
                    </div>
                </div>
                <button class="btn btn-outline-success mt-3"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Chọn mua</button>
                <button class="btn btn-outline-warning mt-3" id="addToCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Thêm giỏ hàng</button>
            </div>
            <div class="col-md-3 d-none d-md-block">
                <h4 class="font-weight-bold">Danh mục mới nhất</h4>
                <ul class="nav flex-column">
                    @foreach($categories as $item)
                        <li class="nav-item mb-3">
                            <a href="{{ route('list-product.index', ['category_id' => $item->id]) }}">
                                <div class="d-flex">
                                    <div style="width: 80px">
                                        <img src="{{ asset($item->thumbnail_path) }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="pl-2">
                                        <p class="font-weight-bold">{{ $item->name }}</p>
                                        <p class="font-weight-light text-secondary">{{ $item->created_at_format }}</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-9">
               {!! $product->description !!}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let product = {{ \Illuminate\Support\Js::from($product) }}
        $('.amount-minus').click(function () {
            let amount = parseInt($('.quantity').text());
            if (amount > 1) {
                $('.quantity').text(amount - 1)
            }
        });

        $('.amount-plus').click(function () {
            let quantityAvariable = parseInt($('.quantity-product').text());
            let quantity = parseInt($('.quantity').text());
            console.log(quantity + '-' + quantityAvariable)
            if (quantity + 1 <= quantityAvariable) {
                $('.quantity').text(quantity + 1)
            }
        });
        console.log(product)
        $('#addToCart').click(function () {
            let cartItem = {
                id: product.id,
                name: product.name,
                price: product.price,
                thumbnail: product.thumbnail
            };

            let cart = localStorage.getItem('cart');
            cart = JSON.parse(cart);
            // console.log(cart)
            let quantity = parseInt($('.quantity').text());
            if( cart?.length > 0 ) {

                let cartIds = Object.keys(cart).map(index => {
                    return cart[index].id
                });

                if (cartIds.includes(product.id)) {
                    cart[cartIds.indexOf(product.id)].quantity = cart[cartIds.indexOf(product.id)].quantity + quantity
                } else {
                    cartItem.quantity = quantity;
                    cart.push(cartItem)
                }

            } else {
                cart = [];
                cartItem.quantity = quantity;
                cart[0] = cartItem;
            }

            $('.number-product-cart').text(cart.length)
            localStorage.setItem('cart', JSON.stringify(cart));
        });

    </script>
@endsection
