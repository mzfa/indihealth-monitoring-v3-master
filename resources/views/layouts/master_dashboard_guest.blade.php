<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- 
        Developed By Irfa Ardiansyah (irfa.backend@protonmail.com)
        https://github.com/irfaardy
    -->
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com"> 
        <link rel="preconnect" href="https://cdn.jsdelivr.net"> 
        <link rel="preconnect" href="https://fonts.googleapis.com"> 
        <link
            rel="icon"
            type="image/png"
            href="{{asset('assets/dashboard/lte/img/logo.png')}}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta
            name='viewport'
            content='width=device-width, initial-scale=1.0, maximum-scale=1.0,
     user-scalable=0'>

        <title>@yield('title','Dashboard') |
            {{config('app.app_name')}}</title>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous"></script>
       <script src="{{asset('assets/webcamjs/webcam.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <!-- Google Font: Source Sans Pro -->
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.css"
            integrity="sha512-UzcnE2gVMx7OCuXHLNVyoElL8v2QGAOidIn6PIy0d8ciWuqMBsgpB4QfKcuj8RbHrljngft9T8remhtF992RlQ=="
            crossorigin="anonymous"/>
        <!-- Font Awesome -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
            integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
            crossorigin="anonymous"/>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
            integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
            crossorigin="anonymous"/>
        <!-- Theme style -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
            integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
            crossorigin="anonymous"/>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous"></script>

        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"
            integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA=="
            crossorigin="anonymous"></script>
        <link
            rel="stylesheet"
            href="{{asset('assets/dashboard/lte/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/zoom.js/css/zoom.css')}}">
        <style>
             label.error{
                 color:crimson;
                 font-size:12px;
             }
             input.error,textarea.error{
                 border-color: crimson !important;
                 border:1px 1px 1px solid !important;
                              }
        </style>
        
    </head>
    <body id="loader" class="hold-transition sidebar-mini  @if(Cache::has('tgmg-'.AuthGuest::guest()->id)) sidebar-collapse @endif"">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" id="toggle-menu" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                    {{-- <li class="nav-item d-none d-sm-inline-block">
                        <a href="../../index3.html" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contact</a>
                    </li> --}}
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="fas fa-search"></i>
                        </a>
                        <div class="navbar-search-block">
                            <form class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input
                                        class="form-control form-control-navbar"
                                        type="search"
                                        placeholder="Search"
                                        aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li> --}}

                    <!-- Messages Dropdown Menu -->

                    <!-- Notifications Dropdown Menu -->

                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expended="true">
                            Hi,
                            {{head(explode(' ', trim(AuthGuest::guest()->name)))}}
                            <i class="fas fa-angle-down"></i>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-right">
                            <a href="{{route('password')}}" class="dropdown-item">
                                <i class="fas fa-key mr-2"></i>
                                Ubah Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a
                                class="dropdown-item"
                                href="{{ route('guest.logout') }}"
                                onclick="event.preventDefault();
          document.getElementById('l-out').submit();">

                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                            <form
                                id="l-out"
                                action="{{ route('logout') }}"
                                method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{URL::to('/')}}" class="brand-link">
                    <img
                        src="{{asset('assets/dashboard/lte/img/logo.png')}}"
                        alt="Company Logo"
                        class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light mr-6">IndiHealth</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img
                                src="{{asset('assets/img/avatar5.png')}}"
                                class="img-circle elevation-2"
                                alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block" data-target="#profile" data-toggle="modal">{{AuthGuest::guest()->name}}</a>

                        </div>
                    </div>

                    <!-- SidebarSearch Form -->
                    {{-- <div class="form-inline">
                        <div class="input-group" data-widget="sidebar-search">
                            <input
                                class="form-control form-control-sidebar"
                                type="search"
                                placeholder="Search"
                                aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul
                            class="nav nav-pills nav-sidebar flex-column"
                            data-widget="treeview"
                            role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class with font-awesome or any
                            other icon font library -->
                            @include('layouts/partrials/sidebar_guest')

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->

                <!-- Main content -->
                <section class="content">
                    <div class="card card-primary card-outline mt-2">
                        <div class="card-title">
                            <h3 class="ml-3 mt-3">@yield('title')<br>
                                <small>@yield('subtitle')</small>
                            </h3>
                            <hr>
                        </div>
                        <div class="card-body">
                            <!-- Modal -->
                            <form
                                action="{{route('task.karyawan')}}"
                                method="GET"
                                id="form-task-select-karyawan">
                                <div
                                    class="modal fade"
                                    id="modal-select-karyawan"
                                    tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="exampleModalCenterTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Pilih Karyawan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Karyawan</label><br>
                                                <select name="id" id="select-task-karyawan" class="form-control"></select>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i spinner="spinner" style="display: none;" class="fas fa-spinner fa-spin"></i>
                                                    Lanjutkan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div
                                class="modal fade"
                                id="profile"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="exampleModalCenterTitle"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Profil Anda</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body"></div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @yield('content')
                        </div>
                        <!-- /.card-body -->
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b>
                    {{config('app.version')}}
                </div>
                <strong>Copyright &copy;
                    {{date('Y')}}
                    <a target="_blank" href="{{config('app.web_company')}}">{{config('app.copyright')}}</a>.</strong>
                All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous"></script>
        <link
            href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet"/>
        <script
            src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript">
            $('#select-task-karyawan').select2({
                dropdownAutoWidth: true,
                dropdownParent: $("#modal-select-karyawan"),
                width: '100%',
                ajax: {
                    delay: 250,
                    url: '{{route("karyawan.getSelectKaryawan")}}',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term
                        }
                        return query;
                    },
                    processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {results: data};
                    }
                    // Additional AJAX parameters go here; see the end of this chapter for the full
                    // code of this example
                }
            });
        </script>
        <script src="{{asset('assets/jquery-loading/dist/jquery.loading.min.js')}}"></script>
        <script src="{{asset('assets/zoom.js/js/zoom.js')}}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        </script>
        <script src="{{asset('assets/js/initialization.js')}}"></script>
        <script> 
        $('#toggle-menu').click(function(){
              axios.post('{{route("guest.service.togglemenu")}}', {})
                .then(function (response) {

                })
              .catch(function (error) {
               
               if(error.response.status == 422){
                         
                    $.each(error.response.data.errors, (i, j) => {
                     toastr.warning(j)
                  })
               } else{
                  
                 Swal.fire({
                    title: 'Error!',
                    text: "Internal Server Error",
                    icon: 'warning',
                    confirmButtonText: 'OK'
                  })

               }
              });
        })</script>
        <!-- <script
        src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.3.1/dist/lazyload.min.js"></script>
        <script type="text/javascript"> var lazyLoadInstance = new LazyLoad({ // Your
        custom settings go here }); </script> -->
        <!-- jQuery -->
        @yield('javascript')
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"
            integrity="sha512-kZsqvmw94Y8hyhwtWZJvDtobwQ9pLhF1DuIvcqSuracbRn6WJs1Ih+04fpH/8d1CFKysp7XA1tR0Aa2jKLTQUg=="
            crossorigin="anonymous"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
            integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
            crossorigin="anonymous"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
            integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
            crossorigin="anonymous"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous"></script>
        <!-- Bootstrap 4 -->
        
        <script
            src="{{asset('assets/dashboard/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('assets/dashboard/lte/js/adminlte.min.js')}}"></script>

        @include('layouts/partrials/alert')

        <!-- This page rendered at : {{now()}} -->
    </body>
</html>