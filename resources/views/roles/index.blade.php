@extends('layouts/master_dashboard')
@section('title','Kelola Roles')
@section('content')
<div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <a href="{{route('config/roles/add')}}" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add Role</a>
        </div>
      </div>
    </div>
  </div>
<div class="table-responsive mt-3">

  <table id="role-table" class="table table-bordered">
    <thead>
      <th>Role Name</th>
      <th>Description</th>
      <th>Permission</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($roles as $r)
      <tr>
        <td>{{$r->name}}</td>
        <td>{{$r->description}}</td>
        <td>{{$r->permissions}}</td>
        <td>ACT</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){
    $('#role-table').DataTable({})

  })
</script>
@endsection