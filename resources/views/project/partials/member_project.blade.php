@if(count($data->members) > 0)
<a href="javascript:void(0)" onclick="memberProject({{$data->id}})">{{count($data->members)}} Orang</a>
@else
<i>Belum ada</i>
@endif
