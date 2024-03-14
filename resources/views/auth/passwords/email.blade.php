@extends('layouts.app_old')
@section('title', 'Lupa Password | Indihealth Absensi')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="{{route('home')}}"><img src="{{asset('assets/img/logo.png')}}" width="280px"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Kami akan mengirimkan link untuk mengatur ulang kata sandi ke email anda.</p>
         @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
      <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>            
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Atur ulang kata sandi</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        
            <a  href="{{ route('login') }}">
                {{ __('Masuk ke sistem') }}
            </a>
      </p>
    
    </div>
    <!-- /.login-card-body -->
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
        
@endsection

