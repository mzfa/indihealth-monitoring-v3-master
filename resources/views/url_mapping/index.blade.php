@extends('layouts/master_dashboard')
@section('title','Kelola URL Permission')
@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <a href="{{route('config.url.mapping.create')}}" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add URL Permission</a>
      </div>
    </div>
  </div>
</div>
<div class="table-responsive mt-3">
  <table id="url-table" class="table table-bordered">
    <thead>
      <th>Name Page</th>
      <th>Icon</th>
      <th>URL</th>
      <th>Order Menus</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach($mapping as $r)
      <tr>
        <td>{{$r->name}}</td>
        <td>{{$r->icon}}</td>
        <td>{{$r->url}}</td>
        <td>{{$r->order_menus}}</td>
        <td>
          <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{route('config.url.mapping.edit',['id' => $r->id])}}" title="Ubah data" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="#{{md5("url-".$r->id)}}" onclick="deleteProject('{{route('config.url.mapping.delete',['id' => $r->id])}}',{{$r->id}})" title="hapus" data-toggle="modal"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
$('#url-table').DataTable({})

})
function deleteProject(url,id)
    {
      Swal.fire({
          title: '',
          html: 'Apakah anda yakin akan menghapus ini?',
          // showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'Hapus',
          denyButtonText: `Cancel`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            window.location = url;
          }
        })
      }
</script>
@endsection