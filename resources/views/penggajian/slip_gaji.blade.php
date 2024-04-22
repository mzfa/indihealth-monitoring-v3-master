@extends('layouts/master_dashboard')
@section('title','Kelola  Penggajian')
@section('content')

<div class="container">
    <div class="card" id="printableArea">
        <div class="card-header">
            BUKTI GAJI
            <strong>01/01/01/2018</strong>
            <span class="float-right"> <strong>Waktu Cetak : </strong> {{ date('l d-F-Y H:i:s') }}</span>

        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <table>
                        <tr>
                            <th><p>Nama Lengkap </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->nama_lengkap }}</p></td>
                        </tr>
                        <tr>
                            <th><p>Tempat Lahir </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->tempat_lahir }}</p></td>
                        </tr>
                        <tr>
                            <th><p>Tanggal Lahir </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ date('d-M-Y', strtotime($data->tanggal_lahir)) }}</p></td>
                        </tr>
                        <tr>
                            <th><p>No NPWP </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->no_npwp }}</p></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table>
                        <tr>
                            <th><p>NIP </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->nip }}</p></td>
                        </tr>
                        <tr>
                            <th><p>NO KTP </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->no_ktp }}</p></td>
                        </tr>
                        <tr>
                            <th><p>Tipe Karyawan </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->tipe_karyawan }}</p></td>
                        </tr>
                        <tr>
                            <th><p>Jabatan </p></th>
                            <th> <p> : </p></th>
                            <td><p>{{ $data->jabatan_id }}</p></td>
                        </tr>
                    </table>
                </div>



            </div>

            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Item</th>
                            <th>Keterangan</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">1</td>
                            <td class="left strong">Gaji Pokok</td>
                            <td class="left">Gaji Pokok Pegawai</td>
                            <td class="right">Rp. {{ number_format($data->gaji_pokok) }}</td>
                        </tr>
                        <tr>
                            <td class="center">2</td>
                            <td class="left strong">Potongan</td>
                            <td class="left">Potongan Absensi sebanyak </td>
                            <td class="right">Rp. {{ number_format($data->potongan) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">

                </div>

                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left">
                                    <strong>Total</strong>
                                </td>
                                <td class="right">
                                    <strong>Rp. {{ number_format($data->gaji_pokok- $data->potongan) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
            
        </div>
    </div>
    <input type="button" class="btn btn-primary btn-block" onclick="printDiv('printableArea')" value="Cetak Slip Gaji" />
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection