<input type="checkbox" id="checkbox_nav" style="display: none;">
<label for="checkbox_nav" class="overlay"></label>
<div class="nav_tablet">
    <ul class="content_nav_tablet">
        <li>
            <a href="" class="logo">
                <img src="./asset/images/Logo-2.png" alt="">
            </a>

            <label for="checkbox_nav" class="close_nav"><i class="fa fa-times" aria-hidden="true"></i></label>
        </li>
        <li style="margin-top: 20px;">
            <a class="active" href="">Trang chủ</a>
        </li>
        <li>
            <a href="{{ route('list-product.index') }}">Sản phẩm</a>
        </li>
        <li>
            <a href="">Liên hệ</a>
        </li>
        @if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
        <li>
            <a href="">Đăng xuất</a>
        </li>
        @endif
    </ul>
    <!-- <svg id="nav-tablet-img" version="1.2" baseProfile="tiny-ps" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 200" width="300" height="120">
        <title>Dự án mới</title>
        <defs>
            <image width="500" height="200" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAADIAQMAAAAk14GrAAAAAXNSR0IB2cksfwAAAANQTFRF////p8QbyAAAACNJREFUeJztwTEBAAAAwqD1T20ND6AAAAAAAAAAAAAAAAB4NjIAAAGmV0+ZAAAAAElFTkSuQmCC" />
        </defs>

        <use id="Background" href="#img1" x="0" y="0" />
        <path id="Đổ màu Solid 4" class="shp0" d="M0 116C0 116 52 49.38 145 86C238 122.62 178.85 -17.46 322 60.63C377 90.63 398 119.37 449 100C500 80.63 500 80 500 80L500 200L0 200L0 116ZM0 116L0 116ZM0 113L0 113ZM0 75C0 75 56 52 70 75.63C70 76.63 0 98.37 0 118C0 137.63 0 75 0 75ZM500 43L500 77.63C500 77.63 405 154 324 59.63C382 8.25 429 48 447 52.63C465 57.25 500 43 500 43ZM500 39L500 39Z" />
        <path id="Đổ màu Solid 3" class="shp1" d="M0 116C0 116 52 49.38 145 86C238 122.62 178.85 -17.46 322 60.63C377 90.63 398 119.37 449 100C500 80.63 500 80 500 80L500 200L0 200L0 116ZM0 116L0 116ZM0 113L0 113ZM0 75C0 75 56 52 70 75.63C70 76.63 0 98.37 0 118C0 137.63 0 75 0 75Z" />
        <path id="Đổ màu Solid 1" class="shp2" d="M0 116C0 116 52 49.38 145 86C238 122.62 178.85 -17.46 322 60.63C377 90.63 398 119.37 449 100C500 80.63 500 80 500 80L500 200L0 200L0 116ZM0 117" />
    </svg> -->
</div>
<div class="top-header row">
    <div class="col-l-5 col-0">
        <!-- nav pc -->
        <nav class="nav_pc">
            <ul>
                <li>
                    <a class="active" href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="{{ route('list-product.index') }}">Sản phẩm</a>
                </li>
                <li>
                    <a href="">Liên hệ</a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                    <li>
                        <a href="{{ route('frontend.logout') }}">Đăng xuất</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <div class="col-auto">
        <div class="logo">
            <img src="{{ asset('frontend/asset/images/Logo-2.png') }}" alt="">
        </div>
    </div>
    <div class="col-l-5">
        <ul class="user-action">
            <li class="bars_nav" id="bars">
                <label for="checkbox_nav"><i class="fa fa-bars" aria-hidden="true"></i></label>
            </li>
            <li>
                <a href="#" class="position-relative wrapper-search">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <div class="search shadow-sm ">
                        <div class="position-relative">
                            <button class="btn btn-close-search">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <form action="{{ route('list-product.index') }}" method="get" class="form-inline justify-content-center pt-4 mt-3 pb-3">
                            <input type="search" class="form-control" name="search">
                            <button type="submit" class="btn btn-outline-secondary ml-2">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('cart') }}">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <span class="number-product-cart badge badge-warning">0</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile') }}">
                    <i class="fa fa-user-o" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
@section('scripts')

@endsection
