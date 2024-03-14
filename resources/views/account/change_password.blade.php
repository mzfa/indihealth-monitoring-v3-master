@extends('layouts/master_dashboard')
@section('title','Ubah Kata sandi')
@section('content')
<div class="callout callout-info">
                  <h5>Tips membuat kata sandi yang aman</h5>
              <p>
                <ul>
                  <li>Gunakan kombinasi angka, simbol, huruf kapital dan kecil.</li>
                  <li>Jangan menggunakan kata sandi yang sama dengan akun lainnya.</li>
                  <li>Jangan menggunakan informasi pribadi sebagai kata sandi seperti tanggal lahir, plat nomor, no telepon, alamat email, username, dll.</li>
                  
                   
                </ul>
              </p>
                </div>
<div class="row">
  <div class="col-md-6">
  <form action="{{route('password.update')}}" method="POST">
    @csrf
    <div class="form-group">
      <label for="old_pwd">Kata Sandi Lama</label>
      <input type="password" class="form-control" id="old_pwd" name="password_old" required="" autocomplete="off" placeholder="Kata sandi lama">
      @error("password_old")
        <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>  
    <div class="form-group">
      <label for="new_pwd">Kata Sandi Baru<small> *min 8 Karakter</small></label>
      <input type="password" class="form-control" id="new_pwd" name="password" required="" autocomplete="off" placeholder="Kata sandi baru">
       @error("password")
        <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="form-group">
      <label for="cnf_new_pwd">Konfirmasi Kata Sandi Baru</label>
      <input type="password" class="form-control" id="cnf_new_pwd" name="password_confirmation" required="" autocomplete="off" placeholder="Konfirmasi kata sandi baru">
      @error("password_confirmation")
        <span class="badge badge-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="row">
      <div class="col-sm-4">
        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Ubah Kata Sandi</button>
    </div>
  </div>
  </form>
</div>
</div>
@endsection