@extends('layouts/master_dashboard')
@section('title','Update Sistem')
@section('content')
<div class="row">
  <div class="col-md-6 col-xl-6 col-sm-12 col-12">
    <div class="row">
      <div class="col-3">
          <button class="btn btn-primary btn-block" type="button"><i class="fas fa-sync" id="update-system-icon"></i> Check Update</button>

      </div>
      <div class="col-3">
        <span class="badge badge-warning">Versi Baru Tersedia, v3.0.2</span >

      </div>
      <div class="col-12">
          <textarea readonly id="logs" class="form-control"></textarea>

      </div>
    </div>
  </div>
</div>
@endsection
