@extends('layouts.app')

@section('title', 'Login Internal')
@section('content')
<div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper" style="height:100vh !important;">

          <div class="login-wrapper my-auto">
            <div class="login-title" @if(Agent::isMobile()) align="center" @endif> <img src="{{asset('assets/img/logo.png')}}" alt="logo" style="height:70px;" class="logo"></div>

            <form action="{{ route('login') }}" method="POST">
               @csrf
                @if(Session::has('message'))
                <div class="alert alert-success" align="center">
                  {{Session::get('message')}}
                </div>
                @endif
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" required name="email" id="email" class="form-control" placeholder="email@contoh.com">
              </div>
              <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" required name="password" id="password" class="form-control" placeholder="masukan kata sandi anda">
              </div> 

              <div class="form-group mb-4">
                 @if($_SERVER['SERVER_NAME'] == 'localhost')
                <div class="alert alert-warning">Server Local terdeteksi, Captcha bisa dikosongkan</div>
              @endif
              <div class="h-captcha" data-sitekey="{{\Illuminate\Support\Facades\Config::get('app.h_key')}}"></div>
              </div>
              <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Login">
               <input type="checkbox" name="remember" checked='true' id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </form>

            @if (Route::has('user.reset'))
            <a  href="{{ route('user.reset') }}"  class="forgot-password-link">
                {{ __('Lupa Kata Sandi?') }}
            </a>
           @endif
               {{-- <a href="{{route('guest.login_form')}}" type="submit" class="badge badge-primary">Login untuk klien</a> --}}
           @if(Agent::isMobile())
           <hr>
              <small class="mb-3">IDH Monitoring Management {{config('app.version')}}</small><br>
              <small class="mb-3">&copy; {{date("Y") }} <a target="_blank" href="https://indihealth.com">Indihealth</small>
            @endif

          </div>
        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block" style="background-image: url('{{asset('assets/login/images/login.jpg')}}'); background-size: cover; background-position: center;">
           <div class="mr-2" style="color: white;position: fixed; bottom: 0; right: 0;">&copy; {{date("Y") }} Indihealth. IndiHealth Monitoring Management {{config('app.version')}}</div>
          {{-- <img src="" alt="login image" class="login-img"> --}}
        </div>
      </div>
    </div>


@endsection

@section('javascript')
    @error('email')
            <script type="text/javascript">
                Swal.fire(
                  '',
                  '{{$message}}',
                  'warning'
                )
            </script>

        @enderror
        @if(Session::has('banned_message'))
            <script type="text/javascript">
                Swal.fire(
                  '',
                  '{{Session::get("banned_message")}}',
                  'error'
                )
            </script>

        @endif 

        @if(Session::has('fail'))
            <script type="text/javascript">
                Swal.fire(
                  '',
                  '{{Session::pull("fail")}}',
                  'error'
                )
            </script>

        @endif
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
