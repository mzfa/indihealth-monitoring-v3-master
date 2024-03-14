@extends('layouts/master_dashboard')
@section('title','Kelola Pengguna Sistem')
@section('content')

    <div class="row">
       
        <div class="col-md-3 col-sm-12">

           <a href="{{route('pengguna.create')}}" title="Tambah Pengguna"  class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Tambah Pengguna</a>
           <hr>
        </div>
        <div class="col-12">
            <div class="table-responsive-sm">
            <table class="table  table-bordered table-hover" id="penggunaTable">
                <thead>
                    <th>Online</th>
                    <th>Tema</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Hak Akses</th>
                    <th>Status</th>
                    <th>Karyawan terkait</th>
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
                $('#penggunaTable').DataTable({
                    "order": [[ 0, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
  },
                    ajax: "{{ route('pengguna.datatables')}}",
                    columns: [{
                            data: 'online',
                            name: 'online'
                        },{
                            data: 'mode',
                            name: 'mode'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },{
                            data: 'email',
                            name: 'email'
                        },{
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                         {
                            data: 'karyawan_terkait',
                            name: 'karyawan_terkait'
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