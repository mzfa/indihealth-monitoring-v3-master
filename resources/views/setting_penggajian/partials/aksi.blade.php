<div class="btn-group" role="group" aria-label="Basic example">
<a href="{{route('pengguna.edit',['id' => $data->id])}}" title="Ubah data" class="btn btn-warning"><i class="fas fa-edit"></i></a>
@if(!$data->is_disabled)
@if($data->role->name != "superadmin")
<a href="#nonaktifkan-{{$data->id}}" title="nonaktifkan" data-toggle="modal" data-target="#nonaktifkan-{{$data->id}}" class="btn btn-danger"><i class="fas fa-ban"></i></a>
<!-- Modal -->
<div class="modal fade" id="nonaktifkan-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Nonaktifkan {{$data->nama}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center">
        <label>Apakah anda yakin ingin menonaktifkan pengguna ini?</label>
        <form action="{{route('pengguna.disable')}}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{$data->id}}">
          <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-2"></i>Non-aktifkan</button>
          <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
        </form>
      </div>
     
    </div>
  </div>
</div>
@else
<button type="button" disabled="disabled" title="Tidak dapat menonaktifkan pengguna ini" class="btn btn-danger btn-disabled"><i class="fas fa-ban"></i></button>
@endif
@else
<a href="#aktifkan-{{$data->id}}" title="Aktifkan" data-toggle="modal" data-target="#aktifkan-{{$data->id}}" class="btn btn-success"><i class="fas fa-check"></i></a>


<!-- Modal -->
<div class="modal fade" id="aktifkan-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Aktifkan {{$data->nama}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="center">
        <label>Apakah anda yakin ingin mengaktifkan pengguna ini?</label>
        <form action="{{route('pengguna.enable')}}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{$data->id}}">
          <button type="submit" class="btn btn-success"><i class="fas fa-check mr-2"></i>Aktifkan</button>
          <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
        </form>
      </div>
     
    </div>
  </div>
</div>
@endif
</div>

