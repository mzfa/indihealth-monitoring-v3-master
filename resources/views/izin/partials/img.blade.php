@Permission(['superadmin','hrd','owner','employee'])
  @if(!empty($data->file))
      <a title="Unduh Dokumen" target="_blank" href="{{route('izin.download',['file' => $data->file])}}" class="btn btn-primary btn-block"><i id="icon-req-{{$data->id}}" class="fas fa-download"></i></a> 


  @else
    <i>Tidak Ada</i>

  @endif
@endif
