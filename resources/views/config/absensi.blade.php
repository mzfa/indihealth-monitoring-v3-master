@extends('layouts/master_dashboard')
@section('title','Atur Jam Masuk/Keluar Absensi')
@section('content')
<form id="form-absen">
    <div class="row">
        @csrf
        <div class="col-md-12 col-sm-12">
            <h3>Absensi Masuk</h3>
            <hr>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Set Waktu masuk Minimal</label>
            <input type="text" required=""   name="masuk_start" id="masuk_start" value="{{$data->masuk_start ?? '' }}" class="form-control time">
             @error('min_masuk')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>      
        <div class="col-md-6 col-sm-12">
            <label>Set Waktu masuk maksimal</label>
            <input type="text" required=""  name="masuk_end" id="masuk_end" value="{{$data->masuk_end ?? '' }}" class="form-control time">
             @error('max_masuk')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   
        <div class="col-md-12 col-sm-12 mt-3">

            <h3>Absensi Keluar</h3>
            <hr>
        </div>  
       <div class="col-md-6 col-sm-12">
            <label>Set Waktu keluar Minimal</label>
            <input type="text" required=""  name="keluar_start" id="keluar_start" value="{{$data->keluar_start ?? '' }}" class="form-control time" data-placement="top" data-align="top" data-autoclose="true">
             @error('min_keluar')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>      
        <div class="col-md-6 col-sm-12">
            <label>Set Waktu keluar maksimal</label>
            <input type="text" required=""  name="keluar_end" id="keluar_end" class="form-control time" value="{{$data->keluar_end ?? '' }}" data-placement="top" data-align="top" data-autoclose="true">
             @error('max_keluar')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
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
         formData.append('masuk_start', $("#masuk_start").val());
         formData.append('masuk_end', $("#masuk_end").val());
         formData.append('keluar_start', $("#keluar_start").val());
         formData.append('keluar_end', $("#keluar_end").val());
         axios.post('{{route("config.absensi.save")}}', formData)
              .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("input").prop( "disabled", false );
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