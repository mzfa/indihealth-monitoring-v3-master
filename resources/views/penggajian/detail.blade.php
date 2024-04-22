@extends('layouts/master_dashboard')
@section('title', 'Detail Penggajian')
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
        
        <div class="col-12">
            <form action="{{ url('penggajian/pengajuan') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover">
                        <thead>
                            @if (auth()->user()->role_id == 5)
                                <th>#</th>                         
                            @endif
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Tempat Tanggal Lahir</th>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Potongan</th>
                            <th>Total Terima</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach ($datanya as $item)
                            <input type="hidden" name="karyawan_id[]" value="{{ $item['id'] }}">
                            <input type="hidden" name="penggajian_detail_id[]" value="{{ $item['penggajian_detail_id'] }}">
                            @if (!empty($item['penggajian_detail_id']))
                                @if (auth()->user()->role_id == 5)
                                    <input type="hidden" name="form_jenis" value="acc">
                                @else
                                    <input type="hidden" name="form_jenis" value="update">
                                @endif
                            @else
                                <input type="hidden" name="form_jenis" value="insert">
                            @endif
                            <tr>
                                @if (auth()->user()->role_id == 5)
                                    <th><input type="checkbox" name="status_gaji[]" value="{{ $item['penggajian_detail_id'] }}"></th>                         
                                @endif
                                <th>{{ $item['nip'] }}</th>
                                <td>{{ $item['nama_lengkap'] }}</td>
                                <td>{{ $item['ttl'] }}</td>
                                <td>{{ $item['jabatan'] }}</td>
                                <td><input class="form-control" required type="number" name="gaji_pokok[]" value="{{ $item['gaji_pokok'] }}" readonly></td>
                                <td><input class="form-control" id="potongan_{{ $item['id'] }}" onkeyup="hitung({{ $item['id'] }})" required type="number" name="potongan[]" value="{{ $item['potongan'] }}" @if (auth()->user()->role_id == 5 || $item['status_penggajian'] == 'diterima') readonly @endif></td>
                                <td><input class="form-control" id="total_terima_{{ $item['id'] }}" required type="number" name="total_terima[]" value="{{ $item['total_terima'] }}" @if(auth()->user()->role_id == 5 || $item['status_penggajian'] == 'diterima') readonly @endif></td>
                                <td>
                                    @if($item['status_penggajian'] == 'diterima')
                                        <a target="_blank" href="{{ url('penggajian/slip_gaji/'.$item['penggajian_detail_id']) }}" class="badge badge-success">{{ $item['status_penggajian'] }}</a>
                                    @elseif($item['status_penggajian'] == 'ditolak')
                                        <a href="#" class="badge badge-danger">{{ $item['status_penggajian'] }}</a>
                                    @else
                                        <a href="#" class="badge badge-warning">{{ $item['status_penggajian'] }}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                @if (auth()->user()->role_id == 5)
                    <div class="row">
                        <div class="col-6">
                            <button onclick="return confirm('Apakah anda yakn datanya sudah benar?')" name="status" value="terima" type="submit" class="btn btn-primary btn-block">Terima</button>
                        </div>
                        <div class="col-6">
                            <button onclick="return confirm('Apakah anda yakn datanya sudah benar?')" name="status" value="tolak" type="submit" class="btn btn-danger btn-block">Tolak</button>
                        </div>
                    </div>
                @else
                    <button onclick="return confirm('Apakah anda yakn datanya sudah benar?')"  type="submit" class="btn btn-primary btn-block">@if(!empty($item['penggajian_detail_id'])) Perbaiki @else Buat @endif Pengajuan</button>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#penggajianTable').DataTable();
        });
        function edit(id){
            $.ajax({ 
                type : 'get',
                url : "{{ url('penggajian/edit')}}/"+id,
                success:function(tampil){
                    $('#tampildata').html(tampil);
                    $('#edit-penggajian').modal('show');
                } 
            })
        }
        function hitung(id){
            let gaji_pokok = "{{ $item['gaji_pokok'] }}";
            let namavar0 = 'potongan_'+id;
            let namavar1 = 'total_terima_'+id;
            let potongan = document.getElementById(namavar0).value;
            console.log(potongan);
            document.getElementById(namavar1).value = gaji_pokok - potongan;
        }

        // $("input.form-control").each((i,ele)=>{
        //     let clone=$(ele).clone(false)
        //     clone.attr("type","text")
        //     let ele1=$(ele)
        //     // clone.val(Number(ele1.val()).toLocaleString("en"))
        //     $(ele).after(clone)
        //     $(ele).hide()
        //     clone.mouseenter(()=>{

        //         ele1.show()
        //         clone.hide()
        //     })
        //     setInterval(()=>{
        //         let newv=Number(ele1.val()).toLocaleString("en")
        //         if(clone.val()!=newv){
        //             clone.val(newv)
        //         }
        //     },10)

        //     $(ele).mouseleave(()=>{
        //         $(clone).show()
        //         $(ele1).hide()
        //     })
            

        // })
    </script>
@endsection
