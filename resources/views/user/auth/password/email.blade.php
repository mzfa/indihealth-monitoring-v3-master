@extends('layouts.app')
@section('title', 'Lupa Kata Sandi | Indihealth Monitoring')
@section('content')
<div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper" style="height:100vh !important;">
        
          <div class="login-wrapper my-auto">
            <div class="login-title" @if(Agent::isMobile()) align="center" @endif> <img src="{{asset('assets/img/logo.png')}}" alt="logo" style="height:70px;" class="logo"></div>
            <form action="{{ route('user.send_mail') }}" method="POST">
               @csrf
                @if(Session::has('message'))
                <div class="alert alert-success" align="center">
                  {{Session::get('message')}}
                </div>
                @endif
                <label>E-mail</label>
              <input id="email" type="email" class="form-control" placeholder="nama@contoh.com" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus> 
              <div class="mb-2 mt-2" align="center">
               {!! htmlFormSnippet() !!}
                </div>
                 <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Atur ulang kata sandi">
            </form>
            <a  href="{{ route('login') }}">
                {{ __('Masuk ke sistem') }}
            </a>
             @if(Agent::isMobile())
           <hr>
              <small class="mb-3">IndiHealth Monitoring Management {{config('app.version')}}</small><br>
              <small class="mb-3">&copy; {{date("Y") }} <a target="_blank" href="https://indihealth.com">Indihealth</small>
            @endif
            
          
             
          </div>
        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block" style="background-image: url('{{asset('assets/login/images/login.jpg')}}');  background-size: cover; background-position: center;">
             <div class="mr-2" style="color: white;position: fixed; bottom: 0; right: 0;">&copy; {{date("Y") }} Indihealth. IndiHealth Monitoring Management {{config('app.version')}}</div>
          {{-- <img src="" alt="login image" class="login-img"> --}}
        </div>
      </div>
    </div>
</div>

@endsection
@section('javascript')
    @error(recaptchaFieldName())
            <script type="text/javascript">
                Swal.fire(
                  '',
                  '{{$message}}',
                  'warning'
                )
            </script>
        
        @enderror 
    @error('email')
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
        
        @endif 
    @if(Session::has('message_success'))
            <script type="text/javascript">
                Swal.fire(
                  '',
                  '{{Session::get('message_success')}}',
                  'success'
                )
            </script>
        
        @endif 
        
@endsection

