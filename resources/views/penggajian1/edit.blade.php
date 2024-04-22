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
            <label>No KTP</label>
            <input type="text" required="" value="{{$data->no_ktp}}"  name="no_ktp" class="form-control">
             @error('no_ktp')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   <div class="col-md-6 col-sm-12">
            <label>No NPWP</label>
            <input type="text" required="" value="{{$data->no_npwp}}"  name="no_npwp" class="form-control">
             @error('no_npwp')
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
       </div> 
        {{-- NEW --}}
        <div class="row">
        <div class="col-md-12 col-sm-12">
            <hr>
            <h5>Akun Git</h5>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Github Link<small> Optional</small></label>
            <input type="text"  name="github_link" value="{{$data->github_link}}"  class="form-control">
             @error('github_link')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>  
        <div class="col-md-6 col-sm-12">
            <label>Bitbucket Link<small> Optional</small></label>
            <input type="text"  name="bitbucket_link" value="{{$data->bitbucket_link}}"  class="form-control">
             @error('bitbucket_link')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>  
        <div class="col-md-6 col-sm-12">
            <label>Gitlab Link<small> Optional</small></label>
            <input type="text"  name="gitlab_link" value="{{$data->gitlab_link}}"  class="form-control">
             @error('gitlab_link')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-12 col-sm-12">
            <hr>
        </div>
        </div>
        <div class="row">  
        <div class="col-md-6 col-sm-12">
            <label>Tanggal Bergabung</label>
            <input type="date" required="" name="join_date" value="{{$data->join_date}}"  class="form-control">
             @error('join_date')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>  
        <div class="col-md-6 col-sm-12">
            <label>Tanggal Resign</label>
            <input type="date"  name="resign_date" value="{{$data->resign_date}}"  class="form-control">
             @error('resign_date')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>
         {{--  ENDNEW --}}  
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
            <input accept="image/*" type="file" id="upload" name="img" class="form-control">
            @error('img')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>
         <div class="col-md-6 col-sm-12">
            <label>CV / Portofolio</label><br>
            @if(!empty($data->cv))
            <?php $ext= explode('.', $data->cv);?>
                <a href="{{route('karyawan.cv',['cv' => $data->cv])}}" title="Tampilkan CV" target="_blank">
                    @if(strtolower($ext[1]) == 'pdf')
                    <img  height="150px" src="https://upload.wikimedia.org/wikipedia/commons/4/42/Pdf-2127829.png">
                    @else
                    <img height="150px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/Google_Docs_logo_%282014-2020%29.svg/555px-Google_Docs_logo_%282014-2020%29.svg.png">

                    @endif
                <br>
                <small class="badge badge-primary">Klik menampilkan CV</small>
                </a>
            @else
             <img src=" data:image/png;base64,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" id="img" height="150px">
            @endif
           <br>
            <span class="badge badge-warning">Ukuran file maksimal 20 MB dan bertipe pdf, dan doc</span>
            <input accept="application/pdf,application/msword,
  application/vnd.openxmlformats-officedocument.wordprocessingml.document"  type="file" id="upload" name="cv" class="form-control">
            @error('cv')
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