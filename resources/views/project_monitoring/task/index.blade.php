@extends('layouts/master_dashboard')
@section('title','Detail progress projek ')
@section('subtitle',$project->name." (".$plan->name.")")
@section('content')
<style type="text/css">

</style>

<div class="row">
  <div class="col-md-6">
    <div class="row">

    <div class="col-md-6 col-sm-12">
          <button class="btn btn-success btn-block mt-2"  type="button"  data-toggle="modal" data-target="#pilih-tanggal" ><i class="fas fa-calendar"></i> Pilih Tanggal</button>
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
     <div class="col-sm-12 col-md-6">
       <button class="btn btn-primary btn-block mt-2"  type="button" task-new ><i class="fas fa-tasks"></i> Tambah Tugas</button>
       <form id="form-task">
       <div class="modal fade" id="tambah-tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg " role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tugas {{$plan->name}}</h5>
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
                      <input type="hidden" name="project_id" value="{{$id}}">
                      <input type="hidden" name="project_plan" value="{{$plan->id}}">
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
                    <div class="row">
                      <div class="col-md-6">
                        <label>Tanggal</label>
                        <input type="date" id="tanggal_new" name="tanggal" max="{{$plan->end_date}}" min="{{$plan->start_date}}"  required="" class="form-control">
                      </div>
                      <div class="col-md-6">
                        <label>Deadline</label>
                        <input type="date" id="tanggal_new_deadline" name="deadline" max="{{$plan->end_date}}" min="{{$plan->start_date}}"  required="" class="form-control">
                      </div>
                    </div>
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

              </div>

             </div>

             <div class="modal-footer">
               <button type="submit" submit-button class="btn btn-primary btn-block" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
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
</div>
  </div>
</div>
<div class="row">


    <div class="col-12">
        <hr>
        <div class="table-responsive table-responsive-sm">
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
                      <th style="width: 20%;">
                          Member Team
                      </th>
                      <th style="width: 10%;">
                          Status
                      </th>
                      <th style="width: 10%;">
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

<!-- Modal -->
<div class="modal fade" id="member-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tugaskan Anggota Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="task_id_select" id="t-id-select">
                <form id="form-member">
                    <div class="row">

                        <div class="col-md-6 col-sm-12">
                            @csrf
                            <input type="hidden" name="task_id" id="t-id">
                            <label>Pilih User</label>
                            <select class="form-control pilih-user" id="pilih-user" name="user_id"></select>

                        </div><div class="col-md-6 col-sm-12">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control"  placeholder="cth: Perbaiki validasi re-captcha ">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">

                            <button type="submit" submit-button class="btn btn-primary btn-block mt-2"><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tambah</button>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="table-responsive">
                    <table id="table-member" class="table table-bordered">
                        <thead>

                            <th>Nama</th>

                            <th>Tugas</th>

                            <th>Status</th>
                            <th>Aksi</th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="member-task-log" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Riwayat Pelaporan Tugas <br><b><small id="member-name">-</small></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
       <div class="row">


        <div class="col-md-12 col-sm-12">
          <table id="table-member-log" class="table table-striped">
            <thead>
              <th>Nama Tugas</th>
              <th>Tanggal Lapor</th>
              <th>Proses (%)</th>
              <th>Aksi</th>
          </table>
        </div>

       </div>

      </div>

      {{-- <div class="modal-footer">
        <button type="submit" submit-button class="btn btn-primary btn-block" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tampilkan</button>
      </div> --}}
    </div>
  </div>
</div>

<div class="modal fade" id="member-task-log-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Laporan Tugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

       <div class="row">
         <div  class="col-md-3 col-sm-3">
           <button class="btn btn-primary btn-block" id="genPDF">Simpan ke PDF</button>
           <input type="hidden" id="pdf_name">
         </div>
       </div>
       <div class="row" id="report">



        <div  class="col-md-12 col-sm-12">
          <b>Pembuat :</b> <br><span id="creator"></span><hr>
          <b>Dilaporkan pada tanggal :</b> <br><span id="detail-report-date"></span><hr>
          <div class="row">
            <div class="col-md-6 col-12">
              <b>Progress (%)</b>
              <div class="progress progress-sm">
                	<div class="progress-bar bg-blue" id="progress-log" role="progressbar" aria-volumenow="0" aria-volumemin="0" aria-volumemax="100" style="width: 0">
                </div>
              </div>
              <small>
                <span id="progress-log-info"></span>% Selesai
              </small>
            </div>

            <div class="col-md-12 col-12">
            </div>
            <div class="col-md-6 col-12">
              <b>Kesulitan</b>
              <p id="detail-log-kesulitan"></p>
            </div>
            <div class="col-md-6 col-12">
                <b>Solusi</b>
                <p id="detail-log-solusi"></p>
            </div>
            <div class="col-md-12 col-12">
                <b>Rincian</b>
                <div class="border">
                <p  class="m-2" id="detail-log-rincian"></p>
              </div>
            </div>
          </div>
        </div>

       </div>

      </div>

      {{-- <div class="modal-footer">
        <button type="submit" submit-button class="btn btn-primary btn-block" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tampilkan</button>
      </div> --}}
    </div>
  </div>
</div>
<form id="form-task-edit">
<div class="modal fade" id="edit-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ubah Data Tugas </h5>
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
               <input type="hidden" name="id" id="task-id-update">
               <label>Nama Tugas</label>
               <input type="text" id="update_task_name_new" name="task_name" placeholder="Contoh: Membuat modul absensi" required="" class="form-control">

           </div>

           <div class="col-md-6 col-sm-12">
             <div class="row">
               <div class="col-md-6">
                 <label>Tanggal</label>
                 <input type="date" id="update_tanggal_new" name="tanggal" max="{{$plan->end_date}}" min="{{$plan->start_date}}"  required="" class="form-control">
               </div>
               <div class="col-md-6">
                 <label>Deadline</label>
                 <input type="date" id="update_tanggal_new_deadline" name="deadline" max="{{$plan->end_date}}" min="{{$plan->start_date}}"  required="" class="form-control">
               </div>
             </div>
           </div>
           {{-- <div class="col-md-6 col-sm-12">
               <label>Progress</label>
               <input id="update_process_new" type="text"  name="process" onchange="changeStatus('#hidden-done-new',this.value)" value="0">
           </div> --}}
           <div class="col-md-6 col-sm-12" id="hidden-done-new_update" style="display: none;">

               <span class="badge badge-warning">Jika sudah ditandai selesai maka tugas ini tidak dapat diubah</span><br>
                {{-- <div class="custom-control custom-checkbox"> --}}
                             <input id="update_selesai" class="selesai-check" type="checkbox"  name="selesai">
                             <label for="update_selesai" >Tandai Sudah Selesai</label>
                           {{-- </div> --}}
               </div>
           </div>
          </div>
        </div>

       </div>
       <div class="modal-footer">
         <button type="submit" submit-button class="btn btn-primary btn-block" ><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
       </div>
     </div>
      </div>


  </div>

</form>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.0/jspdf.min.js" integrity="sha512-byyOyTN9h3x7ORuIOhOhNjuwctW3LSJZ0nfr72t22wyuYuBHhHCWqQLKLdbRxuJokiu9kRf8/kghFSjsybabdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
var doc = new jsPDF();
var specialElementHandlers = {
    '#report': function (element, renderer) {
        return true;
    }
};



$('#genPDF').click(function () {
    doc.fromHTML($('#report').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save($('#pdf_name').val()+'.pdf');
});


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
function memberUnlinkAct(id)
{
  $("#member-"+id).addClass('fa-spinner fa-spin').removeClass('fa-unlink')

  let formData = new FormData();
  formData.append('id',  id);
  axios.post('{{route("project.task.member.delete")}}', formData)
      .then(function(response) {
        $("#member-"+id).addClass('fa-unlink').removeClass('fa-spinner fa-spin')
          window.tbMember.ajax.reload();
      })
      .catch(function(error) {
          $("#member-"+id).addClass('fa-unlink').removeClass('fa-spinner fa-spin')
          if (error.response.status == 422) {

              $.each(error.response.data.errors, (i, j) => {
                  toastr.warning(j)
              })
          } else {

              Swal.fire({
                  title: 'Error!',
                  text: "Internal Server Error",
                  icon: 'warning',
                  confirmButtonText: 'OK'
              })

          }
      });
}
function memberLogDetail(id)
{
  $("#icon-member-log-"+id).addClass('fa-spinner fa-spin').removeClass('fa-eye');
  let formData = new FormData();
  formData.append('id', id);
  axios.post('{{route("project.member.log_detail")}}', formData)
      .then(function(response) {
          $('#member-task-log-detail').modal('show');
          $('#pdf_name').val("REPORT-TASK_"+response.data.member.data.name)
          $('#creator').html(response.data.member.data.name)
          $('#detail-log-kesulitan').html(response.data.member.data.kesulitan)
          $('#detail-log-solusi').html(response.data.member.data.solusi)
          $('#detail-log-rincian').html(response.data.member.data.rincian)
          $('#progress-log-info').html(response.data.member.data.process)
          $('#detail-report-date').html(response.data.member.data.report_date)
          $('#progress-log').attr("aria-volumenow",response.data.member.data.process)
          $('#progress-log').attr("style",'width:'+response.data.member.data.process+'%;')
          $("#icon-member-log-"+id).addClass('fa-eye').removeClass('fa-spinner fa-spin');

      })
      .catch(function(error) {
        $("#icon-member-log-"+id).addClass('fa-eye').removeClass('fa-spinner fa-spin');
          if (error.response.status == 422) {

              $.each(error.response.data.errors, (i, j) => {
                  toastr.warning(j)
              })
          } else {

              Swal.fire({
                  title: 'Error!',
                  text: "Internal Server Error",
                  icon: 'warning',
                  confirmButtonText: 'OK'
              })

          }
      });

}

// function editTask(id){
//  // alert("ok");
//
//  let formData = new FormData();
//  $("#icon-edit-"+id).addClass('fa-spinner fa-spin').removeClass('fa-edit');
//  formData.append('id', id);
//  axios.post('{{route("task.show")}}', formData)
//          .then(function (response) {
//          $("#update_task_name_new").val(response.data.task.data.task_name)
//          $("#update_tanggal_new").val(response.data.task.data.tanggal)
//          $("#update_tanggal_new_deadline").val(response.data.task.data.deadline)
//          window.process_edit_slider.data('ionRangeSlider').update({
//              from: response.data.task.data.process
//          });
//
//          $("#update_process_new").val(response.data.task.data.process)
//          $("#task-id-update").val(response.data.task.data.id)
//          $("#update_selesai").prop('checked', response.data.task.data.is_done);
//
//          if(response.data.task.data.solusi != null)
//          {
//            $(".selesai-check").prop('disabled',false)
//            $("#hidden-done-edit").show();
//          }
//          $('#edit-task').modal('show');
//          $("#icon-edit-"+id).addClass('fa-edit').removeClass('fa-spinner fa-spin');
//        })
//        .catch(function (error) {
//          $("#icon-edit-"+id).addClass('fa-edit').removeClass('fa-spinner fa-spin');
//
//         if(error.response.status == 422){
//
//              $.each(error.response.data.errors, (i, j) => {
//               toastr.warning(j)
//            })
//         } else{
//
//           Swal.fire({
//              title: 'Error!',
//              text: "Internal Server Error",
//              icon: 'warning',
//              confirmButtonText: 'OK'
//            })
//
//         }
//        });
// }
function memberLog(id_user,name)
{
  $("#table-member-log").dataTable().fnClearTable();
  $("#table-member-log").dataTable().fnDestroy();
      $('#member-task-log').modal('show');
      $('#member-name').html(name);
      window.tbmemberLogDetail = $('#table-member-log').DataTable({
          "order": [
              [1, "desc"]
          ],
          processing: true,
          serverSide: true,
          autoWidth: false,
          "language": {
              "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
              "emptyTable": "Belum ada tugas yang dilaporkan."
          },
          ajax: {
            "url":"{{ route('project.task.member.datatables_log')}}",
            'type':'POST',
             'data': {
                  user_id: id_user,
                  task_id: $("#t-id-select").val(),
                  "_token": "{{ csrf_token() }}"
                  // etc..
               },
           },

          columns: [
              {
                  data: 'nama_tugas',
                  name: 'nama_tugas'
              }, {
                  data: 'tanggal',
                  name: 'tanggal'
              },{
                  data: 'progress',
                  name: 'progress'
              },{
                  data: 'aksi',
                  name: 'aksi'
              }
          ]
      });
}
function memberUnlink(id)
{
  Swal.fire({
    title: 'Anda ingin menghapus member ini?',
    showCancelButton: true,
    confirmButtonText: `Hapus`,
  }).then((result) => {
    if (result.isConfirmed) {
      memberUnlinkAct(id)
    }
  })
}
function memberAssign(id,status)
{
  if(status)
  {
    $('#form-member').remove();
  }
  $("#table-member").dataTable().fnClearTable();
  $("#table-member").dataTable().fnDestroy();
    $('#member-task').modal('show');
    $('#t-id').val(id);
    $('#t-id-select').val(id);

    window.tbMember = $('#table-member').DataTable({
        "order": [
            [2, "asc"]
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        "language": {
            "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },

        ajax: "{{ route('project.task.member.datatables')}}?task_id=" + id,
        columns: [
            {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'keterangan',
                name: 'keterangan'
            },{
                data: 'status',
                name: 'status'
            },{
                data: 'aksi',
                name: 'aksi'
            }
        ]
    });

}
$('#form-member').submit(function(e) {
    e.preventDefault();
    $("[spinner]").show();
    $("[submit-button]").prop("disabled", true);
    let form = $('#form-member')[0];
    let formData = new FormData(form);
    axios.post('{{route("project.task.member.save")}}', formData)
        .then(function(response) {
            $('#edit-task').modal('hide');
            $("[spinner]").hide();
            $("[submit-button]").prop("disabled", false);
            window.tbMember.ajax.reload();
        })
        .catch(function(error) {
            $("[spinner]").hide();
            $("[submit-button]").prop("disabled", false);
            if (error.response.status == 422) {

                $.each(error.response.data.errors, (i, j) => {
                    toastr.warning(j)
                })
            } else {

                Swal.fire({
                    title: 'Error!',
                    text: "Internal Server Error",
                    icon: 'warning',
                    confirmButtonText: 'OK'
                })

            }
        });
})
$('.pilih-user').select2({
    width: '100%',
    placeholder: "Pilih Pengguna ",
    dropdownParent: $("#member-task"),
    ajax: {
        delay: 250,
        url: '{{route("project.pengguna.select")}}?project_id={{$id}}',
        dataType: 'json',
        data: function(params) {
            var query = {
                search: params.term,
            }
            return query;
        },
        processResults: function(data) {
            $(".select-ticket").select2("val", "");
            return {
                results: data
            };
        }
    }
});

$("[task-new]").click(function(){
    $('#tambah-tugas').modal('show');
})
        $(function() {
             window.table =    $('#task-table').DataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
  },
                    ajax: "{{ route('project.plan.tasks.dataTables',['project_id' => Request::route('project_id'),'plan_id' => Request::route('plan_id')])}}",
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

                            data: 'member',
                            name: 'member'
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
        // alert('a');
        formData.append('start_date', $("#start_date-filter").val());
        formData.append('end_date', $("#end_date-filter").val());
        formData.append('progress', $("#progress-filter").val());
         $("#task-table").dataTable().fnDestroy()
        $('#task-table').dataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                  "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                                },
                         ajax: {
                          "url": "{{ route('project.plan.tasks.dataTables',['project_id' => Request::route('project_id'),'plan_id' => Request::route('plan_id')])}}?start_date="+$("#start_date-filter").val()+"&end_date="+$("#end_date-filter").val()+"&progress="+$("#progress-filter").val(),
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

                                data: 'member',
                                name: 'member'
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
                          "url": "{{ route('project.plan.tasks.dataTables',['project_id' => Request::route('project_id'),'plan_id' => Request::route('plan_id')])}}?start_date="+date+"&end_date="+date,
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

                                data: 'member',
                                name: 'member'
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

    $('#form-task').submit(function(e){
            e.preventDefault();
            $("[spinner]").show();
            $("[submit-button]").prop( "disabled", true );
            let form = $('#form-task')[0];
            let formData = new FormData(form);
            axios.post('{{route("project.task.assign.save")}}', formData)
              .then(function (response) {
                $('#tugas-baru').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#task_name_new").val("")
                $("#tanggal_new").val("")
                $("#process_new").val(0)
                $("#selesai").prop('checked',false);
                $("#form-task").trigger("reset");
                $('#tambah-tugas').modal('hide');
                 toastr.info('Silahkan tambahkan anggota team yang terlibat untuk tugas ini.')
                memberAssign(response.data.task.data.id);

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
        $('#task-table').dataTable({
                    "order": [[ 2, "asc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                  "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                                },
                         ajax: {
                          "url": "{{ route('project.plan.tasks.dataTables',['project_id' => Request::route('project_id'),'plan_id' => Request::route('plan_id')])}}?start_date="+$("#tanggal_select").val()+"&end_date="+$("#tanggal_select").val(),
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
            axios.post('{{route("task.pm.update")}}', formData)
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
       $("#icon-edit-"+id).addClass('fa-spinner fa-spin').removeClass('fa-edit');
        formData.append('id', id);
        axios.post('{{route("task.show")}}', formData)
                .then(function (response) {
                $("#update_task_name_new").val(response.data.task.data.task_name)
                $("#update_tanggal_new").val(response.data.task.data.tanggal)
                $("#update_tanggal_new_deadline").val(response.data.task.data.tanggal)
                // $("#process").val(response.data.task.data.process)
                $("#task-id-update").val(response.data.task.data.id)
                $("#selesai_edit").prop('checked', response.data.task.data.is_done);
                $('#edit-task').modal('show');
                $("#icon-edit-"+id).addClass('fa-edit').removeClass('fa-spinner fa-spin');
                if(response.data.task.data.process == 100)
                {
                  $(".selesai-check").prop('disabled',false)
                  $("#hidden-done-new_update").show();
                }
              })
              .catch(function (error) {
                $("#icon-edit-"+id).addClass('fa-edit').removeClass('fa-spinner fa-spin');

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
        function openTask(id)
        {
          Swal.fire({
            title: 'Anda ingin membuka task ini?',
            showCancelButton: true,
            confirmButtonText: `Ya`,
          }).then((result) => {
            if (result.isConfirmed) {
              UnlockAct(id);
            }
          })
        }
        function UnlockAct(id){
          // alert("ok");
          let formData = new FormData();
          formData.append('id', id);
          axios.post('{{route("task.project.unlockTask",['project_id' => Request::route('project_id')])}}', formData)
                  .then(function (response) {

                  window.table.ajax.reload();
                   Swal.fire({
                      // title: 'Unlock Task',
                      text: "Task berhasil dibuka.",
                      icon: 'success',
                      confirmButtonText: 'OK'
                    })
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

</script>
@endsection
