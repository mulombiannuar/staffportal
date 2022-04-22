<!--
Author : Anuary Mulombi - 2020  
Author EMAIL: mulombiannuar@gmail.com
Author PHONE : (254) 0703539028
License: Bimas Kenya Ltd 
License URL: https://bimaskenya.com
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Anuary Mulombi,EMAIL mulombiannuar@gmail.com" />
    <meta name="generator" content="Bimas Kenya Ltd" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} :: BSMI - Bimas System for Managing Information</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
</head>

<body class="hold-transition login-page register-page">
    <div class="login-box register-box">
        <div class="login-logo">
            <img src="{{ asset('assets/dist/img/bimas-portal-logo.png')}}" alt="Bimas logo" width="300px" srcset="">
        </div>
        @include('layouts.auth.incls.alerts')
        @yield('content')
    </div>
    <!-- /.login-box -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js')}} "></script>
    @stack('scripts')
</body>

</html>