
@if(in_array($data->status,['PENDING']))
  <span class="badge badge-light">Menunggu Konfirmasi</span>
@else
<div class="progress progress-sm">
  	<div class="progress-bar bg-blue" role="progressbar" aria-volumenow="{{$mt}}" aria-volumemin="0" aria-volumemax="100" style="width: {{$mt}}%">
  </div>
</div>
<small>
  {{$mt<100?number_format($mt,2,',','.'):100}}% Selesai
</small>
@endif
