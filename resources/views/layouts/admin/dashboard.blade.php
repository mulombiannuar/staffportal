<!--Author : Anuary Mulombi - 2022 
Author EMAIL: mulombiannuar@gmail.com
Author PHONE : (254) 0703539028
License: Bimas Kenya Limited 
License URL: http://www.bimaskenya.com
-->

<!DOCTYPE html>
<html lang="en"> 
<head>
   @include('layouts.admin.incls.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.admin.incls.navbar')
        @include('layouts.admin.incls.sidebar')
        @include('layouts.admin.incls.alerts')
        @yield('content')
        @include('layouts.admin.incls.footer')
    </div>
    @include('layouts.admin.incls.scripts')
</body>
</html>
