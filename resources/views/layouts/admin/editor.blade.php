<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Anuary Mulombi :EMAIL mulombiannuar@gmail.com TEL : (+254) 703539208" />
    <meta name="generator" content="Bimas Kenya Ltd" />
    <meta name="twitter:card" content="Alex Mulombi Annuar" />
    <meta name="twitter:site" content="@mulombiannuar" />
    <meta name="twitter:title" content="Alex Mulombi" />
    <meta name="twitter:url" content="https://twitter.com/mulombiannuar" />
    <meta name="twitter:description" content="Follow us on twitter @mulombiannuar" />
    <title>{{ $title }} :: BWIMS - Bimas Website Information Management System</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('bimas/app/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bimas/app/plugins/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{ asset('bimas/app/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bimas/app/css/custom.css') }}">
    <script src="{{ asset('bimas/app/plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">
        @include('layouts.admin.incls.navbar')
        @include('layouts.admin.incls.sidebar')
        <div class="content-wrapper" style="min-height: 1203.6px;">
            @include('layouts.admin.incls.page-header')
            @include('layouts.admin.incls.alerts')
            @yield('content')
        </div>
        @include('layouts.admin.incls.footer')
    </div>
    
    <script src="{{ asset('bimas/app/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bimas/app/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('bimas/app/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('bimas/app/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script>
    $(function() {
        $('.textarea').summernote()
    })
    </script>
</body>

</html>