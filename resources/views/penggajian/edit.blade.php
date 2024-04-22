@extends('layouts/master_dashboard')
@section('title','Ubah  Karyawan '.$data->nama_lengkap)
@section('content')
<form action="{{route('karyawan.update')}}"  enctype='multipart/form-data' method="POST">
    <div class="row">
        @csrf
        <div class="col-md-6 col-sm-12">
            <input type="hidden" name="id" value="{{$data->id}}">
            <label>NIP</label>
            <input type="text" required="" value="{{$data->nip}}" name="nip" class="form-control">
            @error('nip')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>    
        <div class="col-md-6 col-sm-12">
            <label>Nama Lengkap</label>
            <input type="text" required="" value="{{$data->nama_lengkap}}"  name="nama_lengkap" class="form-control">
             @error('nama_lengkap')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>     
        <div class="col-md-6 col-sm-12">
            <label>No Hp / No Telp</label>
            <input type="text" required="" value="{{$data->no_telp}}"  name="no_telp" class="form-control">
             @error('no_telp')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div> 
        <div class="col-md-6 col-sm-12">
            <label>Tempat Lahir</label>
            <input type="text" required="" value="{{$data->tempat_lahir}}"  name="tempat_lahir" class="form-control">
             @error('tempat_lahir')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>    
        <div class="col-md-6 col-sm-12">
            <label>Tanggal Lahir</label>
            <input type="date" required="" value="{{$data->tanggal_lahir}}"  name="tanggal_lahir" class="form-control">
             @error('tanggal_lahir')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>  
        <div class="col-md-6 col-sm-12">
            <label>Tipe Karyawan</label>
            <select class="form-control" required="" name="tipe_karyawan">
                <option>-Pilih-</option>
                <option value="FULL-TIME" {{$data->tipe_karyawan == "FULL-TIME"?"selected='selected'":null}}>FULL-TIME</option>
                <option value="PART-TIME" {{$data->tipe_karyawan == "PART-TIME"?"selected='selected'":null}}>PART-TIME</option>
            </select>
             @error('tipe_karyawan')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   
        <div class="col-md-6 col-sm-12">
            <label>Jabatan</label>
            <select required=""  name="jabatan" class="form-control">
                @foreach($jabatan as $j)
                    <option value="{{$j->id}}" {{$data->jabatan_id == $j->id ? 'selected="selected"':null}}>{{$j->nama}}</option>
                @endforeach
            </select>
            @error('jabatan')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div> 
        <div class="col-md-6 col-sm-12">
            <label>Foto</label><br>
            <img src="{{route('showFotoKaryawan',['file' => empty($data->foto)?'default.jpg':$data->foto])}}" id="img" height="150px">
            <br>
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