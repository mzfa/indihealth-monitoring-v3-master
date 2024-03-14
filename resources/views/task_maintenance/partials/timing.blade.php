@if(time() > strtotime($data->end) AND !$data->is_done)
<div class="row bg-danger" >
	<div class="col-md-12" >
		<b>Mulai:</b><br>
		{{date('Y-m-d H:i',strtotime($data->start))}}
	</div>
	<div class="col-md-12">
		<b>Selesai:</b><br>
		{{date('Y-m-d H:i',strtotime($data->end))}}
	</div>
	<div class="col-md-12">
		<b>Timing:</b><br>
		{{$data->timing}}
	</div>
</div>
@elseif($data->is_done)
<div class="row bg-success" >
	<div class="col-md-12" >
		<b>Mulai:</b><br>
		{{date('Y-m-d H:i',strtotime($data->start))}}
	</div>
	<div class="col-md-12">
		<b>Selesai:</b><br>
		{{date('Y-m-d H:i',strtotime($data->end))}}
	</div>
	<div class="col-md-12">
		<b>Timing:</b><br>
		{{$data->timing}}
	</div>
</div>
@else
<div class="row" >
	<div class="col-md-12" >
		<b>Mulai:</b><br>
		{{date('Y-m-d H:i',strtotime($data->start))}}
	</div>
	<div class="col-md-12">
		<b>Selesai:</b><br>
		{{date('Y-m-d H:i',strtotime($data->end))}}
	</div>
	<div class="col-md-12">
		<b>Timing:</b><br>
		{{$data->timing}}
	</div>
</div>
@endif