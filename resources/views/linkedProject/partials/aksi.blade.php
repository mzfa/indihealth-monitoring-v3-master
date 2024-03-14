
 <div class="btn-group" role="group" aria-label="Group">

            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProject({{$data->id}})"  id="delete-act-{{$data->id}}" data-id="{{$data->id}}">
                <i id="project-{{$data->id}}" class="fas  fa-unlink ">
                </i>
            </button> 
            <button type="button" class="btn btn-success btn-sm" onclick="copyLink('copy-{{$data->id}}')"  id="share-act-{{$data->id}}" data-id="{{$data->id}}">
                <i id="project-{{$data->id}}" class="fas  fa-copy ">
                </i>
            </button>
        </div>
