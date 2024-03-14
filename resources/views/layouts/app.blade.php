<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <!--
        Developed By Irfa Ardiansyah (irfa.backend@protonmail.com)
        - https://github.com/irfaardy
        - https://github.com/indihealth-2021
    -->
<head>
    <meta name="robots" content="noindex" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://code.jquery.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://www.hCaptcha.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://stackpath.bootstrapcdn.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <meta name="viewport"  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Management Monitoring for PIKKC {{config('app.version')}}, Indihealth Smart Monitoring Management adalah aplikasi yang memberikan layanan operasional ke manajemen Internal untuk mengelola operational internal dan juga pelayanan kepada mitra Perusahaan. Aplikasi Monitoring ini bermanfaat untuk mengelola proses operational dan pelayanan jasa kepada mitra dan memudahkan penggunaan untuk diakses dimana saja dan kapan saja"/>
    <title>@yield('title',config('app.name', 'Monitoring')) | Management Monitoring for Indihealth2</title>
     <link rel="icon" type="image/png" href="{{asset('assets/dashboard/lte/img/logo-PIKKC.png')}}"/>
     {!! htmlScriptTagJsApi() !!}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <!-- Fonts -->
    <meta property="og:image" content="{{asset('assets/dashboard/lte/img/logo-issp.png')}}">
    <meta property="og:title" content="Management Monitoring for PIKKC {{config('app.version')}}" />

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">   <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bosstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('assets/login/css/login.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <script src='https://www.hCaptcha.com/1/api.js' async defer></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <style>
.page-wrp {
    z-index: 99999;
    border: none;
    margin: 0px;
    padding: 0px;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    position: fixed;
    background-color: white;}
    </style>
</head>
<body>
  <main>
  @if(!(Session::has('banned_message')))
	{{-- <div class="page-wrp animate__animated animate__fadeOut" style="animation-delay: 1.2s;">
	  <div class="row h-100">
	    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-xl-2 col-2 animate__animated animate__fadeOutDownBig" style="  margin-right:-10px; padding-left:11px;--animate-duration: 1s; animation-delay: 0.7s; background-color:black;"></div>
	    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-xl-2 col-2 animate__animated animate__fadeOutDownBig" style="  margin-right:-10px; padding-left:11px;--animate-duration: 1s; animation-delay: 0.6s; background-color:black;"></div>
	    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-xl-2 col-2 animate__animated animate__fadeOutDownBig" style="  margin-right:-10px; padding-left:11px;--animate-duration: 1s; animation-delay: 0.5s; background-color:black;"></div>
	    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-xl-2 col-2 animate__animated animate__fadeOutDownBig" style="  margin-right:-10px; padding-left:11px;--animate-duration: 1s; animation-delay: 0.4s; background-color:black;"></div>
	    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-xl-2 col-2 animate__animated animate__fadeOutDownBig" style="  margin-right:-10px; padding-left:11px;--animate-duration: 1s; animation-delay: 0.3s; background-color:black;"></div>
	    <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-xl-2 col-2 animate__animated animate__fadeOutDownBig" style="  margin-right:-10px; padding-left:11px;--animate-duration: 1s; animation-delay: 0.2s; background-color:black;"></div>
	  </div>
   </div> --}}
 @endif

    @yield('content')

  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @yield('javascript')
<script type="text/javascript">
    $( document ).ready(function() {
      Notification.requestPermission().then(function(getperm)
      {

          console.log('Notification Permission Granted', getperm)

      });
        getGeolocation();
    });

    function getGeolocation() {
      if (navigator.geolocation) {
        return navigator.geolocation.getCurrentPosition(showCoordinates);
      } else {
       alert("Browser anda tidak mendukung geolocation, mohon perbaharui browser anda.");
      }
    }

    function showCoordinates(position) {
       console.log(position.coords)
       localStorage.setItem("lat", position.coords.latitude);
       localStorage.setItem("lng", position.coords.longitude);

    }
    $(document).ready(function() {
               setTimeout(function(){ $(".page-wrp").hide() }, 1550);
            })
</script>
<!-- This page rendered at : {{now()}} -->
</body>
</html>
