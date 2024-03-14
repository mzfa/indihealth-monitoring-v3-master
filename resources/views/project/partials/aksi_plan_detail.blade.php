
 <div class="btn-group" role="group" aria-label="Group">

            <button type="button" class="btn btn-warning btn-sm" onclick="editPlanDetail({{$data->id}})" >
                <i  id="icon-plan-dtl-edit-{{$data->id}}"  class="fas  fa-edit ">
                </i>
            </button>
            @if(count($data->tasks) <= 0)
            <button type="button" class="btn btn-danger btn-sm" onclick="deletePlanDetail({{$data->id}})" >
                <i  id="icon-plan-dtl-del-{{$data->id}}"  class="fas  fa-trash ">
                </i>
            </button>
          @else
            <button type="button" class="btn btn-secondary btn-sm" disabled title="Tidak dapat dihapus, karena sudah ada tugas yang terkait">
                <i  id="icon-plan-dtl-del-{{$data->id}}"  class="fas  fa-trash ">
                </i>
            </button>

          @endif
        </div>
