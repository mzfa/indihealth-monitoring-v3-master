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
                    <th>Total Terima</th>
                    <th>Action</th>
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
                        <td><a href="{{ url('penggajian/detail/'.$item['id'].'/'.$periode) }}" class="btn btn-primary">Detail</a></td>
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

      </script>
@endsection