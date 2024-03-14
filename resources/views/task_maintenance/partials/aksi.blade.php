 @if($data->is_done)
   <div class="btn-group" role="group" aria-label="Group">

            <button  disabled="disabled"  class="btn btn-secondary btn-disabled btn-sm" >
                <i class="fas fa-pencil-alt" >
                </i>
            </button>
          
             <button  onclick="memberList({{$data->id}})"  class="btn btn-primary btn-disabled btn-sm" >
                <i id="memberList-{{$data->id}}" class="fas fa-users" >
                </i>
            </button>
              @Permission(['superadmin'])
            <button disabled="disabled"   type="button" class="btn btn-secondary btn-disabled btn-sm"  >
                <i class="fas fa-trash">
                </i>
            </button>
            @endPermission
        </div>
 @else
 <div class="btn-group" role="group" aria-label="Group">
          @if(TaskHelper::checkMember(auth()->user()->id, $data->id) OR Permission::for(['superadmin']))
          @if(time() > strtotime($data->end) AND Permission::for(['employee']))
            <button  disabled="disabled"  class="btn btn-secondary btn-disabled btn-sm" >
                <i class="fas fa-pencil-alt" >
                </i>
            </button>
            
            
            @else
            <button class="btn btn-info btn-sm" title="Tidak dapat mengubah tugas yang sudah deadline" onclick="editTask({{$data->id}})">
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button>
            @endif
            @Permission(['employee'])
            <button  onclick="memberList({{$data->id}})"  class="btn btn-primary btn-disabled btn-sm" >
                <i id="memberList-{{$data->id}}" class="fas fa-users" >
                </i>
            </button>
              @endPermission
          @else
          @Permission(['employee'])
          <span class="badge badge-light">Anda Bukan Member</span>
          @endPermission
          @endif
            @Permission(['superadmin'])
            <button  onclick="memberList({{$data->id}})"  class="btn btn-primary btn-disabled btn-sm" >
                <i id="memberList-{{$data->id}}" class="fas fa-users" >
                </i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteTask({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i class="fas fa-trash">
                </i>
            </button>
            @endPermission
        </div>

@endif
