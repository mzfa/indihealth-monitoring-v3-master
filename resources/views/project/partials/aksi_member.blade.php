
 <div class="btn-group" role="group" aria-label="Group">
            @if(!$data->is_pm)
            <button title="Atur sebagai Project Manager" type="button" class="btn btn-outline-success btn-sm" onclick="setPM({{$data->id}})" >
                <i  id="icon-member-pm-{{$data->id}}"  class="fas  fa-user-tie ">
                </i>
            </button>
          @else
            <button type="button"  class="btn btn-outline-warning btn-sm" onclick="unsetPM({{$data->id}})" >
                <i  id="icon-member-pm-{{$data->id}}"  class="fas  fa-user-slash ">
                </i>
            </button>
          @endif
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteMember({{$data->id}})" >
                <i  id="icon-member-del-{{$data->id}}"  class="fas  fa-trash ">
                </i>
            </button>
        </div>
