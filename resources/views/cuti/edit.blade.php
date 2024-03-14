@extends('layouts/master_dashboard')
@section('title','Ubah Cuti '.$data->karyawan->nama_lengkap)
@section('content')
<style>
    .invicible {
        display: none;
    }
</style>
<form action="{{route("cuti.update")}}" method="POST">
    @csrf
    <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="start_date">Mulai Cuti</label>
                    <input type="date" class="form-control" min="{{$data->start}}" value="{{$data->start}}" id="start_date" name="start_date">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="start_date">Selesai Cuti</label>
                    <input type="date" class="form-control" min="{{$data->start}}" value="{{$data->end}}" id="end_date" name="end_date">
                </div>
            </div>
    </div>
    
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Alasan</label>
        <textarea required class="form-control" id="exampleFormControlTextarea1" rows="3" name="reason_cuti" placeholder="Alasan Cuti">{{$data->reason_cuti}}</textarea>
    </div>
    <input type="hidden" name="id" id="" class="invisible" value="{{$data->id}}"><br>
    <input type="hidden" name="karyawan_id" id="" class="invisible" value="{{$data->karyawan_id}}"><br>
    <button type="submit" class="btn btn-success">
        <i class="fas fa-paper-plane mr-2"></i>
       Update
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
</script>
@endsection