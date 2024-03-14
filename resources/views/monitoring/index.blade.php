@extends('layouts/master_dashboard')
@section('title','Monitoring Aplikasi')
@section('subtitle',"Monitoring Aplikasi yang telah dirilis")
@section('content')
<div class="row">
  <div class="col-12">
    <div class="table-responsive">
    <table id="appmon" class="table table-bordered table-striped">
      <thead>
        <th>Nama Aplikasi</th>
        <th>Domain</th>
        <th>IP Server</th>
        <th>Negara</th>
        <th>Kota</th>
        {{-- <th>lat</th>
        <th>lng</th> --}}
        <th>Tipe</th>
        <th>Sistem</th>
        <th>Perangkat Lunak</th>
        <th>Online Terakhir</th>
        <th>Pertama Dideteksi</th>
      </thead>
    </table>
  </div>
  </div>
</div>

@endsection
@section('javascript')
  <script>
  $(function(){
  window.table =    $('#appmon').DataTable({
         "order": [[ 8, "desc" ]],
         processing: true,
         serverSide: true,
         autoWidth:false,
         "language": {
"processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
},
         ajax: {
        'type': 'POST',
        'url': "https://tx-app.indihealth.com/api/v1/trx/getData",
        'data': {
           api_key: '29ffea913b1439932871a6c6ae8e164cadfc65b616a7cd8ad084e93212a94a77',
        }
        },
         columns: [
              {
                 data: 'project_name',
                 name: 'project_name'
             },
              {
                 data: 'domain',
                 name: 'domain'
             },
              {
                 data: 'server_ip',
                 name: 'server_ip'
             },
              {
                 data: 'country',
                 name: 'country'
             },
              {
                 data: 'city',
                 name: 'city'
             },
             //  {
             //     data: 'lat',
             //     name: 'lat'
             // },
             //  {
             //     data: 'lng',
             //     name: 'lng'
             // },
              {
                 data: 'type',
                 name: 'type'
             },
              {
                 data: 'operating_system',
                 name: 'operating_system'
             },
              {
                 data: 'software_server',
                 name: 'software_server'
             },
              {
                 data: 'last_online',
                 name: 'last_online'
             },
              {
                 data: 'detected_at',
                 name: 'detected_at'
             },
         ]

     });
     });
     </script>
@endsection
