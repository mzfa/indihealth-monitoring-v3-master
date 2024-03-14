<table width="100%" border="1">
    <tr>
        <td colspan="17" align="center"><b>ABSENSI TANGGAL {{$start}} - {{$end}}</b></td>
    </tr>
</table>
<table width="100%" border="1">
    <thead >
        <tr bgcolor="">
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NO</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NIP</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NAMA LENGKAP</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JABATAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>TIPE KARYAWAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>TANGGAL</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JAM KERJA</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JAM MASUK</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JAM KELUAR</b></th>
            <th style="background-color: yellow; color:#FFFFFF;"> </th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>IP ADDRESS</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>BROWSER</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>PLATFORM</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>LATITUDE</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>LONGITUDE</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>LATITUDE PULANG</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>LONGITUDE PULANG</b></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        @foreach($data as $d)
            <tr>
                <td>{{$i}}</td>
                <td>{{$d->karyawan->nip}}</td>
                <td>{{$d->karyawan->nama_lengkap}}</td>
                <td>{{$d->karyawan->jabatan->nama}}</td>
                <td>{{$d->karyawan->tipe_karyawan}}</td>
                <td>{{$d->tanggal}}</td>
                <td>{{$d->jam_kerja}}</td>
                <td>{{$d->jam_masuk}}</td>
                <td>{{$d->jam_keluar}}</td>
                <td style="background-color: yellow; color:#FFFFFF;"></td>
                <td>{{$d->ip_address}}</td>
                <td>{{$d->browser}}</td>
                <td>{{$d->platform}}</td>
                <td>{{$d->lat}}</td>
                <td>{{$d->lng}}</td>
                <td>{{$d->lng_pulang}}</td>
                <td>{{$d->lat_pulang}}</td>
            </tr>
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>

<table border="1">
     <tr>
            <td style="background-color: yellow; color:#000000;" align="center"><b>Jumlah Absensi</b></td>
            <td style="background-color: yellow; color:#000000;" align="center"><b>Rata - rata jam kerja</b></td>
        </tr>
  
        <tr>
            <td style="background-color: yellow; color:#000000;" align="center">{{count($data)}}</td>
            <td style="background-color: yellow; color:#000000;" align="center">{{number_format($avg_hours,2)}} jam</td>
        </tr>
</table>