@extends('layouts/master_dashboard')
@section('title','Kelola Notulensi Project')
@section('subtitle',$project->name." (".$project->client.")")
@section('content')
<div class="row">
  <div class="col-md-3 col-sm-12">
    <a href="#" data-toggle="modal" data-target="#notulensi-baru" class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i>Tambah Notulensi Baru</a>
  </div>
  @Permission(['hrd','superadmin','owner'])
  <div class="col-md-3 col-sm-12">
    <a href="#" data-toggle="modal" data-target="#notulensi-export" class="btn btn-outline-success btn-block"><i class="fas fa-file-export mr-2"></i>Export Notulensi</a>
  </div>
  @endPermission
  
</div>
<hr>

<form action="" method="get">
<div class="row">
  <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-3">
          <input type="hidden" value="{{Request::get('id')}}" name="id">
          <input type="text" placeholder="Masukan kata kunci..." value="{{Request::get('search')}}" name="search" class="form-control">
        </div>
        <div class="col-3">
          <input type="date" value="{{Request::get('date')}}" name="date" class="form-control">
        </div>
      <div class="col-3">
           <button type="submit" class="btn btn-primary" ><i  s class="fas fa-search"></i> Cari</button>
        </div>
    </div>
    <a href="#" type="menu" open-adv class="mt-2 btn btn-outline-success btn-sm">Pencarian Lanjutan</a>
  </div>
  <div class="col-12 mt-2" id="adv-search" style="display:none;">
      <div class="row">
        <div class="col-3">
          <select class="form-control" id="bulan" disabled name="bulan">
          
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>
        <div class="col-3">
          
          <select class="form-control" id="tahun"  disabled name="tahun">
          @foreach(range(date('Y'), 2015) as $year)
            <option value="{{$year}}">{{$year}}</option>
          @endforeach
          </select>
        </div>
      </div>
  </div>
</div>
</form>

<!-- Modal -->
    <form id="form-notulensi-create">
    <div class="modal fade" id="notulensi-baru" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Buat Notulensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
           <div class="row">
            <div class="col-md-12 col-sm-12">
                @csrf
                <label>Judul Agenda</label>
                <input type="text" id="judul_agenda" name="judul_agenda" placeholder="Contoh: Meeting teknis project xxx ke-2" required="" class="form-control">
            </div> 
            <div class="col-md-6 col-sm-12">
                <label>Waktu Meeting</label>
                <div class="row">
                  <div class="col-md-6">
                    <input type="date" id="tanggal" name="tanggal" prequired="" class="form-control">
                  </div> 
                  <div class="col-md-3">
                    <input type="text" id="jam" name="jam" placeholder="--:--" required="" class="time form-control">
                  </div>
                </div>
            </div> 
            <div class="col-md-12 col-sm-12">
                <label>Roadmap</label>
               <textarea class="form-control" id="roadmap" name="roadmap" ></textarea>
            </div>
            <div class="col-md-12 col-sm-12">
                <label>Notulensi</label>
               <textarea class="form-control" id="notulensi" name="notulensi" ></textarea>
            </div>
            </div>
           </div>
         
          <div class="modal-footer">
            <button type="submit" submit-button class="btn btn-primary" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tambah</button>
          </div>
        </div>
        </div>
      </div>
    </form>
<!-- Modal -->
    <form method="POST" action="{{route('notulensi.export')}}" id="form-export-notulensi">
    <div class="modal fade" id="notulensi-export" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered modal-sm6" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Export Notulensi ke PDF</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
           <div class="row">
              <div class="col-md-12 col-sm-12">
                @csrf
                <input type="hidden" value="{{$project->id}}" name="project_id">
                <label>Pilih Bulan dan Tahun</label>
                 <div class="row">
                    <div class="col-6">
                      <select class="form-control" id="bulan-export"  name="bulan">
                      
                        <option value="01" {{Request::get('bulan') == '01' ? "selected":null}}>Januari</option>
                        <option value="02" {{Request::get('bulan') == '02' ? "selected":null}}>Februari</option>
                        <option value="03" {{Request::get('bulan') == '03' ? "selected":null}}>Maret</option>
                        <option value="04" {{Request::get('bulan') == '04' ? "selected":null}}>April</option>
                        <option value="05" {{Request::get('bulan') == '05' ? "selected":null}}>Mei</option>
                        <option value="06" {{Request::get('bulan') == '06' ? "selected":null}}>Juni</option>
                        <option value="07" {{Request::get('bulan') == '07' ? "selected":null}}>Juli</option>
                        <option value="08" {{Request::get('bulan') == '08' ? "selected":null}}>Agustus</option>
                        <option value="09" {{Request::get('bulan') == '09' ? "selected":null}}>September</option>
                        <option value="10" {{Request::get('bulan') == '10' ? "selected":null}}>Oktober</option>
                        <option value="11" {{Request::get('bulan') == '11' ? "selected":null}}>November</option>
                        <option value="12" {{Request::get('bulan') == '12' ? "selected":null}}>Desember</option>
                      </select>
                    </div>
                    <div class="col-6">
                      
                      <select class="form-control" id="tahun-export" name="tahun">
                      @foreach(range(date('Y'), 2015) as $year)
                        <option value="{{$year}}" {{Request::get('tahun') == $year ? "selected":null}}>{{$year}}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
              </div> 
            </div>

           </div>
         
          <div class="modal-footer">
            <button type="submit" submit-button class="btn btn-success" >Export</button>
          </div>
        </div>
        </div>
      </div>
    </form>

    <!-- Modal -->
    <form id="form-notulensi-edit">
    <div class="modal fade" id="notulensi-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Buat Notulensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
           <div class="row">
            <div class="col-md-12 col-sm-12">
                @csrf
                <input type="hidden" name="id" value="" id="edit_id_notulensi">
                <label>Judul Agenda</label>
                <input type="text" id="edit_judul_agenda" name="judul_agenda" placeholder="Contoh: Meeting teknis project xxx ke-2" required="" class="form-control">
            </div> 
            <div class="col-md-6 col-sm-12">
                <label>Waktu Meeting</label>
                <div class="row">
                  <div class="col-md-6">
                    <input type="date" id="edit_tanggal" name="tanggal" prequired="" class="form-control">
                  </div> 
                  <div class="col-md-3">
                    <input type="text" id="edit_jam" name="jam" placeholder="--:--" required="" class="time form-control">
                  </div>
                </div>
            </div> 
            <div class="col-md-12 col-sm-12">
                <label>Roadmap</label>
               <textarea class="form-control" id="edit_roadmap" name="edit_roadmap" ></textarea>
            </div>
            <div class="col-md-12 col-sm-12">
                <label>Notulensi</label>
               <textarea class="form-control" id="edit_notulensi" name="edit_notulensi" ></textarea>
            </div>
            </div>
           </div>
         
          <div class="modal-footer">
            <button type="submit" submit-button class="btn btn-primary" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
          </div>
        </div>
        </div>
      </div>
    </form>

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
          <div class="modal-body" id="copy">
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
           <div class="modal-footer">
            <button class="btn btn-primary" onclick="CopyToClipboard('copy')"><i class="fas fa-copy mr-2"></i>Copy</button>
           </div>
         
          
        </div>
        </div>
      </div>
<hr>

<div id="scrolling" class="scrolling mt-3">
<div class="row dataNotulen" id="dataNotulen">
  <?php $c= 0; ?>
  @foreach($notes as $n)
  <?php $c++; ?>
  <div class="col-md-3 col-sm-12" id="notulensi-card-{{$n->id}}">
    
    <div  id="notulensi-{{$n->id}}" class="card card-outline card-success">
      @if($c==1)
      <div class="ribbon-wrapper">
                        <div class="ribbon bg-danger">
                          Terbaru
                        </div>
                      </div>
      @endif
      <div class="card-header">

         <a href="#" onclick="showNotulensi({{$n->id}})">


        <h3 class="card-title"><b>{{$n->judul_agenda}}</b> 
          <br><small>Tanggal : {{$n->waktu_meeting}}</small>
          <br><small>Dibuat oleh : {{$n->user->karyawan->nama_lengkap}}</small></h3>
          </a>
      </div>
      <div class="card-body">
        @if($n->created_by == auth()->user()->id)
        <button type="button"  onclick="editNotulensi({{$n->id}})" class="btn btn-outline-warning btn-block">Ubah Data</button>
        <button type="button" onclick="hapusNotulensi({{$n->id}})" class="btn btn-outline-danger btn-block">Hapus</button>
        @else
        <button type="button" disabled=""   class="btn btn-outline-secondary btn-block">Ubah Data</button>
        <button type="button"  disabled="" class="btn btn-outline-secondary btn-block">Hapus</button>
        @endif

      </div>
    </div>
  </div>
  @endforeach
</div>
  <div class="col-12" align="center">
        {{ $notes->appends(request()->query())->links() }}
  </div>
   @if(count($notes) <= 0)
  <div class="col-md-12">
    <div class="alert alert-light" align="center">Tidak ada data yang dapat ditampilkan.</div>
  </div>
  @endif
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
  function CopyToClipboard(containerid) {
  if (document.selection) {
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy");
  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(containerid));
    window.getSelection().addRange(range);
    document.execCommand("copy");
     Swal.fire({
                    title: 'Success!',
                    text: "Notulensi berhasil disalin.",
                    icon: 'success',
                    confirmButtonText: 'OK'
                  })
  }
}
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
        axios.post('{{route("notulensi.show")}}', formData)
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
  function editNotulensi(id)
  {
        let formData = new FormData();
        formData.append('id', id);
        $("#notulensi-"+id).loading({theme: 'dark',message: 'Mohon Tunggu'});
        axios.post('{{route("notulensi.show")}}', formData)
                .then(function (response) {
                // console.log(response.data.notulensi.data.roadmap)
                $("#edit_roadmap").val(response.data.notulensi.data.roadmap)
                $("#edit_notulensi").val(response.data.notulensi.data.notulensi)
                $('#notulensi-edit').modal('show');
                $("#edit_id_notulensi").val(response.data.notulensi.data.id)
                $("#edit_judul_agenda").val(response.data.notulensi.data.judul_agenda)
                $("#edit_tanggal").val(response.data.notulensi.date)
                $("#edit_jam").val(response.data.notulensi.time)
              
                
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
  function hapusNotulensi(id)
      {
        Swal.fire({
          title: 'Anda ingin menghapus notulensi ini?',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: `Hapus`,
        }).then((result) => {
          if (result.isConfirmed) {
            deleteAct(id);
          }
        })
      }
  function deleteAct(id)
  {
        let formData = new FormData();
        formData.append('id', id);
        $("#notulensi-"+id).loading({theme: 'dark',message: 'Mohon Tunggu'});
        axios.post('{{route("notulensi.delete")}}', formData)
                .then(function (response) {
               
                
                $("#notulensi-"+id).loading('stop');
                $("#notulensi-card-"+id).fadeOut('fast');
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
   $("#form-notulensi-create").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-notulensi-create')[0];
        let formData = new FormData(form);
        formData.append('project_id', {{$id_projek}});
        axios.post('{{route("notulensi.save")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#judul_agenda").val("")
                $("#tanggal").val("")
                $("#jam").val("")
                $("#roadmap").val("")
                $("#notulensi").val("")
                $('#notulensi-baru').modal('hide')
               // $("#dataNotulen").load(location.href + " #dataNotulen");
               // pageinit()
               location.reload();

              })
              .catch(function (error) {
               $("[spinner]").hide();
               $("[submit-button]").prop( "disabled", false );
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
             })
           })
     $("#form-notulensi-edit").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-notulensi-edit')[0];
        let formData = new FormData(form);
        formData.append('project_id', {{$id_projek}});
        formData.append('roadmap',$('#edit_roadmap').val());
        formData.append('notulensi', $('#edit_notulensi').val());
        axios.post('{{route("notulensi.update")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#edit_judul_agenda").val("")
                $("#edit_tanggal").val("")
                $("#edit_jam").val("")
                $("#edit_roadmap").val("")
                $("#edit_notulensi").val("")
                $('#notulensi-edit').modal('hide')


                 Swal.fire({
                    title: 'Sukses!',
                    text: "Berhasil mengubah data",
                    icon: 'success',
                    confirmButtonText: 'OK'
                  })
                 location.reload();
               $("#dataNotulen").load(location.href + " #dataNotulen");
               pageinit()

              })
              .catch(function (error) {
               $("[spinner]").hide();
               $("[submit-button]").prop( "disabled", false );
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
             })
           })

     $('[open-adv]').click(function(e){
       if($(this).prop('position'))
       {
         $(this).prop('position',false);
         $("#tahun").prop('disabled',true);
         $("#bulan").prop('disabled',true);
         $("#adv-search").slideUp();
        } else{
          $(this).prop('position',true);
          $("#tahun").prop('disabled',false);
          $("#bulan").prop('disabled',false);
          $("#adv-search").slideDown();
        }
     })
    // CKEDITOR.replace( 'roadmap' );
    // CKEDITOR.replace( 'notulensi' );
    // CKEDITOR.replace( 'edit_roadmap' );
    // CKEDITOR.replace( 'edit_notulensi' );

</script>
@endsection
 