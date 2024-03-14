@extends('layouts/master_dashboard')
@section('title','Atur Jam Pulang')
@section('content')
<form id="form-absen">
    <div class="row">
        @csrf
        <div class="col-md-12 col-sm-12">
            <h3>Pengaturan Jam Pulang</h3>
            <hr>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="alert alert-default-info" align="center">Sistem akan memunculkan notifikasi kepada semua pengguna sistem <span id="alert_minutes">{{$data->notify_minutes ?? ''}}</span> menit sebelum jam <span class="alert_jam_pulang">{{$data->jam_pulang ?? ''}}</span> untuk melakukan absensi pulang.</div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Atur jam pulang</label>
            <input type="text" required="" placeholder="17:00"    name="jam_pulang" id="jam_pulang" value="{{$data->jam_pulang ?? ''}}" class="form-control time">
           
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Beritahu karyawan untuk absensi pulang setiap <small>(Menit)</small></label>
            <input type="number" min="5" required="" placeholder="10" max="120"  name="minutes" id="minutes" value="{{$data->notify_minutes ?? ''}}" class="form-control ">
        </div>
        <div class="col-md-12" align="right">
            <hr>
            <button type="submit" submit-button class="btn btn-success"><i class="fas fa-spinner fa-spin" spinner style="display: none;"></i> Simpan</button>
        </div>    
    </div>
</form>
@endsection
@section('javascript')
<link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
<script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>
    <script type="text/javascript">
     $('.time').clockpicker({donetext: 'Selesai',autoclose:true});

     $('#form-absen').submit(function(e){
        e.preventDefault();
         $("[spinner]").show();
         $("[submit-button]").prop( "disabled", true );
         $("input").prop( "disabled", true );
         let formData = new FormData();
         formData.append('jam_pulang', $("#jam_pulang").val());
         formData.append('minutes', $("#minutes").val());
         axios.post('{{route("config.pulang.save")}}', formData)
              .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("input").prop( "disabled", false );
                $("#alert_minutes").html(response.data.config.data.notify_minutes)
                $("#alert_jam_pulang").html(response.data.config.data.jam_pulang)
                Swal.fire({
                    title: 'Sukses!',
                    text: response.data.config.message_success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                  })
                console.log(response.data.config.message_success)
              })
              .catch(function (error) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("input").prop( "disabled", false );
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
     });
    </script>
@endsection