@extends('layouts.app')
@section('title', 'Atur Kata Sandi Baru | Indihealth Absensi')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="{{route('home')}}"><img src="{{asset('assets/img/logo.png')}}" width="280px"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><div class="alert alert-info">Sebelum melanjutkan, mohon untuk membuat kata sandi baru.</div></p>

      <form action="{{ route('password.guest.active') }}" method="POST">
        @csrf
       
        <div class="input-group mb-3">
          <input type="password" class="form-control " name="password" required="" placeholder="Kata Sandi" autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div> 
        <div class="input-group mb-3">
          <input type="password" class="form-control " name="password_confirmation" required="" placeholder="Konfirmasi Kata Sandi" autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
        
          <div class="col-12" align="center">
            <button type="submit" class="btn btn-primary btn-block">Atur Kata Sandi</button>
            <hr>
          
            <a class="btn btn-outline-warning btn-block" href="{{route('guest.logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-frm').submit();">Logout</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

    
    </div>
    <!-- /.login-card-body -->
     <form id="logout-frm" action="{{ route('guest.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
  </div>
</div>

@endsection
@section('javascript')
 
        @error('password')
            <script type="text/javascript">
                Swal.fire(
                 '',
                  '{{$message}}',
                  'warning'
                )
            </script>
        
        @enderror
@endsection
