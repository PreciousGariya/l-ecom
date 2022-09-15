<!DOCTYPE HTML>
<html lang="en">


<head>
    <meta charset="utf-8">
    <title>Ecommerce Dashboard</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('back-assets/imgs/theme/favicon.svg') }}">
    <!-- Template CSS -->

    <link href="{{ asset('back-assets/css/vendors/normalize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-assets/css/vendors/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-assets/css/vendors/material-icon-round.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-assets/css/vendors/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-assets/css/vendors/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('back-assets/css/main.css') }}" rel="stylesheet" type="text/css" />
    @yield('before-head')
</head>

<body>
    <div class="screen-overlay"></div>
    @include('backend.includes.aside')
    <main class="main-wrap">
        @include('backend.includes.header')

        @yield('content')
        @include('backend.includes.footer')
    </main>
    @yield('before-script')
    <script src="{{ asset('back-assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('back-assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back-assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('back-assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('back-assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('back-assets/js/vendors/chart.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('back-assets/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('back-assets/js/custom-chart.js') }}" type="text/javascript"></script>
    @yield('after-script')
</body>


</html>
