
 <div class="btn-group" role="group" aria-label="Group">

            <button class="btn btn-warning btn-sm" onclick="editProject({{$data->id}})">
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button>
            <button class="btn btn-info btn-sm" onclick="memberProject({{$data->id}})">
                <i class="fas fa-users" id="iconMember-{{$data->id}}">
                </i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteMember({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i class="fas  fa-archive ">
                </i>
            </button>
        </div>
