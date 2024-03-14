<input type="text" readonly="" value="{{route('share.link',['shareable_link' => $data->shareable_link])}}" id="copy-{{$data->id}}" class="form-control">
<small>Shared: </small>
@if($data->shareable_task_dev)
<span class="badge badge-success">DEV</span>
@else
<span class="badge badge-secondary">DEV</span>
@endif

{{-- @if($data->shareable_task_mt)
<span class="badge badge-success">MT</span>
@else
<span class="badge badge-secondary">MT</span>
@endif --}}

@if($data->shareable_notulen)
<span class="badge badge-success">N</span>
@else
<span class="badge badge-secondary">N</span>
@endif
