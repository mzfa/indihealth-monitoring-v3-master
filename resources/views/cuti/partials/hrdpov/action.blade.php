@Permission(['owner','employee'])
    
@endPermission
@Permission(['hrd','superadmin'])
@if($cuti->status == 0)
<!-- Button trigger modal -->
<div class="btn-group" role="group" aria-label="Basic example">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveModal">
    Approve
</button>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
    Tolak
</button>

        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dw1" data-toggle="dropdown" aria-expanded="false">
           Aksi
          </button>
          <ul class="dropdown-menu" aria-labelledby="dw1">
            <li><a href="{{route("cuti.edit",['id' => $cuti->id])}}" class="dropdown-item">
            Ubah</a></li>
            <li>
        <a href="javascript:void();" onclick="if(confirm('Anda ingin menghapus data cuti ini?')){ event.preventDefault();
                  document.getElementById('del-c-{{$cuti->id}}').submit();}" class="dropdown-item">
            Hapus</a></li>
          </ul>
        </div>

{{--  --}}
</div>
<form id="del-c-{{$cuti->id}}" action="{{route('cuti.delete')}}" method="POST">
    @csrf
    <input type="hidden" name="cuti_id" value="{{$cuti->id}}">
</form>


    <!-- Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
            <form action="{{route("cuti.approve", $cuti->id)}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Ya</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route("cuti.disapprove", $cuti->id)}}" method="POST">
                    @csrf
                    <label for="reason_status">Masukkan alasan</label>
                    <textarea class="form-control" rows="3" id="reason_status" name="reason_status"></textarea>

                    <br>
                    <button type="submit" class="btn btn-danger form-control">Save changes</button>
                </form>
            </div>
        </div>
        </div>
@elseif($cuti->status == 1)
<div class="row">
    <button class="btn btn-light" disabled>Approved</button>
</div>
@elseif($cuti->status == 2)
<button type="button" class="btn btn-outline-danger  btn-block" data-toggle="modal" data-target="#reasonModal_{{$cuti->id}}_see_reason_adminpov">
    see reason
</button>
<div class="dropdown">
  <button class="btn btn-secondary btn-block mt-2 dropdown-toggle" type="button" id="dw1" data-toggle="dropdown" aria-expanded="false">
   Aksi
  </button>
  <ul class="dropdown-menu" aria-labelledby="dw1">
    <li><a href="{{route("cuti.edit",['id' => $cuti->id])}}" class="dropdown-item">
    Ubah</a></li>
    {{-- <li>
<a href="javascript:void();" onclick="if(confirm('Anda ingin menghapus data cuti ini?')){ event.preventDefault();
          document.getElementById('del-c-{{$cuti->id}}').submit();}" class="dropdown-item">
    Hapus</a></li> --}}
  </ul>
</div>
<form id="del-c-{{$cuti->id}}" action="{{route('cuti.delete')}}" method="POST">
    @csrf
    <input type="hidden" name="cuti_id" value="{{$cuti->id}}">
</form>



<!-- Modal -->
<div class="modal fade" id="reasonModal_{{$cuti->id}}_see_reason_adminpov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reject reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p><b> from: </b>
                {{$cuti->acc->nama_lengkap}} 
                </p>
            <p>{{$cuti->reason_status}}</p>
        </div>
    </div>
</div>
@endif 
@endPermission