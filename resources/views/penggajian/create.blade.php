@extends('layouts/master_dashboard')
@section('title','Tambah  Karyawan')
@section('content')
<form action="{{route('karyawan.save')}}"  enctype='multipart/form-data' method="POST">
    <div class="row">
        @csrf
        <div class="col-md-6 col-sm-12">
            <label>NIP</label>
            <input type="text" required="" name="nip" class="form-control">
            @error('nip')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>    
        <div class="col-md-6 col-sm-12">
            <label>Nama Lengkap</label>
            <input type="text" required=""  name="nama_lengkap" class="form-control">
             @error('nama_lengkap')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>     
        <div class="col-md-6 col-sm-12">
            <label>No Hp / No Telp</label>
            <input type="text" required=""  name="no_telp" class="form-control">
             @error('no_telp')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div> 
        <div class="col-md-6 col-sm-12">
            <label>Tempat Lahir</label>
            <input type="text" required=""  name="tempat_lahir" class="form-control">
             @error('tempat_lahir')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>    
        <div class="col-md-6 col-sm-12">
            <label>Tanggal Lahir</label>
            <input type="date" required=""  name="tanggal_lahir" class="form-control">
             @error('tanggal_lahir')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   
         <div class="col-md-6 col-sm-12">
            <label>Tipe Karyawan</label>
            <select class="form-control" required="" name="tipe_karyawan">
                <option>-Pilih-</option>
                <option value="FULL-TIME" >FULL-TIME</option>
                <option value="PART-TIME">PART-TIME</option>
            </select>
             @error('tipe_karyawan')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   
        <div class="col-md-6 col-sm-12">
            <label>Jabatan</label>
            <select required=""  name="jabatan" class="form-control">
                @foreach($jabatan as $j)
                    <option value="{{$j->id}}">{{$j->nama}}</option>
                @endforeach
            </select>
            @error('jabatan')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div> 
        <div class="col-md-6 col-sm-12">
            <label>Foto</label><br>
            <img src="data:image/png;base64,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" id="img" height="150px"><br>
            <span class="badge badge-warning">Ukuran file maksimal 3 MB dan bertipe jpg, gif, dan png</span>
            <input type="file" id="upload" name="img" class="form-control">
            @error('img')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-12" align="right">
            <hr>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>    
    </div>
</form>
@endsection
@section('javascript')
<script type="text/javascript">
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#img').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#upload").change(function() {
  readURL(this);
});
</script>
@endsection