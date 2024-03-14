@extends('layouts/master_dashboard')
@section('title',$meet->room_name)
@section('content')

<div class="row justify-content-md-center">
    <div class="col-md-3 col-sm-12">
        <form method="POST" id="pin-form" action="{{route('meeting.room',['room_name' => $meet->room_code])}}">
      <div class="card">
        <div class="card-header"><h5>Masukan PIN Ruangan</h5></div>
        <div class="card-body">
            @csrf
            <input type="text" id="pincode"  name="password" >
            <hr>
            <button type="submit" class="btn btn-success btn-block">Mulai Meeting</button>
        </div>
    </div>
        </form>
  </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-6 col-sm-12">
        <small> Peserta Meeting</small><br>
        @foreach($attmeet as $m)
          <img class="img-circle" width="50px" height="50px" src="{{route('showFotoKaryawan',['file' => empty($meet->user->karyawan)?'default.jpg':$meet->user->karyawan->foto])}}">
        @endforeach
  </div>
</div>
@if(!empty($meet->description))
<div class="row">
<div class="col-md-12">
    <div class="callout callout-success">
        <b>Deskripsi:<br></b>
        {!!$meet->description!!}
    </div>

</div>
</div>
@endif
    <link rel="stylesheet" href="{{asset('assets/pin-code/css/bootstrap-pincode-input.css')}}">
    <script src="{{asset('assets/pin-code/js/bootstrap-pincode-input.js')}}"></script>
      <script type="text/javascript">
         $('#pincode').pincodeInput({inputs:6,complete:function(value, e, errorElement){
            $('#pin-form').submit();
        }}).focus();

      </script>
@endsection
