@extends('layouts/master_dashboard')
@section('title','Penggajian')
@section('content')

<form id="form-absen">
    <div class="row">
        @csrf
        <div class="col-md-12 col-sm-12">
            <h3>Setting Penggajian</h3>
            <hr>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Gaji Pokok</label>
            <input type="text" required="" name="gaji_pokok" id="gaji_pokok" value="{{$data->gaji_pokok ?? '' }}" class="form-control">
             @error('min_masuk')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>      
        <div class="col-md-6 col-sm-12">
            <label>Tunjangan Lebaran</label>
            <input type="text" required=""  name="tunjangan_lebaran" id="tunjangan_lebaran" value="{{$data->tunjangan_lebaran ?? '' }}" class="form-control">
             @error('max_masuk')
            <span class="badge badge-danger">{{$message}}</span>
            @enderror
        </div>   
        <div class="col-md-12" align="right">
            <hr>
            <button type="submit" submit-button class="btn btn-success"><i class="fas fa-spinner fa-spin" spinner style="display: none;"></i> Simpan</button>
        </div>    
    </div>
</form>
@endsection

@section('javascript')
 <script type="text/javascript">
        $(function() {
                $('#PenggajianTable').DataTable({
                    "order": [[ 0, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
  },
                    ajax: "{{ route('setting_penggajian.datatables')}}",
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