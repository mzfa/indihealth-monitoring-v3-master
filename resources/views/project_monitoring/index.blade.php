@extends('layouts/master_dashboard')
@section('title','Project Monitoring')
@section('content')



@if(count($linked) > 0)
<div class="callout callout-info">
    Dibawah ini adalah daftar projek yang terhubung dengan anda.
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="row">
            <form action="" method="GET" class="d-flex">
                <input type="text" placeholder="Cari project" value="{{Request::get('search')}}" name="search" class="form-control mr-3">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>
</div>
<hr>
@endif
<div class="row">
  @if(count($linked) == 0)
      <div class="col-12" align='center'>
        <div class="alert alert-warning">
          Tidak ada projek yang terkait dengan anda.
        </div>
      </div>
  @endif
  
    @foreach($linked as $l)
    <div class="col-md-3 col-sm-6 col-xs-12 d-flex align-items-stretch">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">
                        <b>{{Str::limit($l->project->name,34)}}</b>
                    </h3>
                </div>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-12 ">
                        <a
                            href="{{route('project.monitoring.plan',['project_id' => $l->project_id])}}"
                            class="btn btn-primary btn-sm mb-2">Detail Tugas</a>
                        @if(strtolower($l->project->name)!='internal')
                        <div class="progress progress-sm">
                            <div
                                class="progress-bar bg-blue"
                                role="progressbar"
                                aria-volumenow="{{TaskHelper::persenPlanProject($l->project_id)}}"
                                aria-volumemin="0"
                                aria-volumemax="{{TaskHelper::persenPlanProject($l->project_id)}}"
                                style="width: {{TaskHelper::persenPlanProject($l->project_id)}}%"></div>
                        </div>
                        <small>
                            {{number_format(TaskHelper::persenPlanProject($l->project_id),1,',','.')}}% Selesai
                        </small>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <small>Anggota Tim</small><br>
                        {{-- <div style="width:100%; overflow-x:auto;"> --}}
                        @foreach(TaskHelper::showMember($l->project_id,14) as $sm)
                            <img @if(TaskHelper::cekPMProject($sm->user->id,$l->project_id)) style="border:#8bc34a 4px solid" title="Project Manager / Leader ({{$sm->user->name}}) " @else title="{{$sm->user->name}}" @endif   data-src="{{route('showFotoKaryawan',['file' => empty($sm->user->karyawan)?'default.jpg':$sm->user->karyawan->foto])}}" class="lazyload img-circle"   width="30px" height="30px" src=" data:image/gif;base64,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">
                        @endforeach
                      {{-- </div> --}}
                    </div>
                    <div class="col-12 mt-2">

                      <button class="btn btn-success btn-block btn-sm" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" plan-project project-id="{{$l->project->id}}"   project-name="{{$l->project->name}}"><i class="fas mr-2 fa-tasks"></i> Atur Project Plan</button>

                      <div class="row mt-2">
                        <div class="col-6">
                             <a target="_blank" href="{{route('cloud',['project_id' => $l->project_id,'upload' => 1])}}" class="btn btn-outline-primary btn-sm btn-block" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" > Penyimpanan</a>
                        </div>

                        <div class="col-6">
                            <a target="_blank" href="{{route('notulensi',['id' => $l->project_id])}}" class="btn btn-outline-success btn-sm btn-block" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" >Notulensi</a>
                        </div>
                         {{-- @if(strtolower($l->project->name)!='internal')
                        <div class="col-12 mt-2">
                            @if($l->project->status)
                            <a target="_blank" href="{{route('notulensi',['id' => $l->project_id])}}" class="btn btn-primary btn-sm btn-block" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" ><i class="fas fa-check mr-2"></i>Aktifkan Project</a>
                            @else
                             <a target="_blank" href="{{route('notulensi',['id' => $l->project_id])}}" class="btn btn-danger btn-sm btn-block" style="  @if(count($l->project->plans) == 0) opacity: 0; @endif" ><i class="fas fa-times mr-2"></i>Tutup Project</a>
                            @endif

                        </div>
                        @endif --}}
                    </div>
                     
                      
                    </div>

            </div>
            </div>

            @if(count($l->project->plans) == 0)
            <div class="overlay dark">

              <button class="btn btn-warning" plan-project project-id="{{$l->project->id}}"  project-name="{{$l->project->name}}">Atur Project Plan</button>
            </div>
          @endif
            </div>


</div>
@endforeach

</div>
<div class="row">
  {{$linked->links()}}
</div>


<div class="modal fade" id="m-plan-project" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Plan Project <br> <small id="project_name"></small></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body" >
                <div class="row align-items-center">
                   <div class="col-md-6">
                     <label>Nama Plan</label>
                    <input type="text" class="form-control" name="plan" placeholder="cth: Analisis Kebutuhan Pengguna" id="plan">
                    <div class="row">
                      <div class="col-6">
                        <label>Mulai</label>
                        <input type="date" id="start_date" name="mulai" class="form-control " value="" />
                      </div>
                      <div class="col-6">
                        <label>Selesai</label>
                        <input type="date" disabled id="end_date" name="selesai" class="form-control" value="" />
                        <input type="hidden" id="frm_project_id">
                        <input type="hidden" id="project_plan_id">
                      </div>
                    </div>

                    {{-- <label>Deskripsi</label>
                   <textarea class="form-control" name="deskripsi" placeholder="Jelaskan tentang plan ini" id="deskripsi"></textarea> --}}
                   </div>



                   </div>
                   <div class="row align-items-center">
                     <div class="col-md-6">
                         <button type="button" add-plan class="btn btn-success mt-2 btn-block"><i class="fas fa-plus" id="icon-add"></i> Tambahkan</button>
                         <div class="row" style="display:none;" id="edit-tools">
                           <div class="col-md-6 col-sm-12 col-xs-12">
                              <button type="button"  edit-plan class="btn btn-warning mt-2 btn-block"><i class="fas fa-edit" id="icon-edit"></i> Ubah Data</button>
                           </div>
                           <div class="col-md-6 col-sm-12 col-xs-12">
                              <button type="button" batal-plan class="btn btn-outline-secondary mt-2 btn-block"><i class="fas fa-times" id="icon-cancel"></i> Batal</button>
                           </div>

                       </div>
                     </div>
                   </div>

                   <div class="row">

                   <div class="col-md-12">
                     <hr>
                    <h5>Project Plan</h5>

                     <hr>
                    <div class="table-responsive table-responsive-sm">
                    <table  id="plantable" class="table table-striped">
                      <thead>
                        <th>Nama</th>
                        <th>Tgl Mulai - Selesai</th>
                        <th>Aksi</th>
                      </thead>
                    </table>
                </div>
                   </div>
               </div>
       </div>

       <div class="modal-footer">
         {{-- <button type="submit" class="btn btn-outline-primary" submit-button><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button> --}}
         <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
       </div>
     </div>
   </div>
 </div>

 <div class="modal fade" id="detail-plan-project" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Detail Plan Project <br> <small id="dtl_project_name"></small></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
                 <div class="row align-items-center">
                    <div class="col-md-6">
                      <label>Nama Plan</label>
                     <input type="text" class="form-control" name="plan" placeholder="cth: Observasi di Lapangan" id="dtl_plan">
                     <div class="row">
                       <div class="col-6">
                         <label>Mulai</label>
                         <input type="date" id="dtl_start_date" name="mulai" class="form-control " value="" />
                       </div>
                       <div class="col-6">
                         <label>Selesai</label>
                         <input type="date" disabled id="dtl_end_date" name="selesai" class="form-control" value="" />
                         <input type="hidden" id="dtl_frm_project_id">
                         <input type="hidden" id="dtl_project_plan_id">
                       </div>
                     </div>

                     {{-- <label>Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" placeholder="Jelaskan tentang plan ini" id="deskripsi"></textarea> --}}
                    </div>



                    </div>
                    <div class="row align-items-center">
                      <div class="col-md-6">
                          <button type="button" add-plan-detail class="btn btn-success mt-2 btn-block"><i class="fas fa-plus" id="icon-add-dtl"></i> Tambahkan</button>
                          <div class="row" style="display:none;" id="dtl-edit-tools">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                               <button type="button"  edit-plan-detail class="btn btn-warning mt-2 btn-block"><i class="fas fa-edit" id="icon-edit-dtl"></i> Ubah Data</button>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                               <button type="button" batal-plan-detail class="btn btn-outline-secondary mt-2 btn-block"><i class="fas fa-times" id="icon-cancel-dtl"></i> Batal</button>
                            </div>

                        </div>
                      </div>
                    </div>

                    <div class="row">

                    <div class="col-md-12">
                      <hr>
                     <h5>Project Plan</h5>

                      <hr>
                       <div class="table-responsive table-responsive-sm">
                     <table  id="detailPlanTable" class="table table-striped">
                       <thead>
                         <th>Nama</th>
                         <th>Tgl Mulai - Selesai</th>
                         <th>Aksi</th>
                       </thead>
                     </table>
                        </div>
                    </div>
                </div>
        </div>

        <div class="modal-footer">
          {{-- <button type="submit" class="btn btn-outline-primary" submit-button><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button> --}}
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')

  <script>

  function deletePlanAct(id)
  {

    let formData = new FormData();
    formData.append('id',  id);
  axios.post('{{route("project.plan.delete")}}', formData)
          .then(function (response) {
            toastr.success(response.data.project_plan.messages)
            window.table_plan.ajax.reload();
            // $('[edit-plan]').attr('disabled',false);
            //   $("#icon-edit").addClass('fa-edit').removeClass('fa-spinner fa-spin');

        })
        .catch(function (error) {
        // $('[edit-plan]').attr('disabled',false);
        //   $("#icon-edit").addClass('fa-edit').removeClass('fa-spinner fa-spin');
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
  function deletePlan(id)
  {
    Swal.fire({
      title: 'Anda ingin menghapus plan ini?',
      showCancelButton: true,
      confirmButtonText: `Hapus`,
    }).then((result) => {
      if (result.isConfirmed) {
      deletePlanAct(id)
      }
    })
  }
  function deletePlanDetailAct(id)
  {
      $("#icon-plan-dtl-del-"+id).addClass('fa-spinner fa-spin').removeClass('fa-trash');
    let formData = new FormData();
    formData.append('id',  id);
  axios.post('{{route("project.plan.delete.detail")}}', formData)
          .then(function (response) {
            toastr.success(response.data.project_plan.messages)
            window.table_plan_dtl.ajax.reload();
            // $('[edit-plan]').attr('disabled',false);
              $("#icon-plan-dtl-del-"+id).addClass('fa-trash').removeClass('fa-spinner fa-spin');

        })
        .catch(function (error) {
        // $('[trash-plan]').attr('disabled',false);
        $("#icon-plan-dtl-del-"+id).addClass('fa-trash').removeClass('fa-spinner fa-spin');
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
  function deletePlanDetail(id)
  {
    Swal.fire({
      title: 'Anda ingin menghapus detail ini?',
      showCancelButton: true,
      confirmButtonText: `Hapus`,
    }).then((result) => {
      if (result.isConfirmed) {
      deletePlanDetailAct(id)
      }
    })
  }
  $("[edit-plan]").click(function(e){
    $('[edit-plan]').attr('disabled',true);
      $("#icon-edit").addClass('fa-spinner fa-spin').removeClass('fa-edit');
      let formData = new FormData();
      formData.append('start_date', $("#start_date").val());
      formData.append('end_date', $("#end_date").val());
      formData.append('project_id', $("#frm_project_id").val());
      formData.append('name',  $("#plan").val());
      formData.append('id',  $("#project_plan_id").val());
    axios.post('{{route("project.plan.edit")}}', formData)
            .then(function (response) {
              toastr.success(response.data.project_plan.messages)
              window.table_plan.ajax.reload();
              $('[edit-plan]').attr('disabled',false);
                $("#icon-edit").addClass('fa-edit').removeClass('fa-spinner fa-spin');
                resetfrm()
          })
          .catch(function (error) {
          $('[edit-plan]').attr('disabled',false);
            $("#icon-edit").addClass('fa-edit').removeClass('fa-spinner fa-spin');
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
  })
  $("[edit-plan-detail]").click(function(e){
    $('[edit-plan-detail]').attr('disabled',true);
      $("#icon-edit").addClass('fa-spinner fa-spin').removeClass('fa-edit');
      let formData = new FormData();
      formData.append('start_date', $("#dtl_start_date").val());
      formData.append('end_date', $("#dtl_end_date").val());
      formData.append('project_id', $("#dtl_frm_project_id").val());
      formData.append('name',  $("#dtl_plan").val());
      formData.append('id',  $("#dtl_project_plan_id").val());
    axios.post('{{route("project.plan.edit.detail")}}', formData)
            .then(function (response) {
              toastr.success(response.data.project_plan.messages)
              window.table_plan_dtl.ajax.reload();
              $('[edit-plan-detail]').attr('disabled',false);
                $("#icon-edit-dtl").addClass('fa-edit').removeClass('fa-spinner fa-spin');
                resetfrmDtl()
          })
          .catch(function (error) {
          $('[edit-plan-detail]').attr('disabled',false);
            $("#icon-edit-dtl").addClass('fa-edit').removeClass('fa-spinner fa-spin');
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
  })
  function resetfrm(){
    $("#start_date").val('');
    $("#end_date").val('');
    $("#plan").val('');
    $('#end_date').attr('disabled', true);
    $("#start_date").removeClass('animate__animated animate__flash');
    $("#end_date").removeClass('animate__animated animate__flash');
    $("#plan").removeClass('animate__animated animate__flash');
    $("#edit-tools").hide();
    $("[add-plan]").show();
  }
  function resetfrmDtl(){
    $("#dtl_start_date").val('');
    $("#dtl_end_date").val('');
    $("#dtl_plan").val('');
    $('#end_date').attr('disabled', true);
    $("#dtl_start_date").removeClass('animate__animated animate__flash');
    $("#dtl_end_date").removeClass('animate__animated animate__flash');
    $("#dtl_plan").removeClass('animate__animated animate__flash');
    $("#dtl-edit-tools").hide();
    $("[add-plan-detail]").show();
  }
  $('[batal-plan]').click(function(e){

    resetfrm()
  });
  $('[batal-plan-detail]').click(function(e){

    resetfrmDtl()
  });
  $('[add-plan]').click(function(e){
    $("#icon-add").addClass('fa-spinner fa-spin').removeClass('fa-plus');
    $(this).attr('disabled',true);
    let formData = new FormData();
    formData.append('start_date', $("#start_date").val());
    formData.append('end_date', $("#end_date").val());
    formData.append('project_id', $("#frm_project_id").val());
    formData.append('name',  $("#plan").val());
    axios.post('{{route("project.plan.add")}}', formData)
            .then(function (response) {
            toastr.success(response.data.project_plan.messages)
            window.table_plan.ajax.reload();
            $('[add-plan]').attr('disabled',false);
              $("#start_date").val('');
              $("#end_date").val('');
              $("#plan").val('');
              $('#end_date').attr('disabled', true);
              detailPlan(response.data.project_plan.data.id);
            $("#icon-add").addClass('fa-plus').removeClass('fa-spinner fa-spin');
          })
          .catch(function (error) {
          $('[add-plan]').attr('disabled',false);
            $("#icon-add").addClass('fa-plus').removeClass('fa-spinner fa-spin');
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
  });
  $('#dtl_start_date').change(function(e){
        $('#dtl_end_date').attr('disabled', false);
  })

  function detailPlan(id)
  {
    resetfrmDtl();
    $("#detailPlanTable").dataTable().fnClearTable();
    $("#detailPlanTable").dataTable().fnDestroy();
    let formData = new FormData();
    formData.append('id', id);
    axios.post('{{route("project.plandetail.show")}}', formData)
            .then(function (response) {
              $("#dtl_start_date").attr('min',response.data.project_plan.data.start_date);
              $("#dtl_start_date").attr('max',response.data.project_plan.data.end_date);
              $("#dtl_end_date").attr('min',response.data.project_plan.data.start_date);
              $("#dtl_end_date").attr('max',response.data.project_plan.data.end_date);
              $("#dtl_frm_project_id").val(response.data.project_plan.data.project_id);
              $("#dtl_project_plan_id").val(response.data.project_plan.data.id);
            $('#detail-plan-project').modal('show');

            window.table_plan_dtl =  $('#detailPlanTable').DataTable({
                               "order": [[ 0, "asc" ]],
                               processing: true,
                               serverSide: true,
                               autoWidth:false,
                               "language": {
               "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
                 "emptyTable": "Belum ada detail pada plan ini."
             },
                               ajax: {
                                 "url":"{{ route('project.plan.detail.datatables')}}?id="+ id,
                                 'type':'POST',
                                  'data': {
                                       id: $(this).attr('project-id'),
                                       "_token": "{{ csrf_token() }}"
                                       // etc..
                                    },
                                },
                               columns: [{
                                       data: 'name',
                                       name: 'name'
                                   },
                                   {
                                       data: 'timeline',
                                       name: 'timeline'
                                   },{
                                       data: 'aksi',
                                       name: 'aksi'
                                   },
                               ]
                           });



          })
          .catch(function (error) {

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
  function editPlanDetail(id)
  {

      $("#dtl_start_date").removeClass('animate__animated animate__flash');
      $("#dtl_end_date").removeClass('animate__animated animate__flash');
      $("#dtl_plan").removeClass('animate__animated animate__flash');
      let formData = new FormData();
        $("#icon-plan-dtl-edit-"+id).addClass('fa-spinner fa-spin').removeClass('fa-edit');
      formData.append('id',  id);
      axios.post('{{route("project.plan.showDetailPlan")}}', formData)
              .then(function (response) {
                $("#dtl-edit-tools").show();
                $("[add-plan-detail]").hide();
                $("#dtl_start_date").val(response.data.project_plan.data.start_date);
                $("#dtl_end_date").val(response.data.project_plan.data.end_date);
                $("#dtl_plan").val(response.data.project_plan.data.name);
                $("#dtl_project_plan_id").val(response.data.project_plan.data.id);
                $('#dtl_end_date').attr('disabled', false);
                // animate();
              $("#icon-plan-dtl-edit-"+id).addClass('fa-edit').removeClass('fa-spinner fa-spin');
            })
            .catch(function (error) {
            $('[add-plan]').attr('disabled',false);
              $("#icon-plan-dtl-edit-"+id).addClass('fa-edit').removeClass('fa-spinner fa-spin');
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
  $('[plan-project]').click(function(e){
    $("#plantable").dataTable().fnClearTable();
    $("#plantable").dataTable().fnDestroy();
      $('#m-plan-project').modal('show');
      $('#project_name').html($(this).attr('project-name'))
      $('#frm_project_id').val($(this).attr('project-id'))
      window.table_plan =  $('#plantable').DataTable({
                         "order": [[ 0, "asc" ]],
                         processing: true,
                         serverSide: true,
                         autoWidth:false,
                         "language": {
         "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
           "emptyTable": "Belum ada plan di projek ini."
       },
                         ajax: {
                           "url":"{{ route('project.plan.datatables')}}?id="+ $(this).attr('project-id'),
                           'type':'POST',
                            'data': {
                                 id: $(this).attr('project-id'),
                                 "_token": "{{ csrf_token() }}"
                                 // etc..
                              },
                          },
                         columns: [{
                                 data: 'name',
                                 name: 'name'
                             },
                             {
                                 data: 'timeline',
                                 name: 'timeline'
                             },{
                                 data: 'aksi',
                                 name: 'aksi'
                             },
                         ]
                     });

  })
  function animate()
  {
    $("#start_date").addClass('animate__animated animate__flash');
    $("#end_date").addClass('animate__animated animate__flash');
    $("#plan").addClass('animate__animated animate__flash');

  }
function editPlan(id){

  $("#start_date").removeClass('animate__animated animate__flash');
  $("#end_date").removeClass('animate__animated animate__flash');
  $("#plan").removeClass('animate__animated animate__flash');
  let formData = new FormData();

  formData.append('id',  id);
  axios.post('{{route("project.plan.show")}}', formData)
          .then(function (response) {
            $("#edit-tools").show();
            $("[add-plan]").hide();
            $("#start_date").val(response.data.project_plan.data.start_date);
            $("#end_date").val(response.data.project_plan.data.end_date);
            $("#plan").val(response.data.project_plan.data.name);
            $("#project_plan_id").val(response.data.project_plan.data.id);
            $('#end_date').attr('disabled', false);
            animate();
          $("#icon-add").addClass('fa-plus').removeClass('fa-spinner fa-spin');
        })
        .catch(function (error) {
        $('[add-plan]').attr('disabled',false);
          $("#icon-add").addClass('fa-plus').removeClass('fa-spinner fa-spin');
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
  $('#start_date').change(function(e){
    if(new Date($(this).val()) > new Date($("#end_date").val()))
    {
        $('#end_date').val("");
    }

    $('#end_date').attr('min', $(this).val());
    $('#end_date').attr('disabled', false);
  })
  $(document).on('show.bs.modal', '.modal', function() {
  const zIndex = 1040 + 10 * $('.modal:visible').length;
  $(this).css('z-index', zIndex);
  setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
});
$('.modal').on("hidden.bs.modal", function (e) {
    if ($('.modal:visible').length) {
        $('body').addClass('modal-open');
    }
});


$('[add-plan-detail]').click(function(e){
  $("#icon-add-dtl").addClass('fa-spinner fa-spin').removeClass('fa-plus');
  $(this).attr('disabled',true);
  let formData = new FormData();
  formData.append('start_date', $("#dtl_start_date").val());
  formData.append('end_date', $("#dtl_end_date").val());
  formData.append('project_id', $("#dtl_frm_project_id").val());
  formData.append('project_plan_id', $("#dtl_project_plan_id").val());
  formData.append('name',  $("#dtl_plan").val());
  axios.post('{{route("project.plan.add.detail")}}', formData)
          .then(function (response) {
          toastr.success(response.data.project_plan.messages)
          window.table_plan_dtl.ajax.reload();
          $('[add-plan-detail]').attr('disabled',false);
            $("#dtl_start_date").val('');
            $("#dtl_end_date").val('');
            $("#dtl_plan").val('');
            $('#dtl_end_date').attr('disabled', true);
          $("#icon-add-dtl").addClass('fa-plus').removeClass('fa-spinner fa-spin');
        })
        .catch(function (error) {
        $('[add-plan-detail]').attr('disabled',false);
          $("#icon-add-dtl").addClass('fa-plus').removeClass('fa-spinner fa-spin');
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
});
  </script>
@endsection
