
@extends('layouts/master_dashboard')
@section('title',' Buat Pengajuan Izin/Sakit')
@section('content')
<form action="{{route('izin.submit_request')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                   <label> Tanggal Mulai</label>
                    <input id="start" type="date" name="start"  class="form-control" required>
                   
                </div>
                <div class="col-md-6">
                      <label> Tanggal Selesai</label>
                    <input id="end" type="date" name="end" readonly onclick="alert('Pilih Tanggal Mulai dahulu')" class="form-control" required>
                </div>
            </div>
        </div>
         <div class="col-md-6">
              <label> Tipe Izin</label>
             <select id="jenis" name="jenis" class="form-control">
                 <option>-Pilih-</option>
                 <option value="S">Sakit</option>
                 <option value="I">Izin</option>
                 <option value="PC">Izin Pulang Cepat</option>
             </select>
        </div>
        <div class="col-12"></div>
        <div id="foto-ket-sakit" style="display: none;" class="col-md-6">
              <label> File/Foto Keterangan dari Dokter <small>(Ukuran Maks 10 MB berupa pdf,jpg,png,doc, atau docx)</label>
            <input type="file" name="file" disabled id="file-sakit" required class="form-control">
        </div>
        <div class="col-md-12">
              <label> Keterangan</label>
             <textarea class="form-control" name="keterangan" required></textarea>
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

             $("#end").attr('min',$(this).val());
             $("#end").attr('readonly',false);
             $("#end").attr('onclick',null);
        })


    </script>
@endsection