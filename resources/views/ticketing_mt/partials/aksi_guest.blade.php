
 @if($data->status == "DONE" AND empty($data->feedback))
 <div class="btn-group" role="group" aria-label="Group">
            <a class="btn btn-success btn-sm" title="Konfirmasi Perbaikan" onclick="sendFeedback({{$data->id}})">
                <i class="fas fa-check" id="icon-{{$data->id}}">
                </i>
            </a>
        </div>
@elseif(!empty($data->feedback))
<span class="badge badge-light"><i class="fas fa-check-circle" ></i></span>
@endif
