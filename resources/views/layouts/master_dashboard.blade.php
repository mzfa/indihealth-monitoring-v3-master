<!DOCTYPE html>
<html lang="en">
<!-- skip.minification -->
        <!--
        Developed By Irfa Ardiansyah (irfa.backend@protonmail.com)
        https://github.com/irfaardy
        -->
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com">
        <link rel="preconnect" href="https://cdn.jsdelivr.net">
        <link rel="preconnect" href="https://code.jquery.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://meet.jit.si">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha512-mf78KukU/a8rjr7aBRvCa2Vwg/q0tUjJhLtcK53PHEbFwCEqQ5durlzvVTgQgKpv+fyNMT6ZQT1Aq6tpNqf1mg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!-- Google Font: Source Sans Pro -->

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
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
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" integrity="sha512-IuO+tczf4J43RzbCMEFggCWW5JuX78IrCJRFFBoQEXNvGI6gkUw4OjuwMidiS4Lm9Q2lILzpJwZuMWuSEeT9UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
        {{-- <link
            rel="stylesheet"
            href="{{asset('assets/dashboard/lte/css/adminlte.min.css')}}"> --}}
        <link rel="stylesheet" href="{{asset('assets/zoom.js/css/zoom.css')}}">
        <link rel="stylesheet" href="{{asset('assets/gantt-chart/css/style.css')}}">
        {{-- <link rel="stylesheet" href="{{asset('assets/css/style-chat.css')}}"> --}}

        <link rel="stylesheet" href="{{asset('assets/dashboard/timeline.css')}}">

        <link rel="stylesheet" href="{{asset('assets/bootstrap-switch/bootstrap-switch.min.css')}}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

<style>
    [nav-mode], [body-mode], [side-mode]{
         transition: all 230ms !important;
    }
    .sortable .sortable-item{
        cursor: move;
    }
   
</style>
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
    </head>
    <body id="loader" body-mode class="hold-transition sidebar-mini {{Config::bodyMode()}}  @if(Cache::has('tgm-'.auth()->user()->id) || (Route::currentRouteName() == 'meeting.room')) sidebar-collapse @endif">
        <audio id="notification">
            <source src="{{asset('assets/audio/notification.mp3')}}" type="audio/mpeg">

        </audio>
        <audio id="warning-notif">
            <source src="{{asset('assets/audio/warning.mp3')}}" type="audio/mpeg">

        </audio>
    </audio>
    <audio id="mtNotif">
        <source src="{{asset('assets/audio/mtNotif.mp3')}}" type="audio/mpeg">

    </audio>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav nav-mode class="main-header navbar navbar-expand {{Config::navbarMode()}}">
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
                <li class="nav-item">
                <a class="nav-link" dark-mode href="javascript:void(0);" title="Beralih tema aplikasi.">
                <i dark-mode-icon class="{{Config::iconDarkMode()}} mr-2 mt-2"></i> <span darkmode-text>{{Config::textDarkMode()}}</span>
               
                </a>
                </li>
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
        @Permission(['superadmin'])
                <li class="nav-item dropdown">
        <a class="nav-link"  id="notif-check-absen" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-calendar-check mt-2"></i>
          <span class="badge badge-danger navbar-badge" id="notifCountAbsensi" style="display: none">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          {{-- <span class="dropdown-item d">Ticketing Request</span>
            <div class="dropdown-divider"></div>
            <div  id="notif-drop-ticket" style="max-height: 800px;" class="overflow-auto">
              <div align="center" style="margin-top:20px; margin-bottom:20px;"><i class="fas fa-spin fa-spinner"></i> Memuat...</div>
          </div> --}}
           <span class="dropdown-item d">Request Absensi Keluar</span>
            <div class="dropdown-divider"></div>
            <div  id="notif-drop-absensi" style="max-height: 800px;" class="overflow-auto">
              <div align="center" style="margin-top:20px; margin-bottom:20px;"><i class="fas fa-spin fa-spinner"></i> Memuat...</div>
          </div>
          <div class="dropdown-divider"></div>

        </div>
      </li>
    @endPermission
                <li class="nav-item dropdown">
        <a class="nav-link"  id="notif-check" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell mt-2"></i>
          <span class="badge badge-danger navbar-badge" id="notifCount" style="display: none">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          {{-- <span class="dropdown-item d">Ticketing Request</span>
            <div class="dropdown-divider"></div>
            <div  id="notif-drop-ticket" style="max-height: 800px;" class="overflow-auto">
              <div align="center" style="margin-top:20px; margin-bottom:20px;"><i class="fas fa-spin fa-spinner"></i> Memuat...</div>
          </div> --}}
           <span class="dropdown-item d">Task Project invitation</span>
            <div class="dropdown-divider"></div>
            <div  id="notif-drop" style="max-height: 800px;" class="overflow-auto">
              <div align="center" style="margin-top:20px; margin-bottom:20px;"><i class="fas fa-spin fa-spinner"></i> Memuat...</div>
          </div>
          <div class="dropdown-divider"></div>

        </div>
            </li>
                <li class="nav-item dropdown mt-2">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expended="true">
                        Hi,
                        <!-- {{head(explode(' ', trim(Auth::user()->name)))}} -->
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu  dropdown-menu-right mt-2">
                        <a href="{{route('password')}}" class="dropdown-item">
                            <i class="fas fa-key mr-2"></i>
                            Ubah Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a
                            class="dropdown-item"
                            href="{{ route('logout') }}"
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
                <div class="user-panel mt-2 pb-2 mb-3 d-flex">
                    <div class="image">
                        <img
                            src="{{asset('assets/img/avatar5.png')}}"
                            class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" data-target="#profile" data-toggle="modal">{{auth()->user()->name}}</a>
                    </div>
                </div>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside side-mode class="main-sidebar elevation-4 {{Config::sidebarMode()}} elevation-4">
            <!-- Brand Logo -->
            <a nav-mode href="{{URL::to('/')}}" class="brand-link {{Config::navbarMode()}}">
                <img
                    src="{{asset('assets/dashboard/lte/img/logo.png')}}"
                    alt="Company Logo"
                    class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light mr-6">IDH <b>Monitoring</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img
                            src="{{route('showFotoKaryawan',['file' => empty(auth()->user()->karyawan)?'default.jpg':auth()->user()->karyawan->foto])}}"
                            class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" data-target="#profile" data-toggle="modal">{{auth()->user()->name}}</a>

                    </div>
                </div> -->

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
                        @include('layouts/partrials/sidebar')

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
                    @if(Cache::has('ab0a2ff7'))
                    <div class="alert alert-warning" align="center">{{Cache::get('ab0a2ff7')}}</div>
                    @endif
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
                                            <select required
                                                name="id"
                                                id="select-task-karyawan"
                                                class="select-task-karyawan form-control"></select>

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

                        <form
                            action="{{route('chart.karyawan.pilih')}}"
                            method="GET"
                            id="form-task-select-karyawan-chart">
                            <div
                                class="modal fade"
                                id="modal-select-karyawan-chart"
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
                                            <select
                                                name="id" required
                                                id="select-task-karyawan-chart"
                                                class="select-task-karyawan-chart form-control"></select>

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

                        <!-- Modal -->
                        <form
                            action="{{route('notulensi')}}"
                            method="GET"
                            id="form-task-select-karyawan">
                            <div
                                class="modal fade"
                                id="modal-select-projek-notulen"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="exampleModalCenterTitle"
                                aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Pilih Projek</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label>Projek</label><br>
                                            <select
                                                name="id" required
                                                id="select-project-notulen"
                                                class="select-project-notulen form-control"></select>

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
                                    <div class="modal-body">
                                        @if(!empty(auth()->user()->karyawan))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span style="font-weight: bold">Nomor Induk Karyawan</span>
                                            </div>
                                            <div class="col-md-12">
                                                {{auth()->user()->karyawan->nip}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span style="font-weight: bold">Nama Lengkap</span>
                                            </div>
                                            <div class="col-md-12">
                                                {{auth()->user()->karyawan->nama_lengkap}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <span style="font-weight: bold">Tipe Karyawan</span>
                                            </div>
                                            <div class="col-md-12">
                                                {{auth()->user()->karyawan->tipe_karyawan}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <span style="font-weight: bold">Jabatan</span>
                                            </div>
                                            <div class="col-md-12">
                                                {{auth()->user()->karyawan->jabatan->nama}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <span style="font-weight: bold">Tgl Bergabung</span>
                                            </div>
                                            <div class="col-md-12">
                                               {{auth()->user()->karyawan->join_date}} 
                                               <small>(
                                               {{ \Carbon\Carbon::parse(auth()->user()->karyawan->join_date.' 00:00:00')->diffForHumans(['long' => false, 'parts' => 2])}})
                                           </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <span style="font-weight: bold">Email</span>
                                            </div>
                                            <div class="col-md-12">
                                                {{auth()->user()->email}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <span style="font-weight: bold">Sisa Cuti Anda</span>
                                            </div>
                                            <div class="col-md-12">
                                                @if(UserHelper::joinAge(auth()->user()->karyawan->join_date) < 1)
                                                    <span class="badge badge-warning">Anda belum bisa mendapatkan Cuti</span> 
                                                @else

                                                    {{UserHelper::sisaCuti(auth()->user()->karyawan_id)}}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div  class="col-md-12 bg-white" align="center">
                                                <div class="mt-4"></div>
                                                <span style="font-family:courier, courier new, serif;"><b>Indihealth</b></span> <br> 
                                                <span style="font-family:courier, courier new, serif;"> {{auth()->user()->karyawan->nama_lengkap}}</span> <br>
                                                {!! QrCode::size(150)->style('square')->eye('square')->generate(auth()->user()->karyawan->nip); !!}<br><span style="font-family:courier, courier new, serif;"> {{auth()->user()->karyawan->nip}}</span>
                                                <div class="mb-4"></div> 
                                            </div>
                                        </div>
                                        @else
                                        <div class="alert alert-warning" align="center">Akun ini belum terkait dengan karyawan.</div>
                                        @endif
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
        <style>
    .select2-select-task-karyawan-chart-container{
        line-height: 18px !important;
    }
</style>
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script
    src="{{asset('assets/gantt-chart/js/jquery.fn.gantt.min.js')}}"></script>
    <script type="text/javascript">
  $( function() {
    $( ".sortable" ).sortable();
  } );

  toastr.options = {
    // "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "slideDown",
    "hideMethod": "slideUp"
  }
        $('.select-task-karyawan').select2({
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
        $('.select-task-karyawan-chart').select2({
            dropdownAutoWidth: true,
            dropdownParent: $("#modal-select-karyawan-chart"),
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
        $('.select-project-notulen').select2({
            dropdownAutoWidth: true,
            dropdownParent: $("#modal-select-projek-notulen"),
            width: '100%',
            ajax: {
                delay: 250,
                url: '{{route("project.select")}}',
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
        $(function () {
            Notification.requestPermission().then(function(permission) {});
            fetchNotifMember();
            // fetchNotifDeadline();
            // mtReqNotif();
            // countNotif();
            // notif_pulang();
            absenReqNotifToast();
            countNotifAbsenToast();
            @if(Route::currentRouteName() != 'project.monitoring')
            // setInterval(async function () {
            //     await fetchNotifMember();
            //     // await fetchNotifDeadline();
            //     // await mtReqNotif();
            //     // await countNotif();
            //     // await notif_pulang();
            // }, 14500);
            @endif
        })

        function fetchNotifMember() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.memberMTInvite")}}', formData)
                .then(function (response) {
                    $.each(response.data.taskMember, (i, j) => {
                        @if(Agent::isMobile())
                        navigator
                            .serviceWorker
                            .register('sw.js');
                        Notification.requestPermission(function (result) {
                            if (result === 'granted') {
                                navigator
                                    .serviceWorker
                                    .ready
                                    .then(function (registration) {
                                        registration.showNotification(j.body);
                                    });
                            }

                        });
                        @endif
                        document
                            .getElementById("notification")
                            .play()
                        if (window.Notification && Notification.permission !== "denied") {
                            Notification.requestPermission(
                                function (status) { // status is "granted", if accepted by user
                                    var n = new Notification(j.title, {
                                        body: j.body,
                                        icon: '{{asset('assets/dashboard/lte/img/logo.png ')}}' // optional
                                    });
                                }
                            );
                        }
                        toastr.warning(j.body, j.title, {timeOut: 8000});
                    })
                    setTimeout(() => {  fetchNotifDeadline() }, 1600);

                })
        }

        function countNotif() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.countNotification")}}', formData)
                .then(function (response) {
                    if(response.data.notification.total>0)
                    {
                        $('#notifCount').fadeIn();
                        $('#notifCount').html(response.data.notification.total);
                    }
                    setTimeout(() => {  notif_pulang() }, 1600);


                })
        }
        function countNotifAbsen() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.count_absensi")}}', formData)
                .then(function (response) {
                    if(response.data.notification.absensi>0)
                    {
                        $('#notifCountAbsensi').fadeIn();
                        $('#notifCountAbsensi').html(response.data.notification.absensi);
                    }
                    setTimeout(() => {  absenReqNotif() }, 1600);


                })
        }
            $('#notif-check').click(function (e) {
            let formData = new FormData();
            axios.post('{{route("services.notif.content")}}', formData)
                .then(function (response) {
                    $('#notif-drop').html('')
                       $.each(response.data.notification.invitation, (i, j) => {
                          console.log(j.id)
                           if(!j.is_read)
                           {
                               var newNotif = '<span class="float-right text-sm badge badge-danger">New</span>';
                           } else{
                               var newNotif = '';
                           }
                            $('#notif-drop').append('<a href="'+j.project_link+'" class="dropdown-item"><div class="media"><img src="{{asset('assets/dashboard/lte/img/logo.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle"><div class="media-body">  <h3 class="dropdown-item-title">   '+j.title+"<br><small>"+j.project+"</small>"+' '+newNotif+'</h3>  <p class="text-sm">'+j.task+'</p>  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+j.human_time+'</p></div></div>  </a>')
                            });
                        if(response.data.notification.invitation.length == 0)
                        {
                               $('#notif-drop').html('')
                        }

                        $('#notif-drop-ticket').html('')
                      //  $.each(response.data.notification.ticketing, (i, j) => {
                      //
                      //       if(!j.is_read)
                      //      {
                      //          var newNotif = '<span class="float-right text-sm badge badge-danger">New</span>';
                      //      } else{
                      //          var newNotif = '';
                      //      }
                      //       $('#notif-drop-ticket').append('<a href="{{route('ticketing.maintenance')}}?mtarget='+j.id+'" class="dropdown-item"><div class="media"><img src="{{asset('assets/dashboard/lte/img/logo.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle"><div class="media-body">  <h3 class="dropdown-item-title">   '+j.title+' '+newNotif+'   </h3>  <p class="text-sm">'+j.project+'</p>  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+j.human_time+'</p></div></div>  </a>')
                      //       });
                      // if(response.data.notification.ticketing.length == 0)
                      //   {
                      //          $('#notif-drop-ticket').html('')
                      //   }



                })
            })

            $('#notif-check-absen').click(function (e) {
            let formData = new FormData();
            axios.post('{{route("services.notif.absenContent")}}', formData)
                .then(function (response) {
                    $('#notif-drop-absensi').html('')
                       $.each(response.data.notification.absensi, (i, j) => {
                          console.log(j.id)
                           if(!j.is_read)
                           {
                               var newNotif = '<span class="float-right text-sm badge badge-danger">New</span>';
                           } else{
                               var newNotif = '';
                           }
                            $('#notif-drop-absensi').append('<a href="'+j.link_absen+'" class="dropdown-item"><div class="media"><img src="{{asset('assets/dashboard/lte/img/logo.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle"><div class="media-body">  <h3 class="dropdown-item-title">  Permintaan Absensi Keluar '+j.nama_lengkap+'</h3>  <p class="text-sm"> Untuk absensi tgl '+j.tanggal+' jam '+j.jam+'</p>  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+j.human_time+'</p></div></div>  </a>')
                            });
                        if(response.data.notification.absensi.length == 0)
                        {
                               $('#notif-drop-absensi').html('')
                        }

                        // $('#notif-drop-absensi').html('')
                      //  $.each(response.data.notification.ticketing, (i, j) => {
                      //
                      //       if(!j.is_read)
                      //      {
                      //          var newNotif = '<span class="float-right text-sm badge badge-danger">New</span>';
                      //      } else{
                      //          var newNotif = '';
                      //      }
                      //       $('#notif-drop-ticket').append('<a href="{{route('ticketing.maintenance')}}?mtarget='+j.id+'" class="dropdown-item"><div class="media"><img src="{{asset('assets/dashboard/lte/img/logo.png')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle"><div class="media-body">  <h3 class="dropdown-item-title">   '+j.title+' '+newNotif+'   </h3>  <p class="text-sm">'+j.project+'</p>  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+j.human_time+'</p></div></div>  </a>')
                      //       });
                      // if(response.data.notification.ticketing.length == 0)
                      //   {
                      //          $('#notif-drop-ticket').html('')
                      //   }



                })
            })

        function mtReqNotif() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.mtRequestNotif")}}', formData)
                .then(function (response) {
                    $.each(response.data.taskMT, (i, j) => {
                        @if(Agent::isMobile())
                        navigator
                            .serviceWorker
                            .register('sw.js');
                        Notification.requestPermission(function (result) {
                            if (result === 'granted') {
                                navigator
                                    .serviceWorker
                                    .ready
                                    .then(function (registration) {
                                        registration.showNotification(j.body);
                                    });
                            }
                        });
                        @endif
                        document
                            .getElementById("mtNotif")
                            .play()
                        if (window.Notification && Notification.permission !== "denied") {
                            Notification.requestPermission(
                                function (status) { // status is "granted", if accepted by user
                                    var n = new Notification(j.title, {
                                        body: j.body,
                                        icon: '{{asset(' assets/dashboard/lte/img/logo.png ')}}' // optional
                                    });
                                }
                            );
                        }
                        toastr.warning(j.body, j.title, {timeOut: 8000});
                    })
                      // alert('mt')
                      setTimeout(() => {    countNotif() },700);

                })
        }

        function absenReqNotif() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.absensi")}}', formData)
                .then(function (response) {
                    $.each(response.data.absensi, (i, j) => {
                        @if(Agent::isMobile())
                        navigator
                            .serviceWorker
                            .register('sw.js');
                        Notification.requestPermission(function (result) {
                            if (result === 'granted') {
                                navigator
                                    .serviceWorker
                                    .ready
                                    .then(function (registration) {
                                        registration.showNotification(j.body);
                                    });
                            }
                        });
                        @endif
                        document
                            .getElementById("mtNotif")
                            .play()
                        if (window.Notification && Notification.permission !== "denied") {
                            Notification.requestPermission(
                                function (status) { // status is "granted", if accepted by user
                                    var n = new Notification(j.title, {
                                        body: j.body,
                                        icon: '{{asset(' assets/dashboard/lte/img/logo.png ')}}' // optional
                                    });
                                }
                            );
                        }
                        toastr.warning(j.body, j.title, {timeOut: 8000});
                    })
                      // alert('mt')
                      setTimeout(() => {    fetchNotifMember() }, 1600);

                })
        }
        function absenReqNotifToast() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.absensi")}}', formData)
                .then(function (response) {
                    $.each(response.data.absensi, (i, j) => {
                        @if(Agent::isMobile())
                        navigator
                            .serviceWorker
                            .register('sw.js');
                        Notification.requestPermission(function (result) {
                            if (result === 'granted') {
                                navigator
                                    .serviceWorker
                                    .ready
                                    .then(function (registration) {
                                        registration.showNotification(j.body);
                                    });
                            }
                        });
                        @endif
                        document
                            .getElementById("mtNotif")
                            .play()
                        if (window.Notification && Notification.permission !== "denied") {
                            Notification.requestPermission(
                                function (status) { // status is "granted", if accepted by user
                                    var n = new Notification(j.title, {
                                        body: j.body,
                                        icon: '{{asset(' assets/dashboard/lte/img/logo.png ')}}' // optional
                                    });
                                }
                            );
                        }
                        toastr.warning(j.body, j.title, {timeOut: 8000});
                    })


                })
        }

        function notif_pulang() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.pulang")}}', formData)
                .then(function (response) {
                    if(response.data.notif.status)
                    {
                        @if(Agent::isMobile())
                        navigator
                            .serviceWorker
                            .register('sw.js');
                        Notification.requestPermission(function (result) {
                            if (result === 'granted') {
                                navigator
                                    .serviceWorker
                                    .ready
                                    .then(function (registration) {
                                        registration.showNotification(response.data.notif.messages);
                                    });
                            }
                        });
                        @endif
                        document
                            .getElementById("mtNotif")
                            .play()
                        if (window.Notification && Notification.permission !== "denied") {
                            Notification.requestPermission(
                                function (status) { // status is "granted", if accepted by user
                                    var n = new Notification(j.title, {
                                        body: response.data.notif.messages,
                                        icon: '{{asset('assets/dashboard/lte/img/logo.png ')}}' // optional
                                    });
                                }
                            );
                        }
                         Swal.fire({
                                title: 'Pengingat absensi pulang!',
                                text: response.data.notif.messages,
                                icon: 'info',
                                confirmButtonText: 'OK'
                            })
                    }
                     setTimeout(() => {  countNotifAbsen() }, 1600);
                })
        }
        
        function fetchNotifDeadline() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.Deadline")}}', formData)
                .then(function (response) {
                    $.each(response.data.taskMember, (i, j) => {
                        @if(Agent::isMobile())
                        navigator
                            .serviceWorker
                            .register('sw.js');
                        Notification.requestPermission(function (result) {
                            if (result === 'granted') {
                                navigator
                                    .serviceWorker
                                    .ready
                                    .then(function (registration) {
                                        registration.showNotification(j.body);
                                    });
                            }
                        });
                        @endif
                        document
                            .getElementById("warning-notif")
                            .play()
                        if (window.Notification && Notification.permission !== "denied") {
                            Notification.requestPermission(
                                function (status) { // status is "granted", if accepted by user
                                    var n = new Notification(j.title, {
                                        body: j.body,
                                        icon: '{{asset(' assets/dashboard/lte/img/logo.png ')}}' // optional
                                    });
                                }
                            );
                        }
                        toastr.warning(j.body, j.title, {timeOut: 8000});
                    })
                    // alert('deadline')
                    setTimeout(() => {   mtReqNotif() }, 1600);
                })
        }

        function countNotifAbsenToast() {
            let formData = new FormData();
            axios
                .post('{{route("services.notif.count_absensi")}}', formData)
                .then(function (response) {
                    if(response.data.notification.absensi>0)
                    {
                        $('#notifCountAbsensi').fadeIn();
                        $('#notifCountAbsensi').html(response.data.notification.absensi);
                    }



                })
        }
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
              axios.post('{{route("service.togglemenu")}}', {})
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
        })
        $('[dark-mode]').click(function(e){
           axios.post('{{route("service.darkmode")}}', {})
                .then(function (response) {
                    if(response.data.menu.toggle == true)
                    {
                       
                        $('[body-mode]').addClass('dark-mode')
                        $('[nav-mode]').removeClass('navbar-light navbar-white').addClass('navbar-inverse navbar-dark')
                        $('[side-mode]').removeClass('sidebar-light-lightblue').addClass('sidebar-dark-lightblue')
                        $('[dark-mode-icon]').removeClass('far fa-moon').addClass('fas fa-sun')
                         $('[darkmode-text]').text('Light Mode')
                    } else{
                      
                        $('[body-mode]').removeClass('dark-mode')
                        $('[nav-mode]').removeClass('navbar-inverse navbar-dark').addClass('navbar-light navbar-white')
                        $('[dark-mode-icon]').removeClass('fas fa-sun').addClass('far fa-moon')
                        $('[side-mode]').removeClass('sidebar-dark-lightblue').addClass('sidebar-light-lightblue')
                        $('[darkmode-text]').text('Dark Mode')
                    }
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
        })
    </script>
      <script src="{{asset('assets/bootstrap-switch/bootstrap-switch.min.js')}}"></script>
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
      <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
  <script>$("img.lazyload").lazyload();</script>
    <!-- This page rendered at : {{now()}} -->
</body>
</html>
