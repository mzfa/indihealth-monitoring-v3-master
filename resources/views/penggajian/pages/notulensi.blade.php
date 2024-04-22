@extends('layouts/master_dashboard_guest')
@section('title','Kelola Notulensi Project')
@section('subtitle',$project->name." (".$project->client.")")
@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12">
    <form action="" method="get">
      <div class="row">
        <div class="col-3">
          <input type="hidden" value="{{Request::get('id')}}" name="id">
          <input type="text" value="{{Request::get('search')}}" placeholder="Masukan kata kunci..." name="search" class="form-control">
        </div>
        <div class="col-3">
          <input type="date" value="{{Request::get('date')}}" name="date" class="form-control">
        </div>
      <div class="col-3">
           <button type="submit" class="btn btn-primary" ><i  s class="fas fa-search"></i> Cari</button>
        </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="detail-notulensi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Lihat Notulensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
           <div class="row">
            <div class="col-md-12 col-sm-12">
                <label>Judul Agenda</label>
               <div id="detail_judul_agenda"></div>
            </div> 
            <div class="col-md-6 col-sm-12">
                <label>Waktu Meeting</label>
                <div id="detail_waktu_meeting"></div>
                <small id="diff_date"></small>
            </div> 
            <div class="col-md-12 col-sm-12">
                <label>Roadmap</label>
               <div id="detail_roadmap" class="border border-inf"></div>
            </div>
            <div class="col-md-12 col-sm-12">
                <label>Notulensi</label>
                <div id="detail_notulensi" class="border border-inf"></div>
            </div>
            </div>
           </div>
         
          
        </div>
        </div>
      </div>
<hr>

<div id="scrolling" class="scrolling mt-3">
<div class="row dataNotulen" id="dataNotulen">
  @foreach($notes as $n)
  <div class="col-md-3 col-sm-12" id="notulensi-card-{{$n->id}}">
    <div  id="notulensi-{{$n->id}}" class="card card-outline card-success">
      <div class="card-header">

         <a href="#" onclick="showNotulensi({{$n->id}})">


        <h3 class="card-title"><b>{{$n->judul_agenda}}</b> 
          <br><small>Tanggal : {{$n->waktu_meeting}}</small>
          <br><small>Dibuat oleh : {{$n->user->karyawan->nama_lengkap}}</small></h3>
          </a>
      </div>
      <div class="card-body">
        <button type="button" onclick="showNotulensi({{$n->project_id}})" class="btn btn-outline-warning btn-block">Lihat Detail</button>
       

      </div>
    </div>
  </div>
  @endforeach
</div>
  <div class="col-12" align="center">
        {{ $notes->appends(request()->query())->links() }}
  </div>
  <div class="col-12" align="center">
   @if(count($notes) <= 0)
  <div class="col-md-12">
    <div class="alert alert-light">Tidak ada data yang dapat ditampilkan.</div>
  </div>
  @endif
  </div>
</div>
  {{-- <div class="col-12 page-load-status" style="display: none"   align="center">
        <i class="fas fa-spin fa-2x fa-spinner"></i>
  </div>
  <p class="infinite-scroll-last">End of content</p>
  <p class="infinite-scroll-error">No more pages to load</p> --}}
@endsection

@section('javascript')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
<script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>
<script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>

<script>
  $('ul.pagination').hide();
  function pageinit()
  {
    $('.scrolling').infiniteScroll({
        // options
        path: '.pagination li.active + li a',
        append: '.dataNotulen',
        history: false,
        status: '.page-load-status',
      });
        
  }
  function showNotulensi(id)
  {
        let formData = new FormData();
        formData.append('id', id);
        $("#notulensi-"+id).loading({theme: 'dark',message: 'Mohon Tunggu'});
        axios.post('{{route("notulensi.guest.show")}}', formData)
                .then(function (response) {
                $('#detail-notulensi').modal('show');
                $("#detail_judul_agenda").html(response.data.notulensi.data.judul_agenda)
                $("#detail_waktu_meeting").html(response.data.notulensi.data.waktu_meeting)
                $("#detail_roadmap").html(response.data.notulensi.roadmap_format)
                $("#detail_notulensi").html(response.data.notulensi.notulensi_format)
              
                
                $("#notulensi-"+id).loading('stop');
              })
              .catch(function (error) {
                $("#notulensi-"+id).loading('stop');
               
               if(error.response.status == 422){
                         
                    $.each(error.response.data.errors, (i, j) => {
                     toastr.warning(j)
                  })
               } else{
                  
                 Swal.fire({
                    title: 'Error!',
                    text: "Internal Server Error",
                    icon: 'warning',
                    confirmButtonText: 'OK'
                  })

               }
              });        
  }
 
    $(function() {
        pageinit();
    });
   $('.time').clockpicker({donetext: 'Selesai',autoclose:true});
   

</script>
@endsection
 