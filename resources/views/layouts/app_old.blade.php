<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- 
        Developed By Irfa Ardiansyah (irfa.backend@protonmail.com)
        https://github.com/irfaardy
    -->
<head>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com"> 
    <link rel="preconnect" href="https://cdn.jsdelivr.net"> 
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('assets/dashboard/lte/img/logo.png')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem untuk mengelola absensi jarak jauh dan monitoring task karyawan">
    <title>@yield('title',config('app.name', 'Laravel')) | Management Monitoring Indihealth</title>
    {{-- <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script>
             grecaptcha.ready(function() {
                 grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                      document.getElementById('recaptcha').value = token;
                    }
                 });
             });
    </script> --}}
    {!! htmlScriptTagJsApi() !!}

    <!-- Scripts -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/dist/css/adminlte.css') }}" rel="stylesheet">

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="hold-transition login-page">
    <div id="app">

            @yield('content')

    </div>
    @yield('javascript')
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        getGeolocation();
    });

    function getGeolocation() {
      if (navigator.geolocation) {
        return navigator.geolocation.getCurrentPosition(showCoordinates);
      } else {
       alert("Browser anda tidak mendukung geolocation");
      }
    }

    function showCoordinates(position) {
       console.log(position.coords)
       localStorage.setItem("lat", position.coords.latitude);
       localStorage.setItem("lng", position.coords.longitude);

    }
</script>
<!-- This page rendered at : {{now()}} -->
</html>
