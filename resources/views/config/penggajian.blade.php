@extends('layouts/master_dashboard')
@section('title','Atur Penggajian')
@section('content')
<form id="form-absen">
    <div class="row">
        @csrf
        <div class="col-md-6 col-sm-12">
            <label>Gaji Pokok</label>
            <input type="text" required="" name="gaji_pokok" id="gaji_pokok" value="{{$data->gaji_pokok ?? '' }}" class="form-control">
             @error('min_masuk')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>      
        <div class="col-md-6 col-sm-12">
            <label>Tunjangan Hari Raya</label>
            <input type="text" required=""  name="tunjangan" id="tunjangan" value="{{$data->tunjangan ?? '' }}" class="form-control">
             @error('max_masuk')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   
        <div class="col-md-12 col-sm-12 mt-3">

            <h3>Potongan</h3>
            <hr>
        </div>  
       <div class="col-md-6 col-sm-12">
            <label>Potongan Tidak Masuk</label>
            <input type="text" required=""  name="potongan_absen" id="potongan_absen" value="{{$data->potongan_absen ?? '' }}" class="form-control" data-placement="top" data-align="top" data-autoclose="true">
             @error('min_keluar')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>      
        <div class="col-md-6 col-sm-12">
            <label>Potongan Setengah Hari</label>
            <input type="text" required=""  name="potongan_setengah_hari" id="potongan_setengah_hari" class="form-control" value="{{$data->potongan_setengah_hari ?? '' }}" data-placement="top" data-align="top" data-autoclose="true">
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
         formData.append('gaji_pokok', $("#gaji_pokok").val());
         formData.append('tunjangan', $("#tunjangan").val());
         formData.append('potongan_absen', $("#potongan_absen").val());
         formData.append('potongan_setengah_hari', $("#potongan_setengah_hari").val());
         axios.post('{{route("config.penggajian.save")}}', formData)
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