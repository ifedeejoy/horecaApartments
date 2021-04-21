<!doctype html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Icons --}}
    <link rel="apple-touch-icon" href="{{ asset ('/app-assets/images/ico/apple-icon-120.png') }} ">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset ('/app-assets/images/logo/favicon.ico') }} ">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.lineicons.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600">
    <link rel="stylesheet" href="https://cdn.lineicons.com/2.0/LineIcons.css">

    <!-- BEGIN: Vendor CSS-->
    @section('vendor-css')
    <link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/vendors.min.css') }}"> 
    <link rel="stylesheet" href="{{ asset ('/app-assets/vendors/css/extensions/toastr.min.css') }}">
    @show

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/bootstrap.css') }} ">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/bootstrap-extended.css') }} ">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/colors.css') }} ">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/components.css') }} ">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/themes/dark-layout.css') }} ">
    <link rel="stylesheet" href="{{ asset ('/app-assets/css/themes/bordered-layout.css') }} ">

    <!-- BEGIN: Page CSS-->
   
    @section('page-css')
        <link rel="stylesheet" href="{{ asset ('/app-assets/css/core/menu/menu-types/vertical-menu.css') }} ">
        <link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/extensions/ext-component-toastr.css')}}">
        <link rel="stylesheet" href="{{ asset ('/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
    @show
    

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" href="{{ asset ('/css/app.css') }}">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@if (request()->is('/') || request()->is('index') || request()->is('print-invoice/*') || request()->is('invoice/*'))
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
@else
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
        @include('layouts.navbar')
        @include('layouts.menu')
@endif
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                @yield('content-header')
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>
<!-- END: Body-->
@if (request()->is('/') || request()->is('index'))
@else
@include('layouts.footer')
@endif
@section('vendor-js')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset ('/app-assets/vendors/js/vendors.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/extensions/toastr.min.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}" defer></script>
    <!-- BEGIN Vendor JS-->
@show
<script src="{{ asset ('/app-assets/vendors/js/tables/datatable/jszip.min.js') }}" defer></script>
<script src="{{ asset ('/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}" defer></script>
<script src="{{ asset ('/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}" defer></script>

@if(request()->is('admin/*'))
<script src="{{ asset ('/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}" defer></script>
<script src="{{ asset ('/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}" defer></script>
@endif

<!-- BEGIN: Theme JS-->
    <script src="{{ asset ('/app-assets/js/core/app-menu.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/js/core/app.js') }}" defer></script>
    <script src="{{ asset ('/app-assets/js/scripts/customizer.min.js')}}" defer></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
@section('page-js')
@show

<script type="module" defer>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            })
        }
    });
</script>
</html>
