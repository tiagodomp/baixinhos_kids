<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Baixinhos Kids') }}</title>
    <meta name="keywords" content="Baixinhos Kids, Cabeleireiro infantil, Cabeleireiro Vila Matilde - SP, Nitroempreenda">
    <meta name="author" content="Tiago Pereira - Nitroempreenda">
	<link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--  <link rel="shortcut icon" type="image/png" href="{{ url('img/layout/icon/favicon.ico') }}">  --}}
    <link rel="stylesheet" href="{{ url('css/layout/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/slicknav.min.css') }}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{ url('css/layout/typography.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/default-css.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/styles.css') }}">
    <link rel="stylesheet" href="{{ url('css/layout/responsive.css') }}">
    <!-- modernizr css -->
    <script src="{{ url('js/layout/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    {{--  <section class="login p-fixed d-flex text-center bg-primary common-img-bg">  --}}
        @yield('content')
    {{--  </section>  --}}

    <!-- jquery latest version -->
    <script src="{{ url('js/layout/vendor/jquery-2.2.4.min.js') }}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{ url('js/layout/popper.min.js') }}"></script>
    <script src="{{ url('js/layout/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/layout/owl.carousel.min.js') }}"></script>
    <script src="{{ url('js/layout/metisMenu.min.js') }}"></script>
    <script src="{{ url('js/layout/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ url('js/layout/jquery.slicknav.min.js') }}"></script>

    <!-- others plugins -->
    <script src="{{ url('js/layout/plugins.js') }}"></script>
    <script src="{{ url('js/layout/scripts.js') }}"></script>
</body>

</html>
