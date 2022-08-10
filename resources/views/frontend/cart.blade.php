@extends('frontend.app')
@section('content')
    <div class="px-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-0">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>
        <div class="row">
             <div class="col-12">
                    <div class="cart-table">
                    </div>
             </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        function renderCart() {
            let cart = JSON.parse(localStorage.getItem('cart'));
            let row = '<table class="table" id="cart">\n' +
                '                     <thead>\n' +
                '                        <tr>\n' +
                '                            <th>STT</th>\n' +
                '                            <th>Hình ảnh</th>\n' +
                '                            <th>Tên sản phẩm</th>\n' +
                '                            <th>Giá</th>\n' +
                '                            <th>Số lượng</th>\n' +
                '                            <th>Hành động</th>\n' +
                '                        </tr>\n' +
                '                     </thead>';

            let totalMoney = 0;
            for (let i = 0; i < cart?.length; i++) {
                totalMoney = totalMoney + (cart[i].price * cart[i].quantity)
                row += '<tr>\n' +
                    '                         <td>'+ (i + 1) +'</td>\n' +
                    '                         <td>\n' +
                    '                             <img src="/storage/'+ cart[i].thumbnail +'" style="width: 60px; height: 60px; object-fit: contain" alt="">\n' +
                    '                         </td>\n' +
                    '                         <td>'+ cart[i].name +'</td>\n' +
                    '                         <td>'+ cart[i].price +'</td>\n' +
                    '                         <td>'+ cart[i].quantity +'</td>\n' +
                    '                         <td>\n' +
                    '                             <i style="font-size: 25px" onclick="deleteCartItem('+i+')" class="text-danger fa fa-trash-o" aria-hidden="true"></i>\n' +
                    '                         </td>\n' +
                    '                     </tr>';
            }

            row += '</table>';

            row += '<div class="float-right">\n' +
'                            <table class="table d-inline">\n' +
'                                <tr>\n' +
'                                    <td>Tổng tiền:</td>\n' +
'                                    <td>'+ totalMoney.toLocaleString('it-IT', {style : 'currency', currency : 'VND'}) +'</td>\n' +
'                                </tr>\n' +
                                '<tr>' +
                '                   <td>Phương thưc thanh toán:</td>' +
                '                   <td>' +
                '                       <div class="custom-control custom-radio custom-control-inline">\n' +
                '                           <input value="vnpay" type="radio" id="customRadioInline1" name="payment_method" class="custom-control-input">\n' +
                '                           <label class="custom-control-label" for="customRadioInline1">VNPAY</label>\n' +
                '                    </div>' +
                '                       <div class="custom-control custom-radio custom-control-inline">\n' +
                '                           <input value="payment_on_delivery" checked type="radio" id="customRadioInline2" name="payment_method" class="custom-control-input">\n' +
                '                           <label class="custom-control-label" for="customRadioInline2">Thanh toán khi nhận hàng</label>\n' +
                '                       </div>' +
                '                   </td>' +
'                            </table>\n' +
'                            <button id="order" class="btn btn-primary btn-block mt-4">Đặt hàng</button>\n' +
'                        </div>';

            if (!cart?.length) {
                row = '<div class="d-block text-center text-danger my-4">' +
                    '<img style="width: 120px" class="img-fluid" src="{{ asset('frontend/asset/images/shopping-cart.png') }}">' +
                    '<h4 class="font-weight-bold text-danger mt-3">Chưa có sản phẩm</h4>' +
                    '</div>';
            }


            $('.cart-table').html(row);
        }

        renderCart();

        function deleteCartItem(i){
            let cart = JSON.parse(localStorage.getItem('cart'));
            cart.splice(i, 1);
            console.log(cart);
            $('.number-product-cart').text(cart.length)
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }


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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#order').click(function () {
            let cart = localStorage.getItem('cart');
            let paymentMethod = $("input[name='payment_method']:checked").val();
            console.log(paymentMethod)
            $.ajax({
                url: '/order',
                type: 'POST',
                data: {cart: cart, 'payment_method': paymentMethod},
                success: function (data) {
                    console.log(data)
                    if (data.result) {
                        localStorage.removeItem('cart');
                        if (data.methodPay == 'vnpay') {
                            window.location.href = '/payment/' + data.order.id
                        }
                         renderCart();
                        iziToast.success({
                            position: 'topRight',
                            message: 'Đặt mua thành công',
                        });

                    }
                },
                error: function (data) {
                    if (data.status == 401) {
                        location.href = '/dang-nhap';
                    }
                }
            });
        })
    </script>
@endsection
