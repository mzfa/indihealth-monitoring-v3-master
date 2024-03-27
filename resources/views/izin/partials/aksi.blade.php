
@Permission(['superadmin','hrd','owner'])
@if(!empty($data->file))
<a target="_blank" title="Unduh Dokumen" href="{{route('izin.download',['file' => $data->file])}}" class="btn btn-primary"><i id="icon-req-{{$data->id}}" class="fas fa-download"></i></a> 
@endif
@if($data->status == null)
  <a title="Setujui" href="{{route('izin.approve',['id' => $data->id])}}" onclick="return confirm('Anda akan memberikan izin ini?');" class="btn btn-success"><i id="icon-req-{{$data->id}}" class="fas fa-check"></i></a> 
  @if($data->created_by == auth()->user()->id)
 <a title="Edit" href="{{route('izin.edit',['id' => $data->id])}}" class="btn btn-warning"><i id="icon-req-{{$data->id}}" class="fas fa-edit"></i></a> 
 @endif
@elseif(!$data->status)
 @if($data->created_by == auth()->user()->id)
 <a title="Edit" href="{{route('izin.edit',['id' => $data->id])}}" class="btn btn-warning"><i id="icon-req-{{$data->id}}" class="fas fa-edit"></i></a> 
 @endif
@else
 @if($data->created_by == auth()->user()->id)
 <a title="Edit" href="{{route('izin.edit',['id' => $data->id])}}" class="btn btn-warning"><i id="icon-req-{{$data->id}}" class="fas fa-edit"></i></a> 
@endif
@endif
@endif
