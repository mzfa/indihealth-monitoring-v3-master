@extends('layouts/master_dashboard')
@section('title','Kelola Tugas')
@section('content')
<style type="text/css">

</style>
@if(empty(auth()->user()->karyawan_id))
 <div class="row">
  <div class="col-md-12">
    <div class="alert alert-warning" align="center"><i class="fas fa-exclamation-triangle"></i> Tidak dapat mengelola task, karena akun ini belum terkait dengan karyawan.</div>
  </div>
 </div>
@else
<div class="row">
  <div class="col-md-6">
    <div class="row">
        {{-- <div class="col-md-6 col-sm-12">
            <button class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#tugas-baru"><i class="fas fa-plus"></i> Tambah Tugas Baru</button>
        </div> --}}

        <!-- Modal -->
    {{-- <form id="form-task">
    <div class="modal fade" id="tugas-baru" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tugas Baru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
           <div class="row">
            <div class="col-md-6 col-sm-12">
                @csrf
                <label>Nama Tugas</label>
                <input type="text" id="task_name_new" name="task_name" placeholder="Contoh: Membuat modul absensi" required="" class="form-control">

            </div>
            <input type="hidden" value="{{Request::route('project_id')}}" name="project_id">
            <div class="col-md-6 col-sm-12">
                <label>Projek</label><br>
               <select name="project_id" id="create-project-select" class="select-project form-control">

            </select>
            </div>
            <div class="col-md-6 col-sm-12">
                <label>Pilih Kategori</label><br>
               <select name="project_plan" disabled id="create-plan-select" class="select-plan form-control">

            </select>
            </div>
            <div class="col-md-6 col-sm-12">
                <label>Tanggal</label> <i style="display:none" class="loader fas fa-spin fa-spinner"></i>
                <input type="date" name="tanggal" disabled  required="" class="tanggal form-control">
            </div>
            <div class="col-md-6 col-sm-12">
                <label>Deadline</label> <i style="display:none" class="loader fas fa-spin fa-spinner"></i>
                <input type="date" name="deadline"  disabled  required="" class="deadline form-control">
            </div>
            <div class="col-md-6 col-sm-12">
                <label>Progress</label>
                <input id="process_new" type="text"  name="process" onchange="changeStatus('#hidden-done-new',this.value)" value="0">
            </div>
            <div class="col-md-6 col-sm-12" id="hidden-done-new" style="display: none;">
                <div  >
                <hr>
                <label>Kesulitan</label>
                <input id="kesulitan" type="text" class="form-control selesai-check"  name="kesulitan"  >
                <label>Solusinya</label>
                <input id="solusi" type="text" class="form-control selesai-check"  name="solusi"  >
                <span class="badge badge-warning">Jika sudah ditandai selesai maka tugas ini tidak dapat diubah</span>
                 <div class="custom-control custom-checkbox">
                              <input id="selesai" class="custom-control-input selesai-check" type="checkbox"  name="selesai">
                              <label for="selesai" class="custom-control-label">Tandai Sudah Selesai</label>
                            </div>
                </div>
            </div>
           </div>
          </div>

          <div class="modal-footer">
            <button type="submit" submit-button class="btn btn-primary" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tambah</button>
          </div>
        </div>
      </div>
    </div>
    </form> --}}

    <!-- Modal -->
    <form id="form-task-edit">
    <div class="modal fade" id="edit-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Lapor Tugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" >
            <b>Tugas Saya:</b><p id="my_task"></p>
           <div class="row">
            {{-- <div class="col-md-6 col-sm-12">
                @csrf

                <label>Nama Tugas</label>
                <input type="text" name="task_name" id="task_name"  placeholder="Contoh: Membuat modul absensi" required="" class="form-control">
            </div>
             <div class="col-md-6 col-sm-12">
                <label>Projek</label><br>
               <select name="project_id" id="edit-select-project" class="select-project form-control">

            </select>
            </div>
            <div class="col-md-6 col-sm-12">
                <label>Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"  required="" class="form-control">
            </div>
            <div class="col-md-6 col-sm-12">
                <label>Deadline</label>
                <input type="date" name="deadline" id="deadline"  required="" class="form-control">
            </div> --}}
            <div class="col-md-6 col-sm-12">
                @csrf
                  <input type="hidden" name="id" value="" id="task-id">
                <label>Progress</label>
                <input id="process_edit"    type="text" name="process" value="0">
           </div>
            <div class="col-md-6 col-sm-12">

                <label>Tanggal Laporan</label>
                <input id="report_date"    type="date" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}"  class="form-control" name="report_date" >
           </div>
            <div class="col-md-12 col-sm-12">
              <hr>
              <div id="hidden-done-edit" class="row" style="">
              <div class="col-md-6 col-sm-12">
               <label>Kesulitan</label>
               <input id="kesulitan" placeholder="Tuliskan Kesulitannya apa" type="text" class="form-control selesai-check"  name="kesulitan"  >
             </div>
               <div class="col-md-6 col-sm-12">
               <label>Solusinya</label>
               <input id="solusi" placeholder="Tuliskan Solusinya apa" type="text" class="form-control selesai-check"  name="solusi"  >
               {{-- <span class="badge badge-warning">Jika sudah ditandai selesai maka tugas ini tidak dapat diubah</span> --}}
                {{-- <div class="custom-control custom-checkbox">
                             <input id="selesai_edit" disabled="true" class="custom-control-input selesai-check" type="checkbox"  name="selesai">
                             <label for="selesai_edit" class="custom-control-label">Tandai Sudah Selesai</label>
                           </div> --}}
               </div>
               </div>

           </div>
                 <div class="col-md-12 col-sm-12">
                   <label>Detail Laporan</label>
                   <textarea class="form-control" id="detail" name="detail" required min="10" placeholder="Rincikan Laporan apa saja yang sudah dikerjakan pada tugas ini"></textarea>
            </div>
           </div>
          </div>

          <div class="modal-footer">
            <button type="submit" submit-button class="btn btn-primary" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Laporkan Tugas</button>
          </div>
        </div>
  </div>
</div>
</form>
    <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-md-6">
              <button class="btn btn-success btn-block"  type="button"  data-toggle="modal" data-target="#pilih-tanggal" ><i class="fas fa-calendar"></i> Pilih Tanggal</button>
        </div> 
        <div class="col-md-6">
                    <button class="btn btn-primary btn-block"  type="button"  data-toggle="modal" data-target="#add-tugas" ><i class="fas fa-plus"></i>Tambah Tugas</button>
        <form id="form-task">
       <div class="modal fade" id="add-tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg " role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tugas </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body" >
              <div class="row">
                   @csrf

               <div class="col-md-12 col-sm-12">
                 <div class="row">
                  <div class="col-md-6 col-sm-12">
                      @csrf
                      <label>Nama Tugas</label>
                      <input type="text" id="task_name_new" name="task_name" placeholder="Contoh: Membuat modul absensi" required="" class="form-control">

                      <input type="hidden" name="project_id" id="project_id" value="{{$project_id}}">
                      {{-- <input type="hidden" name="project_plan" id="project_plan" value=""> --}}
                  </div>
                  {{-- <div class="col-md-6 col-sm-12">
                      <label>Projek</label><br>
                     <select name="project_id" id="create-project-select" class="select-project form-control">

                  </select> --}}
                  {{-- </div> --}}
                  {{-- <div class="col-md-6 col-sm-12">
                      <label>Pilih Kategori</label><br>
                     <select name="project_plan" disabled id="create-plan-select" class="select-plan form-control">

                  </select> --}}
                  {{-- </div> --}}
                  <div class="col-md-6 col-sm-12">
                    <label>Kategori Plan</label>
                      <select class="form-control" id="select-plan-cat" name="project_plan">
                       
                        
                      </select>
                  </div>  
                 
                  <div class="col-md-12 col-sm-12" id="loader-plan" style="display: none;">
                     <span><i class="fas fa-spin fa-spinner"></i> Mohon Tunggu...</span>
                  </div>
                  <div class="col-md-6 col-sm-12" id="field_tanggal" style="display: none;">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Tanggal</label>
                        <input type="date" id="tanggal_new" name="tanggal" disabled max="" min=""  required="" class="form-control">
                      </div>
                      <div class="col-md-6">
                        <label>Selesai Pada</label>
                        <input type="date" id="tanggal_new_deadline" disabled name="deadline" max="" min=""  required="" class="form-control">
                      </div>
                    </div>
                  </div>
                
                  <div class="col-md-6 col-sm-12" id="hidden-done-new" style="display: none;">
                      <div  >
                      <hr>
                      <label>Kesulitan</label>
                      <input id="kesulitan" type="text" class="form-control selesai-check"  name="kesulitan"  >
                      <label>Solusinya</label>
                      <input id="solusi" type="text" class="form-control selesai-check"  name="solusi"  >
                      {{-- <span class="badge badge-warning">Jika sudah ditandai selesai maka tugas ini tidak dapat diubah</span>
                       <div class="custom-control custom-checkbox">
                                    <input id="selesai" class="custom-control-input selesai-check" type="checkbox"  name="selesai">
                                    <label for="selesai" class="custom-control-label">Tandai Sudah Selesai</label>
                                  </div> --}}
                      </div>
                  </div>
                 </div>
               </div>

              </div>

             </div>

             <div class="modal-footer">
               <button type="submit" id="submit-task-self" submit-button class="btn btn-primary btn-block" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
             </div>
           </div>
         </div>
       </div>
     </form>
        </div>
      </div>
          <!-- Modal -->
          <form id="form-task-select-tanggal">
          <div class="modal fade" id="pilih-tanggal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Pilih Tanggal</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                 <div class="row">
                      @csrf

                  <div class="col-md-12 col-sm-12">
                      <label>Tanggal</label>
                      <input type="date" name="tanggal_select" id="tanggal_select" value="{{date('Y-m-d')}}" required="" class="form-control">
                  </div>

                 </div>

                </div>

                <div class="modal-footer">
                  <button type="submit" submit-button class="btn btn-primary btn-block" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tampilkan</button>
                </div>
              </div>
            </div>
          </div>
          </form>
    </div>
     <div class="col-sm-12 col-md-12">
     {{--  <a  adv-filter href="#" class="btn btn-outline-primary btn-sm mt-2" position="0">Filter Lanjutan <i chevron class="fa fa-chevron-down" aria-hidden="true"></i>
</a> --}}
      <div id="show-filter" style="">
        <hr>
        <form action="" method="GET" id="form-filter">
              <div class="row">
              <div class="col-md-4">
                <label class="">Tanggal Awal</label>
                <input type="date" value="{{date("Y-m-d")}}" id="start_date-filter" name="start_date" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="">Tanggal Akhir</label>
                <input type="date" value="{{date("Y-m-d")}}" id="end_date-filter"  name="end_date" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="">Progress diatas</label>
                <input type="number" min="0" max="99" value="0" id="progress-filter" name="progress" class="form-control">
              </div>
              <div class="col-md-12 mt-4">
              </div>
              <div class="col-md-12 mt-4">
                <button class="btn btn-primary btn-block">Cari</button>
              </div>
            </div>
        </form>
          </div>
        </div>
</div>
</div>
<div class="col-md-6">
<div id="calendar">
 {!! Calendar::taskGenerate(date('m'),date('Y'))!!}
</div>
  </div>
</div>
<div class="row">


    <div class="col-12">
        <hr>
         <div class="table-responsive-sm">
        <table id="task-table" class="table table-striped projects">
              <thead>
                  <tr>

                      <th style="width: 30%">
                          Nama Tugas
                      </th>
                      <th style="width: 20%">
                         Nama Projek
                      </th>
                      <th style="width: 20%">
                         Mulai - Selesai
                      </th>

                      <th style="width: 30%">
                          Progress Tugas
                      </th>
                      <th style="width: 10%;">
                          Status
                      </th>
                      <th style="width: 20%;">
                          Aksi
                      </th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
         </div>
    </div>
</div>



@endif
@endsection

@section('javascript')
@if(!empty(auth()->user()->karyawan_id))
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
CKEDITOR.replace( 'detail',{ removePlugins: 'sourcearea',placeholder : 'Test'} );
$(function(){

  $('#create-plan-select').prop('disabled',false);
  $('#create-plan-select').select2({
    width: '100%',
    dropdownAutoWidth: true,
    dropdownParent: $("#tugas-baru"),
    ajax: {
      delay: 250,
      url: '{{route("project.plan.select")}}?project_id={{Request::route('project_id')}}',
      dataType: 'json',
       data: function (params) {
          var query = {
              search: params.term,
            }
            return query;
      },
         processResults: function (data) {
        return {
          results: data
        };
      }
    }
  });
})
$('#create-plan-select').change(function(){
  let formData = new FormData();
  $(".loader").show();
  formData.append('id', $(this).val());
  axios.post('{{route("task.planProject.select")}}', formData)
          .then(function (response) {
          $(".deadline").attr('disabled',false)
          $(".deadline").attr('min',response.data.task.data.start_date)
          $(".deadline").attr('max',response.data.task.data.end_date)
          $(".tanggal").attr('min',response.data.task.data.start_date)
          $(".tanggal").attr('max',response.data.task.data.end_date)
          $(".tanggal").attr('disabled',false)
            $(".loader").hide();
        })
        .catch(function (error) {
        $(".loader").hide();

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
$('#create-project-select').select2({
  width: '100%',
  dropdownAutoWidth: true,
  dropdownParent: $("#tugas-baru"),
  ajax: {
    delay: 250,
    url: '{{route("project.select")}}',
    dataType: 'json',
     data: function (params) {
        var query = {
            search: params.term,
          }
          return query;
    },
       processResults: function (data) {
      return {
        results: data
      };
    }
  }
});
$('#select-plan-cat').change(function(e){
   $('#tanggal_new').prop('disabled',true);
   $('#tanggal_new_deadline').prop('disabled',true);
   $('#loader-plan').show();
   $('#submit-task-self').prop('disabled',true);
        axios.get('{{route("task.assign.get.date")}}?id='+$(this).val())
        .then(function (response) {
          $('#field_tanggal').slideDown();
          $('#submit-task-self').prop('disabled',false);
          $('#loader-plan').hide();
          $('#tanggal_new').prop('disabled',false);
          $('#tanggal_new_deadline').prop('disabled',false);
          $('#tanggal_new').attr('min',response.data.start_date);
          $('#tanggal_new_deadline').attr('min',response.data.start_date);
          $('#tanggal_new_deadline').attr('max',response.data.end_date);
          $('#tanggal_new').attr('max',response.data.end_date);
        })
        .catch(function (error) {
           $('#loader-plan').hide();
        })

})
$('#select-plan-cat').select2({
      dropdownAutoWidth: true,
      dropdownParent: $("#add-tugas"),
      width: '100%',
      ajax: {
          delay: 250,
          url: '{{route("project.task.assign.plan.list",['project_id'=> $project_id])}}',
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
$('#edit-select-project').select2({
  width: '100%',
  dropdownAutoWidth: true,
  dropdownParent: $("#edit-task"),
  ajax: {
    delay: 250,
    url: '{{route("project.select")}}',
    dataType: 'json',
     data: function (params) {
        var query = {
            search: params.term,
          }
          return query;
    },
       processResults: function (data) {
      return {
        results: data
      };
    }
  }
});
        $(function() {
             window.table =    $('#task-table').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
  },
                    ajax: "{{ route('task.datatables')}}?project_id={{Request::route('project_id')}}",
                    columns: [{
                            data: 'task_name',
                            name: 'task_name'
                        },{
                            data: 'project_name',
                            name: 'project_name'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },{
                            data: 'progress_task',
                            name: 'progress_task'
                        },{
                            data: 'status',
                            name: 'status'
                        },
                         {
                            data: 'aksi',
                            name: 'aksi'
                        },
                    ]
                });
             window.process_new_slider = $('#process_new').ionRangeSlider({
                min: 0,
                max: 100,
                type: 'single',
                step: 1,
                postfix: '%',
                prettify: true,
                hasGrid: true
            });
              window.process_edit_slider = $('#process_edit').ionRangeSlider({
                min: 0,
                max: 100,
                type: 'single',
                step: 1,
                postfix: '%',
                prettify: true,
                hasGrid: true
            });
        })

    $('#form-filter').submit(function(e){
        e.preventDefault();
        let formData = new FormData();
        formData.append('start_date', $("#start_date-filter").val());
        formData.append('end_date', $("#end_date-filter").val());
        formData.append('progress', $("#progress-filter").val());
         $("#task-table").dataTable().fnDestroy()
        $('#task-table').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                  "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                                },
                         ajax: {
                          "url": "{{ route('task.datatables')}}?project_id={{Request::route('project_id')}}&start_date="+$("#start_date-filter").val()+"&end_date="+$("#end_date-filter").val()+"&progress="+$("#progress-filter").val(),
                          "type": "GET",
                        },
                          columns: [{
                                  data: 'task_name',
                                  name: 'task_name'
                              },{
                                  data: 'project_name',
                                  name: 'project_name'
                              },
                              {
                                  data: 'tanggal',
                                  name: 'tanggal'
                              },{
                                  data: 'progress_task',
                                  name: 'progress_task'
                              },{
                                  data: 'status',
                                  name: 'status'
                              },
                               {
                                  data: 'aksi',
                                  name: 'aksi'
                              },
                          ]
                      });
          });

    $('#test').click(function(){
         window.table.ajax.reload();
    });


    $('#resuming_new').change(function(e){
      if($(this).is(":checked"))
      {
        $('.resuming-show').slideDown();
      } else{
         $('.resuming-show').slideUp();
      }
    })
     $('#form-task-edit').submit(function(e){
            e.preventDefault();
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            $("[spinner]").show();
            $("[submit-button]").prop( "disabled", true );
            let form = $('#form-task-edit')[0];
            let formData = new FormData(form);
            axios.post('{{route("task.update")}}', formData)
              .then(function (response) {
                $('#edit-task').modal('hide');
                $("[spinner]").hide();
                $("#solusi").val('');
                $("#kesulitan").val('');
                $("#detail").val('');
                $("[submit-button]").prop( "disabled", false );
                $("#calendar").load(location.href + " #calendar");
                window.table.ajax.reload();
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
              });
    })
    $('#form-task-select-tanggal').submit(function(e){
            e.preventDefault();
        let formData = new FormData();
        $("#pilih-tanggal").modal('hide')
        formData.append('start_date', $("#start_date-filter").val());
        formData.append('end_date', $("#end_date-filter").val());
        formData.append('progress', $("#progress-filter").val());
         $("#task-table").dataTable().fnDestroy()
        $('#task-table').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                  "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                                },
                         ajax: {
                          "url": "{{ route('task.datatables')}}?project_id={{Request::route('project_id')}}&start_date="+$("#tanggal_select").val()+"&end_date="+$("#tanggal_select").val(),
                          "type": "GET",
                        },
                          columns: [{
                                  data: 'task_name',
                                  name: 'task_name'
                              },{
                                  data: 'project_name',
                                  name: 'project_name'
                              },
                              {
                                  data: 'tanggal',
                                  name: 'tanggal'
                              },{
                                  data: 'progress_task',
                                  name: 'progress_task'
                              },{
                                  data: 'status',
                                  name: 'status'
                              },
                               {
                                  data: 'aksi',
                                  name: 'aksi'
                              },
                          ]
                      });
    })

    $("[adv-filter]").click(function(e){
      e.preventDefault();
      console.log($(this).prop('position'));
      if($(this).prop('position') == 0 || $(this).prop('position') == null)
      {
        $("[chevron]").removeClass("fa-chevron-down").addClass("fa-chevron-up");
        $("#show-filter").slideDown();
        $(this).prop('position',1);
      }else{
         $("[chevron]").removeClass("fa-chevron-up").addClass("fa-chevron-down");
         $("#show-filter").slideUp();
        $(this).prop('position',0);
      }
    });
       function editTask(id){
        // alert("ok");

        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
        formData.append('id', id);
        axios.post('{{route("task.show")}}', formData)
                .then(function (response) {
                $("#my_task").text(response.data.task.data_member.keterangan)
                $("#task_name").val(response.data.task.data.task_name)
                $("#tanggal").val(response.data.task.data.tanggal)
                window.process_edit_slider.data('ionRangeSlider').update({
                    from: response.data.task.data.process
                });

                $("#process_edit").val(response.data.task.data.process)
                $("#task-id").val(response.data.task.data.id)
                $("#selesai_edit").prop('checked', response.data.task.data.is_done);
                $("#solusi").val('');
                $("#kesulitan").val('');
                $("#detail").val('');
                $("#edit-select-project").append(new Option( response.data.task.data.project_name,  response.data.task.data.project_id));

                if(response.data.task.data.solusi != null)
                {
                  $(".selesai-check").prop('disabled',false)
                  $("#hidden-done-edit").show();
                }
                $('#edit-task').modal('show');
                $("#icon-"+id).addClass('fa-pencil-alt').removeClass('fa-spinner fa-spin');
              })
              .catch(function (error) {
                $("#icon-"+id).addClass('fa-pencil-alt').removeClass('fa-spinner fa-spin');

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
      function deleteTask(id)
      {
        Swal.fire({
          title: 'Anda ingin menghapus task ini?',
          showCancelButton: true,
          confirmButtonText: `Hapus`,
        }).then((result) => {
          if (result.isConfirmed) {
            deleteAct(id);
          }
        })
      }
      function findDate(date)
      {
        $("#task-table").dataTable().fnDestroy()
        $('#task-table').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                  "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                                },
                         ajax: {
                          "url": "{{ route('task.datatables')}}?project_id={{Request::route('project_id')}}&start_date="+date+"&end_date="+date,
                          "type": "GET",
                        },
                          columns: [{
                                  data: 'task_name',
                                  name: 'task_name'
                              },{
                                  data: 'project_name',
                                  name: 'project_name'
                              },
                              {
                                  data: 'tanggal',
                                  name: 'tanggal'
                              },{
                                  data: 'progress_task',
                                  name: 'progress_task'
                              },{
                                  data: 'status',
                                  name: 'status'
                              },
                               {
                                  data: 'aksi',
                                  name: 'aksi'
                              },
                          ]
                      });
      }
      function deleteAct(id){
        // alert("ok");
        let formData = new FormData();
        formData.append('id', id);
        axios.post('{{route("task.delete")}}', formData)
                .then(function (response) {

                window.table.ajax.reload();
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
        function changeStatus(target,value)
        {
          if(value >= 100)
          {
            $(".selesai-check").prop('disabled',false)
            $(target).slideDown();
          }else{
            $(".selesai-check").prop('disabled',true)
            $(target).slideUp();
          }
        }



$('#form-task').submit(function(e){
            e.preventDefault();
            $("[spinner]").show();
            $("[submit-button]").prop( "disabled", true );
            let form = $('#form-task')[0];
            let formData = new FormData(form);
            axios.post('{{route("project.task.assign.request")}}', formData)
              .then(function (response) {
                $('#tugas-baru').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#task_name_new").val("")
                $("#tanggal_new").val("")
                $("#process_new").val(0)
                $("#selesai").prop('checked',false);
                $("#form-task").trigger("reset");
                $('#add-tugas').modal('hide');
                $('#memberlog-act-'+response.data.task.data.id).trigger('click')
                 // toastr.info('Anda bisa melapo.')
                // memberAssign(response.data.task.data.id);

                window.table.ajax.reload();
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
              });
    })
</script>
@endif
@endsection
