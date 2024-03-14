@extends('layouts/master_dashboard')
@section('title','Kelola  Penggajian')
@section('content')

    <div class="row">
        <div class="col-12">
            @error('start_date')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('end_date')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <h3>Periode Gajian</h3>
            <form action="{{route('penggajian')}}" method="GET">
                <div class="row">
                    @csrf
                    <label class="col-2">Periode Bulan</label>
                    <div class="col-10">
                        <input type="month" required="" name="periode" class="form-control">
                        @error('periode')
                        <span class="badge badge-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Cari</button>
            </form>
        </div>
        <hr>
        <div class="col-12 mt-3">
            <div class="table-responsive">
            <table class="table table-bordered table-hover" id="absenTable">
                <thead>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>Tempat Tanggal Lahir</th>
                    <th>Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($datanya as $item)
                    <tr>
                        <th>{{ $item['nip'] }}</th>
                        <td>{{ $item['nama_lengkap'] }}</td>
                        <td>{{ $item['ttl'] }}</td>
                        <td>{{ $item['jabatan'] }}</td>
                        <td>Rp. {{ number_format($item['gaji_pokok']) }}</td>
                        <td>Rp. {{ number_format($item['potongan']) }}</td>
                        <td>Rp. {{ number_format($item['gaji_pokok'] - $item['potongan']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>

    </div>
@endsection

@section('javascript')
 <script type="text/javascript">
        // $(function() {
//                 $('#absenTable').DataTable({
//                     "order": [[ 2, "asc" ]],
//                     processing: true,
//                     serverSide: true,
//                     autoWidth:false,
//                     "language": {
//     "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
//   },
//                     ajax: "{{ route('penggajian.datatables')}}",
//                     columns: [{
//                             data: 'foto',
//                             name: 'foto'
//                         },
//                         {
//                             data: 'nip',
//                             name: 'nip'
//                         },{
//                             data: 'nama_lengkap',
//                             name: 'nama_lengkap'
//                         },{
//                             data: 'tempat_tanggal_lahir',
//                             name: 'tempat_tanggal_lahir'
//                         },
//                         {
//                             data: 'no_telp',
//                             name: 'no_telp'
//                         },
//                         {
//                             data: 'kelengkapan',
//                             name: 'kelengkapan'
//                         },
//                         {
//                             data: 'status_aktif',
//                             name: 'status_aktif'
//                         }, {
//                             data: 'join_date',
//                             name: 'join_date'
//                         },
//                         {
//                             data: 'tipe',
//                             name: 'tipe'
//                         },
//                          {
//                             data: 'jabatan',
//                             name: 'jabatan'
//                         },
//                          {
//                             data: 'aksi',
//                             name: 'aksi'
//                         },
//                     ]
//                 });
//             });

      </script>
@endsection