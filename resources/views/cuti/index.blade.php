@extends('layouts/master_dashboard')
@section('title',' Cuti Saya')
@section('content')
<div class="alert alert-warning">Fitur ini masih Beta test</div>
<div class="row">
    <div class="col-md-6">
       <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cuti Anda</span>
                           
                            <span class="info-box-number">
                            Terpakai {{12-UserHelper::sisaCuti(auth()->user()->karyawan_id) }} dari 12
                            </span>
                        </div>

                    </div>
                
            </div>
        </div>
    </div>
</div>
<div class="row mr-">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                  <a href="{{url("cuti/request")}}" class="btn btn-block btn-primary">
                    <i class="fas fa-envelope mr-2"></i>
                    Request Cuti
                </a>
            </div>
            <div class="col-md-6">

                @Permission(['superadmin','hrd'])
                    <a href="{{url("cuti/create")}}" class="btn btn-block btn-success">
                        <i class="fas fa-plus mr-2"></i>
                        Create Cuti
                    </a> 
                @endPermission
            </div>
        </div>
    </div>
        @Permission(['superadmin','hrd'])
    <div class="col-md-6" align="right">
                   
                    <a  data-toggle="modal" data-target="#download" href="#" class="btn btn-outline-success">
                        <i class="fas fa-download mr-2"></i>
                        Download Laporan Cuti
                    </a>
    </div>
                @endPermission
</div>
<hr>
  <!-- Modal -->
  <form action="{{route('cuti.export')}}" method="POST" enctype="multipart/form-data">
<div class="modal fade" id="download" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export Cuti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <label>Pilih Tahun</label>
        <select class="form-control" name="year">
             @for($i = date('Y') ; $i >= 2020; $i--)
                <option value="{{$i}}">{{$i}}</option>";
             @endfor
   
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Download Laporan</button>
      </div>
    </div>
  </div>
</div>
</form>

<div class="table-responsive">
{{$dataTable->table()}}
</div>
{{$dataTable->scripts()}}

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@stack('scripts')
@endsection