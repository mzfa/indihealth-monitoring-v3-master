
 <div class="btn-group" role="group" aria-label="Group">
            @if($data->status == "CONFIRMED")
            <button class="btn btn-secondary btn-sm" disabled >
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button>
            @else
              <button class="btn btn-info btn-sm" onclick="ubahStatus({{$data->id}})">
                <i class="fas fa-pencil-alt" id="icon-{{$data->id}}">
                </i>
            </button>
            @endif
          
            <a class="btn btn-success btn-sm" href="mailto:{{$data->guest->email}}?&subject=Balasan untuk no tiket maintenance {{$data->no_ticket}}">
                <i class="fas fa-envelope" id="icon-{{$data->id}}">
                </i>
            </a>
        </div>
