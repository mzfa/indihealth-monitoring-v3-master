 @if($data->is_done)
   <div class="btn-group" role="group" aria-label="Group">
     <button class="btn btn-success btn-sm" onclick="openTask({{$data->id}},1)">
         <i class="fas fa-unlock" id="icon-task-{{$data->id}}">
         </i>
     </button>
     <button class="btn btn-primary btn-sm" onclick="memberAssign({{$data->id}},1)">
         <i class="fas fa-users" id="icon-{{$data->id}}">
         </i>
     </button>
            <button  disabled="disabled"  class="btn btn-secondary btn-disabled btn-sm" >
                <i class="fas fa-edit"></i>
            </button>
            <button disabled="disabled"   type="button" class="btn btn-secondary btn-disabled btn-sm"  >
                <i class="fas fa-trash">
                </i>
            </button>
        </div>
 @else
 <div class="btn-group" role="group" aria-label="Group">

            <button class="btn btn-primary btn-sm" onclick="memberAssign({{$data->id}},0)">
                <i class="fas fa-users" id="icon-{{$data->id}}">
                </i>
            </button>
            <button class="btn btn-info btn-sm" onclick="editTask({{$data->id}})">
                <i class="fas fa-edit" id="icon-edit-{{$data->id}}">
                </i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteTask({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i class="fas fa-trash">
                </i>
            </button>
        </div>

@endif
