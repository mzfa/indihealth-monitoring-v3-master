<style>
    .link-danger:hover {
        cursor: pointer;
    }
</style>
<p>
    {{Str::limit($cuti->reason_cuti, 15)}}
    <br>
    <a class="link-danger" data-toggle="modal" data-target="#reasonModal_{{$cuti->id}}">
        lihat detail
    </a>
</p>
<!-- Modal -->
<div class="modal fade" id="reasonModal_{{$cuti->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{$cuti->reason_cuti}}</p>
        </div>
    </div>
</div>