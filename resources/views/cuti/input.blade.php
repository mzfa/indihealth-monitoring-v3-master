@extends('layouts/master_dashboard')
@section('title','Request Cuti')
@section('content')
<style>
    .invicible {
        display: none;
    }
</style>
{{-- @if(!Session::has('message_fail'))
<div class="alert alert-warning" align="center">{{$message_fail}}</div>
@endif --}}
<form action="{{route("cuti.save")}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
             <div class="form-group">
                   
                    <label>Pilih karyawan</label>
                <select 
                        name="karyawan_id" required 
                        id="select-karyawan"
                        class="select-karyawan form-control">
                         <option>Pilih</option>
                        </select>
                </div>
        </div>
    </div>
    <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="start_date">Mulai Cuti</label>
                    <input type="date" class="form-control"  id="start_date" name="start_date">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="start_date">Selesai Cuti</label>
                    <input type="date" class="form-control"  id="end_date" name="end_date">
                </div>
            </div>
    </div>
    
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Alasan</label>
        <textarea required class="form-control" id="exampleFormControlTextarea1" rows="3" name="reason_cuti" placeholder="Alasan Cuti"></textarea>
    </div>
    <div class="row">
        <div class="col-md-6">
             <div class="form-group">
                   
                    <label>Status</label>
                <select 
                        name="status" required 
                        id="status"
                        class="form-control">
                         <option>Pilih</option>
                         <option value="1">Setuju</option>
                         <option value="2">Ditolak</option>
                        </select>
                </div>
        </div>
    </div>


    <button type="submit" class="btn btn-success">
        <i class="fas fa-paper-plane mr-2"></i>
        Send request cuti
    </button>
</form>

{{-- <script src="{{ mix('js/app.js') }}"></script> --}}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@stack('scripts')
@endsection
@section('javascript')
<script>
    $('#start_date').change(function(){
        $('#end_date').attr('min', $(this).val())
    })

     $('.select-karyawan').select2({
            dropdownAutoWidth: true,
            // dropdownParent: $("#tambah-absensi"),
            width: '100%',
            ajax: {
                delay: 250,
                url: '{{route("karyawan.getSelectKaryawan")}}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {results: data};
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full
                // code of this example
            }
        });
</script>
@endsection