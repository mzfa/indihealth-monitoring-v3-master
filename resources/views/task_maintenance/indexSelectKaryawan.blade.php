@extends('layouts/master_dashboard')
@section('title','Lihat Tugas '.$data->nama_lengkap." (".$data->jabatan->nama.")")
@section('subtitle', $data->tipe_karyawan)
@section('content')
<style type="text/css">
 
</style>

<div class="row">
  <div class="col-md-6">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <button class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#modal-select-karyawan"><i class="fas fa-user"></i> Pilih Karyawan</button>
        </div>
    <div class="col-md-6 col-sm-12">
          <button class="btn btn-success btn-block"  type="button"  data-toggle="modal" data-target="#pilih-tanggal" ><i class="fas fa-calendar"></i> Pilih Tanggal</button>
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
                      <input type="date" name="tanggal_select" value="{{date('Y-m-d')}}" id="tanggal_select" required="" class="form-control">
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
                <label>Tanggal Awal</label>
                <input type="date" value="{{date("Y-m-d")}}" id="start_date-filter" name="start_date" class="form-control">
              </div>
              <div class="col-md-4">
                <label>Tanggal Akhir</label>
                <input type="date" value="{{date("Y-m-d")}}" id="end_date-filter"  name="end_date" class="form-control">
              </div> 
              <div class="col-md-4">
                <label>Progress diatas</label>
                <input type="number" min="0" max="99" value="0" id="progress-filter" name="progress" class="form-control">
              </div>
              <div class="col-md-12 mt-2">
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
 {!! Calendar::taskGenerate(5,2021,Request::get('id'))!!}
</div>
  </div>
</div>
<div class="row">
    
    
    <div class="col-12">
        <hr>
        <table id="task-table" class="table table-striped projects">
              <thead>
                  <tr>
                    
                      <th style="width: 40%">
                          Nama Tugas
                      </th>
                      <th style="width: 20%">
                         Tanggal
                      </th>

                      <th style="width: 20%">
                          Progress Tugas
                      </th>
                      <th style="width: 10%;">
                          Status
                      </th>
                  </tr>
              </thead>
              <tbody>
                 
                  </tbody>
          </table>
    </div>
</div>




@endsection
@section('javascript')
<script type="text/javascript">
        $(function() {
             window.table =    $('#task-table').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
  },
                    ajax: "{{ route('task.karyawan.datatables',['id' => $data->id])}}",
                    columns: [{
                            data: 'task_name',
                            name: 'task_name'
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
                    ]
                });
             $('#process_new').ionRangeSlider({
                  min     : 0,
                  max     : 100,
                  type    : 'single',
                  step    : 1,
                  postfix : '%',
                  prettify: true,
                  hasGrid : true
                }) 
             $('#progress_edit').ionRangeSlider({
                  min     : 0,
                  max     : 100,
                  type    : 'single',
                  step    : 1,
                  postfix : '%',
                  prettify: true,
                  hasGrid : true
                })
            });

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
                          "url": "{{ route('task.karyawan.datatables',['id' => $data->id])}}?start_date="+$("#start_date-filter").val()+"&end_date="+$("#end_date-filter").val()+"&progress="+$("#progress-filter").val(),
                          "type": "GET",
                        },
                          columns: [{
                                  data: 'task_name',
                                  name: 'task_name'
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
                               
                          ]
                      });
          });

    $('#test').click(function(){
         window.table.ajax.reload();
    });

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
                          "url": "{{ route('task.karyawan.datatables',['id' => $data->id])}}?start_date="+date+"&end_date="+date,
                          "type": "GET",
                        },
                          columns: [{
                                  data: 'task_name',
                                  name: 'task_name'
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
                               
                          ]
                      });
      }

    $('#form-task').submit(function(e){
            e.preventDefault();
            $("[spinner]").show();
            $("[submit-button]").prop( "disabled", true );
            let form = $('#form-task')[0];
            let formData = new FormData(form);
            axios.post('{{route("task.save")}}', formData)
              .then(function (response) {
                $('#tugas-baru').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#task_name_new").val("")
                $("#tanggal_new").val("")
                $("#process_new").val(0)
                $("#selesai").prop('checked',false);
                $("#form-task").trigger("reset");
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
                          "url": "{{ route('task.karyawan.datatables',['id' => $data->id])}}?start_date="+$("#tanggal_select").val()+"&end_date="+$("#tanggal_select").val(),
                          "type": "GET",
                        },
                          columns: [{
                                  data: 'task_name',
                                  name: 'task_name'
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
                               
                          ]
                      });
    })
    $('#form-task-edit').submit(function(e){
            e.preventDefault();
            $("[spinner]").show();
            $("[submit-button]").prop( "disabled", true );
            let form = $('#form-task-edit')[0];
            let formData = new FormData(form);
            axios.post('{{route("task.update")}}', formData)
              .then(function (response) {
                $('#edit-task').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
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
                $("#task_name").val(response.data.task.data.task_name)
                $("#tanggal").val(response.data.task.data.tanggal)
                $("#process").val(response.data.task.data.process)
                $("#task-id").val(response.data.task.data.id)
                $("#selesai_edit").prop('checked', response.data.task.data.is_done);
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
            $(target).slideDown();
          }else{
            $(target).slideUp();
          }
        }


</script>
@endsection