@extends('layouts.app')

@section('title', 'Login Klien')
@section('content')
<div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper" style="height:100vh !important;">
        
          <div class="login-wrapper my-auto">
            <div class="login-title" @if(Agent::isMobile()) align="center" @endif> <img src="{{asset('assets/img/logo.png')}}" alt="logo" style="height:70px;" class="logo"></div>
            <form action="{{ route('guest.login') }}" method="POST">
               @csrf
                @if(Session::has('message'))
                <div class="alert alert-success" align="center">
                  {{Session::get('message')}}
                </div>
                @endif
              <label class="badge badge-info">Client Area</label>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="username" id="email" class="form-control" placeholder="username/email">
              </div>
              <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="masukan kata sandi anda">
              </div>
              <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Login">
               <input type="checkbox" name="remember" checked='true' id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </form>

            @if (Route::has('user.reset'))
            <a  href="{{ route('guest.reset') }}"  class="forgot-password-link">
                {{ __('Lupa Kata Sandi?') }}
            </a>
           @endif  | 
               <a href="{{route('login')}}" type="submit" class="badge badge-primary">Login Internal</a>
           @if(Agent::isMobile())
           <hr>
              <small class="mb-3">IndiHealth Monitoring Management {{config('app.version')}}</small><br>
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
        @error('password')
            <script type="text/javascript">
                Swal.fire(
                 '',
                  '{{$message}}',
                  'warning'
                )
            </script>
        
        @enderror
        @if(Session::has('message_fail'))
            <script type="text/javascript">
                Swal.fire(
                 '',
                  '{{Session::get('message_fail')}}',
                  'warning'
                )
            </script>
        
        @enderror
@endsection
