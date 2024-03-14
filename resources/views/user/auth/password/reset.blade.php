@extends('layouts.app_old')
@section('title', 'Atur Ulang Kata Sandi | Indihealth Monitoring')
@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="{{route('home')}}"><img src="{{asset('assets/img/logo.png')}}" width="280px"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Buat kata sandi baru</p>

      <form action="{{ route('user.reset.act') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="hidden" value="{{$code}}" name="code">
           <input id="password" type="password" placeholder="Kata sandi baru" class="form-control" name="password"  autocomplete="off" autofocus>            
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="hidden" value="{{$code}}" name="code">
           <input id="password" type="password" placeholder="Konfirmasi kata sandi" class="form-control" name="password_confirmation"  autocomplete="off" autofocus>            
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
       
        <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Atur Ulang Kata sandi</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


     
    
    </div>
    <!-- /.login-card-body -->
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