<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/ionicons/css/ionicons.min.css') }}">

        @yield('links')

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <!-- Start GA -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-94034622-3');
        </script>
    </head>
    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
{{--                 navbar--}}
                @include('admin.block.navbar')

                @include('admin.block.sidebar')
                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                       <div class="section-header">
                           @yield('header')
                       </div>
                        <div class="section-body">
                            @yield('main-content')
                        </div>
                    </section>
                </div>

                {{-- footer--}}
                @include('admin.block.footer')
            </div>
        </div>
        @yield('modal')

        <!-- General JS Scripts -->
        <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/modules/popper.js') }}"></script>
        <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
        <script src="{{ asset('assets/modules/moment-locale.min.js') }}"></script>
        <script src="{{ asset('assets/js/stisla.js') }}"></script>

        <script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>
        <script src="{{ asset('assets/modules/ionicons/css/ionicons.min.js')}}"></script>


        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        @yield('scripts')
        <script>
            @empty(!session('success'))
            iziToast.success({
                position: 'topRight',
                message: '{{ session('success') }}',
            });
            @endempty
            @empty(!session('error'))
            iziToast.error({
                position: 'topRight',
                message: '{{ session('error') }}',
            });
            @endempty
        </script>
    </body>
</html>
