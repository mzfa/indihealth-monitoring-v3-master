 @if($data->is_done)
   <div class="btn-group" role="group" aria-label="Group">

            <button  disabled="disabled"  class="btn btn-secondary btn-disabled btn-sm" >
                <i class="fas fa-pencil-alt" >
                </i>
            </button>
            <button disabled="disabled"   type="button" class="btn btn-secondary btn-disabled btn-sm"  >
                <i class="fas fa-trash">
                </i>
            </button>
        </div>
 @else
 <div class="btn-group" role="group" aria-label="Group">

            <button class="btn btn-info btn-sm" onclick="editTask({{$data->id}})">
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteTask({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i class="fas fa-trash">
                </i>
            </button>
        </div>
        
@endif