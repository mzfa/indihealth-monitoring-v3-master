
 <div class="btn-group" role="group" aria-label="Group">

            <button class="btn btn-info btn-sm" onclick="editGuest({{$data->id}})">
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button> 
            <button title="Hubungkan dengan projek" id="link-project-{{$data->id}}" class="btn btn-success btn-sm" onclick="addProject({{$data->id}})">
                <i class="fas fa-project-diagram " id="icon-project-{{$data->id}}">
                </i>
            </button>
            @if($data->is_banned)
                 <button type="button" class="btn btn-primary btn-sm" onclick="enableGuest({{$data->id}})"  id="enable-act-{{$data->id}}" data-id="{{$data->id}}">
                    <i class="fas  fa-check ">
                    </i>
                </button>
            @else
                <button type="button" class="btn btn-danger btn-sm" onclick="disableGuest({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                    <i class="fas  fa-ban ">
                    </i>
                </button>
            @endif
        </div>
