<table width="100%" border="1">
    <tr>
        <td colspan="17" align="center"><b>TUGAS KARYAWAN TANGGAL {{$start}} - {{$end}}</b></td>
    </tr>
</table>
<table width="100%" border="1">
    <thead >
        <tr bgcolor="">
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NO</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NAMA KARYAWAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JABATAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>TANGGAL</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>PROJEK</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>TUGAS</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>PROSES</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>STATUS</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>KESULITAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>SOLUSI</b></th>
            
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        @foreach($data as $d)
            <tr>
                <td>{{$i}}</td>
                <td>{{$d->karyawan->nama_lengkap}}</td>
                <td>{{$d->karyawan->jabatan->nama}}</td>
                <td>{{$d->tanggal}}</td>
                <td>{{$d->project->name}} ({{$d->project->client}})</td>
                <td>{{$d->task_name}}</td>
                <td>{{$d->process}}</td>
                <td>{{$d->is_done ? 'Done':'Progress'}}</td>
                <td>{{$d->kesulitan}}</td>
                <td>{{$d->solusi}}</td>
            </tr>
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>
