
@extends('layouts/master_dashboard')
@section('title',' Ubah Data Pengajuan Izin/Sakit')
@section('content')
<form action="{{route('izin.edit_act')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$izin->id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                   <label> Tanggal Mulai</label>
                    <input id="start" type="date" name="start" value="{{$izin->start}}"  class="form-control" required>
                   
                </div>
                <div class="col-md-6">
                      <label> Tanggal Selesai</label>
                    <input id="end" type="date" name="end" value="{{$izin->end}}"  class="form-control" required>
                </div>
            </div>
        </div>
         <div class="col-md-6">
              <label> Tipe Izin</label>
             <select id="jenis" name="jenis" class="form-control">
                 <option>-Pilih-</option>
                 <option  {{$izin->jenis == "S" ? "selected":null }} value="S">Sakit</option>
                 <option  {{$izin->jenis == "I" ? "selected":null }}  value="I">Izin</option>
             </select>
        </div>
        <div class="col-12"></div>
        <div id="foto-ket-sakit" style="{{$izin->jenis == "S" ? null:" display: none;"}}" class="col-md-6">
              <label> File/Foto Keterangan dari Dokter <small>(Ukuran Maks 10 MB berupa pdf,jpg,png,doc, atau docx)</label>
            <input type="file" name="file" {{$izin->jenis == "S" ? " ":"disabled"}} id="file-sakit"  class="form-control">
           <span class="badge badge-warning" style="font-size: 12px;">Jika anda mengupload file baru, file lama akan tertimpa</span>
        </div>
        <div class="col-md-12">
              <label> Keterangan</label>
             <textarea class="form-control" name="keterangan" required>{{$izin->keterangan}}</textarea>
        </div>
         <div class="col-md-3 col-xs-12">
            <hr>
             <button type="submit" class="btn btn-primary btn-block">Kirim</button>
         </div>
    </div>
</form>
@endsection
@section('javascript')
    <script type="text/javascript">
        $('#jenis').change(function(){
            var jenis = $(this).val()
            if(jenis == "S")
            {
                $("#foto-ket-sakit").fadeIn();
                $("#file-sakit").attr('disabled',false);
                $("#file-sakit").attr('required',true);
               
            } else
            {
                 $("#foto-ket-sakit").hide();
                  $("#file-sakit").attr('disabled',true);
                  $("#file-sakit").attr('required',false);
            }
        })
        $('#start').change(function(){

             $("#end").val('');
             $("#end").attr('min',$(this).val());
             $("#end").attr('readonly',false);
             $("#end").attr('onclick',null);
        })


    </script>
@endsection