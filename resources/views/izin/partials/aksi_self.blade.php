@Permission(['superadmin','hrd','owner','employee'])
  @if($data->status == null)

   <a title="Edit" href="{{route('izin.editSelf',['id' => $data->id])}}" class="btn btn-warning"><i id="icon-edit-{{$data->id}}" class="fas fa-edit"></i></a>
  <a title="Cancel"  href="{{route('izin.cancel_req',['id' => $data->id])}}" onclick=" return confirm('Anda akan membatalkan ini?');" class="btn btn-danger"><i id="icon-cancel-{{$data->id}}" class="fas fa-times"></i></a>
  @elseif($data->status==0)

 <a title="Edit" href="{{route('izin.editSelf',['id' => $data->id])}}" class="btn btn-warning"><i id="icon-edit-{{$data->id}}" class="fas fa-edit"></i></a>

  @else


  @endif
@endif
