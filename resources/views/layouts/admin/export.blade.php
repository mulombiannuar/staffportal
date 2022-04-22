<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Anuary Mulombi :EMAIL mulombiannuar@gmail.com TEL : 0703539208" />
    <title>{{ $title }} :: BWIMS - Bimas Website Information Management System</title>
    <style>
     body { text-align: left; font-size: 11px; font-family: "Times New Roman", Times, serif; }
     footer {position: fixed; padding: 5px;  padding-left: 20px; bottom: 120px; left: 0px; right: 0px; font: bold; }
     header { position: fixed; top: -20px; left: 0px;  right: 0px; }
     table { width: 100%; margin:0px auto; table-layout: auto;  }
     th,td { padding:  10px 10px 10px 10px; text-align: left; border: solid #ccc; }
     table,td,th { border-collapse: collapse; }
     header{ top: -20px;  left: 0px;  right: 0px;  }
     header, .graph img { width: 100%; }
     footer img { width: 100%; }
     hr { margin: 0px; border: solid 1px #ccc; }
     h2,h3,h4{ margin: 5px; }
     sub{vertical-align: sub; font-size: smaller}
     h5 {background-color: grey; padding: 5px;}
    .bg { background-image: url("./assets/images/bg-logo.png"); background-repeat: no-repeat; background-size: cover; background-position: center;}
    .photo { margin:0px auto; border-radius:50%;  border:2px solid #ffffff; width:96px; padding: 0px; }
    .photo img { border-radius:50%; max-height: 100px; max-width: 100px; }
    .header-image{ margin: auto; width:480px;}
    .details { text-align: left; font-size: 12px; margin: 5px; border-bottom:  solid; }
    .graph{ text-align: left;  font-size: 10px; margin: 2px }
    .scores  table, tr, td, th{ padding: 3px; border: solid 1px ; text-align: center; margin-bottom: 10px; }
    .inner-table  td {border: solid 1px #ccc ;}
    .outer-table  table {border: solid 0px #ccc ;}
    .footer-text {border-top: solid #000; position: fixed; padding: 5px;  padding-left: 20px; bottom: 0px; left: 0px; right: 0px;  height: 20px; }
    .position-top{margin-top: 100px;}
     @page contentPage { size: A4 portrait; margin: 2cm;}
     .content-body {page: contentPage;  page-break-after: always;}
     .class-overal {border: solid 2px #000000 ;  font: bold; }
     .logo{width: 120px; position: relative; clear: both; margin: 0 auto; }
     .logo img{width: 100%;}
     .certificate{font: 16px; line-height: 30px;}
     .certificate table, td, th {border-collapse: collapse; }
     .inner{font-weight: bold;  text-transform: uppercase; text-decoration: underline;}
     .comment{text-decoration: underline; text-align: left; font-size: 17px; font-family: "Courier New", Courier, monospace;}
     .invoice {text-align: left; font-size: 12px; font-family: "Courier New", Courier, monospace;}
     .info{font-size: 17px; font-weight: bold;  text-transform: uppercase; padding-left: 15px; padding-right: 15px;
     
     
    
}
    </style>
</head>

<body>
    <div class="wrapper">
        @yield('content')
    </div>
</body>

</html>