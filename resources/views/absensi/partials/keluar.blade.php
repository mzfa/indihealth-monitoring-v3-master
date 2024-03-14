@if(empty($data->jam_keluar))
  @if(time() > (strtotime($data->tanggal.", ". $conf->jam_pulang ) + (60*60*2)))
    @if(empty($data->request_absen_keluar))
      <div class="mt-2">
      <button type="button" show-req-absen absen-id="{{$data->id}}" id="btnabsen-{{$data->id}}" class="btn btn-primary btn-sm actabsen" onclick="opensRequestAbsen({{$data->id}})" title="Request absensi pulang ke admin">Request Absen</button>
      <div id="jam-{{$data->id}}" class="jam" style="display:none">
      <input style="max-width:50px;" id="input-jam-{{$data->id}}" type="text" required="" placeholder="17:00"    name="jam_pulang" id="jam_pulang"  class=" time">
      <button onclick="requestAbsen({{$data->id}})" style="margin-top:-4px;"  type="button" class="btn btn-primary btn-sm" title="Request absensi pulang ke admin"><i class="fas fa-spin fa-spinner" style="display:none" id="icon-absen-{{$data->id}}"></i> Kirim</button>
      </div>
      </div>
    @else
      <span class='badge badge-secondary'>Menunggu Persetujuan</span>
    @endif

  @else
    <span class='badge badge-warning'>Belum Absen</span>
  @endif
@else
{{$data->jam_keluar}}
@endif
{{-- $conf->jam_pulang --}}
