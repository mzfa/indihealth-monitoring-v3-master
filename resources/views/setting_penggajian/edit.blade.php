@extends('layouts/master_dashboard')
@section('title','Ubah Pengguna '.$data->name)
@section('content')
<form action="{{route('pengguna.update')}}"  enctype='multipart/form-data' method="POST">
  <div class="row">
    @csrf
    <input type="hidden" name="id" value="{{$data->id}}">
    <div class="col-md-6 col-sm-12">
      <label>Nama Lengkap</label>
      <input type="text" required="" value="{{$data->name}}"  name="name" class="form-control">
      @error('name')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="col-md-6 col-sm-12">
      <label>Email</label>
      <input type="email" required="" value="{{$data->email}}" name="email" class="form-control">
      @error('email')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="col-md-6 col-sm-12">
      <label>Kata Sandi</label>
      <input type="password" placeholder="Tidak diubah" name="password" class="form-control">
      @error('password')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="col-md-6 col-sm-12">
      <label>Konfirmasi Kata Sandi</label>
      <input type="password" placeholder="Tidak diubah" name="password_confirmation" class="form-control">
      @error('password_confirmation')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="col-md-6 col-sm-12">
      <label>Karyawan Terkait</label>
      <select name="karyawan_terkait" id="select-karyawan" class="form-control">
        @if(!empty($data->karyawan))
        <option value="{{$data->karyawan_id}}" selected="selected">{{$data->karyawan->nama_lengkap." (".$data->karyawan->jabatan->nama.")"}}</option>
        @endif
      </select>
      @error('karyawan_terkait')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="col-md-6 col-sm-12">
      <label>Hak Akses</label>
      <select name="role" id="select-role" class="form-control">
        <option value="{{$data->role_id}}" selected="selected">{{strtoupper($data->role->name)}}</option>
      </select>
      @error('role')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    {{-- <div class="col-md-6 col-sm-12">
      <label>Divisi untuk Maintenance</label>
      <select name="division_id" id="division_id" class="form-control">
        @if(!empty($data->division))
        <option value="{{$data->target_ticketing_division_id}}" selected="selected">{{strtoupper($data->division->name)}}</option>
        @endif
      </select>
      @error('division_id')
      <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div> --}}
    <div class="col-md-12" align="right">
      <hr>
      <button type="submit" class="btn btn-success">Simpan</button>
    </div>
  </div>
</form>
@endsection
@section('javascript')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$('#select-karyawan').select2({
  ajax: {
    delay: 250,
    url: '{{route("karyawan.getSelectKaryawan")}}',
    dataType: 'json',
     data: function (params) {
        var query = {
            search: params.term,
          }
          return query;
    },
       processResults: function (data) {
      return {
        results: data
      };
    }
  }
});
$('#select-role').select2({
  ajax: {
    delay: 250,
    url: '{{route("pengguna.getSelectRoles")}}',
    dataType: 'json',
     data: function (params) {
        var query = {
            search: params.term,
          }
          return query;
    },
       processResults: function (data) {
      return {
        results: data
      };
    }
  }
});
$('#division_id').select2({
   dropdownAutoWidth : true,
    width: '100%',
    placeholder: "Pilih-Divisi",
  ajax: {
    delay: 250,
    url: '{{route("division.select")}}',
    dataType: 'json',
     data: function (params) {
        var query = {
            search: params.term,
          }
          return query;
    },
       processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data
      };
    }
    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
  }
})
</script>
@endsection
