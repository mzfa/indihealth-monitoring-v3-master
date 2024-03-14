
@extends('layouts/master_dashboard')
@section('title',' Pengajuan Izin / Sakit')
@section('content')
<div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6 col-xs-12">
            <a href="{{route('izin.request')}}" class="btn btn-primary btn-block">Ajukan Izin</a>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
      <div class="table-responsive-sm table-responsive-md">
        <table id="izin" class="table table-bordered table-striped">
            <thead>
                <th>File</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Waktu pengajuan</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
    
    $(function() {
      

              window.tableIzin =  $('#izin').DataTable({
                    "order": [[ 1, "DESC" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
                    "emptyTable": "Tidak ada data absensi yang dapat ditampilkan pada bulan ini."
                  },
                  
                    ajax: {
                            url: "{{ route('izin.datatables')}}",
                            type: 'POST',
                            "data": {
                                "_token": "{{ csrf_token() }}"
                            }
                        },

                    columns: [{
                            data: 'img',
                            name: 'img'
                        },{
                            data: 'start',
                            name: 'start'
                        },
                        {
                            data: 'end',
                            name: 'end'
                        },{
                            data: 'jenis',
                            name: 'jenis'
                        },{
                            data: 'keterangan',
                            name: 'keterangan'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                         {
                            data: 'aksi',
                            name: 'aksi'
                        },
                    ]
                });
            });
</script>
@endsection