@if(empty($data->jam_keluar))
    @if(!empty($data->request_absen_keluar))

      <span class='badge badge-secondary'>Menunggu Persetujuan</span><br>
      <small >Jam yang Diajukan :<br>{{$data->request_absen_keluar}}</small>

    @else
          <span class='badge badge-warning'>Belum Absen</span>
    @endif


@else
{{$data->jam_keluar}}
@endif
