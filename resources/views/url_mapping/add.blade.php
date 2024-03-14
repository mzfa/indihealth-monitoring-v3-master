@extends('layouts/master_dashboard')
@section('title','Add Url')
@section('content')
<form action="{{route('config.url.mapping.save')}}" method="POST">
  @csrf
  <div class=" mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <label>Name *</label>
            <input type="text" name="name" placeholder="cth: Absensi" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Url *</label>
            <input type="text" name="url" placeholder="cth: kelola/absensi" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Icon</label>
            <input type="text" name="icon" placeholder="cth: fas fa-calendar" class="form-control" required>
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
                  <option value="{{$m->id}}">{{$m->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label>Type</label>
                <select name="type" class="form-control">
                  <option value="page">Page</option>
                  <option   value="button">Button</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <label>Order</label>
                <ul  class="sortable list-group">
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 1</li>
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 2</li>
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 3</li>
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 4</li>
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 5</li>
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 6</li>
                    <li class="list-group-item sortable-item"><span class="fas fa-sort mr-4"></span>Item 7</li>
                  </ul>
                {{-- <input type="text" name="order_menus" placeholder="cth: 1.5 or 1" class="form-control"> --}}
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
  $.each($('.sortable').find('li'), function() {
        alert($(this).text());
    });
})


</script>
@endsection