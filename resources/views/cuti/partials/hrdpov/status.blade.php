@if($cuti->status == 1)
<button class="btn btn-success" disabled>Disetujui</button>
@elseif($cuti->status == 2)
    <div class="row">
        <button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#reasonModal" disabled>
            Ditolak
        </button>

    </div>
@endif