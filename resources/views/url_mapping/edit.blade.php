@extends('layouts/master_dashboard')
@section('title','Edit Url')
@section('content')
<form action="{{route('config.url.mapping.update')}}" method="POST">
  @csrf
  <input type="hidden" name="id" value="{{$data->id}}">
<div class=" mt-3">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <label>Name *</label>
          <input type="text" name="name" placeholder="cth: Absensi" value="{{$data->name}}" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Url *</label>
          <input type="text" name="url" placeholder="cth: kelola/absensi"  value="{{$data->url}}"class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Icon</label>
          <input type="text" name="icon" placeholder="cth: fas fa-calendar" value="{{$data->icon}}" class="form-control" required>
        </div>  
        <div class="col-md-6">
          <label>Order</label>
          <input type="text" name="order_menus" placeholder="cth: 1.5 or 1" value="{{$data->order_menus}}" class="form-control">
        </div>
        
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <label>Parent</label>
              <select  name="parent_id" class="form-control">
                <option>-Kosong- </option>
                @foreach($mapping as $m)
                <option @if($m->id == $data->parent_id) selected="selected" @endif value="{{$m->id}}">{{$m->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label>Type</label>
               <select name="type" class="form-control">
                <option @if("page" == $data->type) selected="selected" @endif value="page">Page</option>
                <option @if("button" == $data->type) selected="selected" @endif  value="button">Button</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6 col-xs-12">
              <button class="btn btn-primary btn-block"><i class="fas fa-check"></i> Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
$('#url-table').DataTable({})
})
</script>
@endsection