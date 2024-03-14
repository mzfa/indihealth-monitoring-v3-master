<table width="100%" border="1">
    <tr>
        <td colspan="16" align="center"><b>LAPORAN CUTI {{strtoupper(\Illuminate\Support\Facades\Config::get('app.copyright'))}} TAHUN {{$year}}</b></td>
    </tr>
</table>
<table width="100%" style="border: 1px solid #000;">
    <thead >
        <tr bgcolor="">
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NO</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NIK</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NAMA KARYAWAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JAN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>FEB</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>MAR</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>APR</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>MEI</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JUN</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>JUL</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>AGT</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>SEP</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>OKT</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>NOP</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>DES</b></th>
            <th style="background-color: #365f92; color:#FFFFFF;"><b>TOTAL</b></th>
            
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        @foreach($karyawan as $d)
            <tr>
                <td>{{$i}}</td>
                <td>{{$d->nip}}</td>
                <td>{{$d->nama_lengkap}}<br>{{$d->jabatan->nama}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-01')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-02')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-03')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-04')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-05')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-06')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-07')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-08')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-09')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-10')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-11')}}</td>
                <td>{{UserHelper::cutiByYear($d->id,$year.'-12')}}</td>
                <td><b>{{UserHelper::cutiByYear($d->id,$year)}}</b></td>
                
            </tr>
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>
<table width="100%" border="1">
    <tr>
        <td colspan="16" align="center"></td>
    </tr>
</table>
<table width="100%" border="1">
    <tr >
        <td  align="center"></td>
        <td   align="center">Mengetahui</td>
    
        <td  align="center">Menyetujui</td>
    </tr> 
    <tr height="50" >
        <td   align="center"></td>
        <td  align="center"></td>
        <td  align="center"></td>
    </tr> 
    <tr  >
        <td  align="center"></td>
        <td  align="center"><b style="text-decoration: underline;">Admin HR</b></td>
        <td  align="center"><b style="text-decoration: underline;">Direktur</b></td>
    </tr>
</table>
