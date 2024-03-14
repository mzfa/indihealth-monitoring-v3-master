@if($cuti->status == 0)
<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveModal">
    Approve
</button>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
    Tolak
</button>

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
<button class="btn btn-success" disabled>approved:1</button>
@elseif($cuti->status == 2)
    <div class="row">
        <button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#reasonModal" disabled>
            rejected:2
        </button>

        <a href="" data-toggle="modal" data-target="#reasonModal_{{$cuti->id}}_reason_status" class="link-danger ml-3">see reason</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="reasonModal_{{$cuti->id}}_reason_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b> from: </b>{{@App\Models\Karyawan::find(App\Models\User::find($cuti->status_by)->karyawan_id)->nama_lengkap}} 
                    <a href="#">{{App\Models\User::find($cuti->status_by)->email}} </a>
                    ({{$cuti->status_by}})</p>
                <p>{{$cuti->reason_status}}</p>
            </div>
        </div>
    </div>
@endif