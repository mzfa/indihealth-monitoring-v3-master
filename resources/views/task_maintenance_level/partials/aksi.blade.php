
 <div class="btn-group" role="group" aria-label="Group">

            <button class="btn btn-info btn-sm" onclick="editLevel({{$data->id}})">
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteLevel({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i class="fas  fa-archive ">
                </i>
            </button>
        </div>
