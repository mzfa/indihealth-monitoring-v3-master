 @if(!$data->is_done)
   <div class="btn-group" role="group" aria-label="Group">

            <button  disabled="disabled"  class="btn btn-secondary btn-disabled btn-sm" >
                <i class="fas fa-unlock-alt" >
                </i>
            </button>
        </div>
 @else
 <div class="btn-group" role="group" aria-label="Group">

            <button class="btn btn-success btn-sm" onclick="unlockTask({{$data->id}})">
                <i class="fas fa-unlock-alt" id="icon-{{$data->id}}">
                </i>
            </button>
           
        </div>
        
@endif