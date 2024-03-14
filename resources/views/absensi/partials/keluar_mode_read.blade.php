@if(empty($data->jam_keluar))
  
    <span class='badge badge-warning'>Belum Absen</span>

@else
{{$data->jam_keluar}}
@endif
{{-- $conf->jam_pulang --}}
