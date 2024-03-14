@extends('layouts/master_dashboard')
@section('title','Kelola  Karyawan')
@section('content')

    <div class="row">
        <div class="col-12">
            @error('start_date')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('end_date')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3 col-sm-12">

           <a href="{{route('karyawan.create')}}" title="Tambah Karyawan"  class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Tambah Karyawan</a>
           <hr>
        </div>
        <div class="col-12">
            <div class="table-responsive">
            <table class="table  table-bordered table-hover" id="absenTable">
                <thead>
                    <th>Foto</th>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>Tempat Tanggal Lahir</th>
                    <th>No Telp</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Join</th>
                    <th>Tipe</th>
                    <th>Jabatan</th>
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
                $('#absenTable').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
  },
                    ajax: "{{ route('karyawan.datatables')}}",
                    columns: [{
                            data: 'foto',
                            name: 'foto'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },{
                            data: 'nama_lengkap',
                            name: 'nama_lengkap'
                        },{
                            data: 'tempat_tanggal_lahir',
                            name: 'tempat_tanggal_lahir'
                        },
                        {
                            data: 'no_telp',
                            name: 'no_telp'
                        },
                        {
                            data: 'kelengkapan',
                            name: 'kelengkapan'
                        },
                        {
                            data: 'status_aktif',
                            name: 'status_aktif'
                        }, {
                            data: 'join_date',
                            name: 'join_date'
                        },
                        {
                            data: 'tipe',
                            name: 'tipe'
                        },
                         {
                            data: 'jabatan',
                            name: 'jabatan'
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