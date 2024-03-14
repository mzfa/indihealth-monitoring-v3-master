@extends('layouts/master_dashboard')
@section('title','Kelola Projek')
@section('content')

<div class="row">
    <div class="col-12">
        @error('start_date')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('end_date')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3 col-sm-12">
        <a href="{{route('karyawan.create')}}" title="Tambah Projek" data-toggle="modal" data-target="#create-project"  class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Tambah Projek</a>
        <hr>

      <form id="form-ubah-projek">
         <div class="modal fade" id="form-ubah-projek-modal" -modaltabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Ubah data Projek</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <input type="hidden" name="id" id="id_projek">
                            <div class="col-md-6">
                                <label>Nama Projek</label>
                                <input type="text" required="" id="ubah_nama_projek" name="nama_projek" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Client</label>
                                <input type="text" required="" id="ubah_client" name="client" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Mulai</label>
                                <input type="date" required="" id="ubah_tanggal" name="tanggal" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Deadline</label>
                                <input type="date" required="" id="ubah_deadline" name="deadline" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Deskripsi</label>
                                <textarea required="" id="ubah_deskripsi" name="deskripsi" class="form-control"></textarea>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" submit-button><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
      </form>
        <form id="form-tambah-projek">
         <div class="modal fade" id="create-project" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Tambah Projek Baru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <div class="col-md-6">
                                <label>Nama Projek</label>
                                <input type="text" required="" id="nama_projek" name="nama_projek" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Client</label>
                                <input type="text" required="" id="client" name="client" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Mulai</label>
                                <input type="date" required="" id="tanggal" name="tanggal" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Deadline</label>
                                <input type="date" required="" id="deadline" name="deadline" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Deskripsi</label>
                                <textarea required="" id="deskripsi" name="deskripsi" class="form-control"></textarea>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" submit-button><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
      </form>

      <div class="modal fade" id="member-project" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-xl" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Anggota Projek <br> <small id="member_project_name"></small></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body" >
                      <div class="row">
                         <div class="col-md-6">
                           <label>Pilih User</label>
                           <select class="form-control pilih-user" id="pilih-user" name="user_id"></select>
                           <input type="hidden" id="member_project_id" value="">
                           <div class="custom-control custom-checkbox mt-1">
                           <input class="custom-control-input" type="checkbox" name="is_pm" id="pm" value='1'>
                           <label for="pm" class="custom-control-label">Project Manager</label>
                         </div>
                          <button type="button" add-member class="btn btn-success mt-2 btn-block"><i class="fas fa-plus" id="icon-add"></i> Tambahkan</button>
                         </div>

                         <div class="col-md-12">
                           <hr>
                          <h5>Anggota yang terhubung</h5>
                          <small>Keterangan:<br></small>
                          <span class="badge badge-primary">PM</span> : Project Manager<br>
                           <span class="badge badge-secondary">TM</span> : Team Member
                           <hr>
                          <table  id="memberTable" class="table table-striped">
                            <thead>
                              <th>Nama</th>
                              <th>Jabatan</th>
                              <th>Tanggal ditambahkan</th>
                              <th>Aksi</th>
                            </thead>
                          </table>
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

    </div>
    <div class="col-12">
        <div class="table-responsive-sm">
            <table class="table  table-bordered table-hover" id="absenTable">
                <thead>
                    <th>Nama</th>
                    <th>Client</th>
                    <th>Tanggal</th>
                    <th>Deadline</th>
                    <th>Anggota</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('javascript')
 <script type="text/javascript">
 $('.pilih-user').select2({
     width: '100%',
     placeholder: "Pilih Pengguna ",
     dropdownParent: $("#member-project"),
     ajax: {
         delay: 250,
         url: '{{route("pengguna.select")}}',
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
        $(function() {
               window.table = $('#absenTable').DataTable({
                                "order": [[ 2, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('project.datatables')}}",
                                columns: [{
                                        data: 'name',
                                        name: 'name'
                                    },
                                    {
                                        data: 'client',
                                        name: 'client'
                                    },{
                                        data: 'tanggal',
                                        name: 'tanggal'
                                    },{
                                        data: 'deadline',
                                        name: 'deadline'
                                    },
                                    {
                                        data: 'anggota_projek',
                                        name: 'anggota_projek'
                                    },
                                    {
                                        data: 'description',
                                        name: 'description'
                                    },
                                     {
                                        data: 'aksi',
                                        name: 'aksi'
                                    },
                                ]
                            });
                        });
    $('[add-member]').click(function(){
      var user_id = $('#pilih-user').val();
      var project_id = $('#member_project_id').val();
      var pm = $('#pm').val();
      if(user_id == null)
      {
        Swal.fire({
           // title: 'Error!',
           text: "Pengguna harus dipilih",
           icon: 'warning',
           confirmButtonText: 'OK'
         })
         return false;
      }
      if(project_id == null)
      {
        Swal.fire({
           // title: 'Error!',
           text: "Gagal mengambil data projek, silahkan muat ulang halaman.",
           icon: 'warning',
           confirmButtonText: 'OK'
         })
         return false;
      }
      var btn = $(this);
      let formData = new FormData();
      btn.attr('disabled',true);
      $("#icon-add").addClass('fa-spinner fa-spin').removeClass('fa-plus');
      formData.append('user_id', user_id);
      formData.append('project_id', project_id);
      if($('#pm').is(":checked"))
      {
        formData.append('is_pm', pm);
      }
      axios.post('{{route("project.member.save")}}', formData)
              .then(function (response) {
                $('#pm').prop('checked', false);
                $(".pilih-user").select2("val", "");
                 toastr.success("Berhasil menambahkan member projek.")
                 window.table_member.ajax.reload();
              $("#icon-add").addClass('fa-plus').removeClass('fa-spinner fa-spin');
            btn.attr('disabled',false);
            })
            .catch(function (error) {
              $("#icon-add").addClass('fa-plus').removeClass('fa-spinner fa-spin');
            btn.attr('disabled',false);
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
    function editProject(id)
    {
        console.log(id);
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
        formData.append('id', id);
        axios.post('{{route("project.show")}}', formData)
                .then(function (response) {
                $('#form-ubah-projek-modal').modal('show');
                $("#id_projek").val(response.data.project.data.id)
                $("#ubah_nama_projek").val(response.data.project.data.name)
                $("#ubah_client").val(response.data.project.data.client)
                $("#ubah_tanggal").val(response.data.project.data.tanggal)
                $("#ubah_deadline").val(response.data.project.data.deadline)
                $("#ubah_deskripsi").val(response.data.project.data.description)
                if(response.data.project.data.solusi != null)
                {
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

    function deleteMemberAct(id)
    {
      $("#icon-member-del-"+id).addClass('fa-spinner fa-spin').removeClass('fa-trash');
      let formData = new FormData();
      formData.append('id', id);
      axios.post('{{route("project.member.delete")}}', formData)
              .then(function (response) {
              toastr.success(response.data.member.messages)
              window.table_member.ajax.reload();
              $("#icon-member-del-"+id).addClass('fa-trash').removeClass('fa-spinner fa-spin');
            })
            .catch(function (error) {
              $("#icon-member-del-"+id).addClass('fa-trash').removeClass('fa-spinner fa-spin');
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
    function setPMAct(id)
    {
      $("#icon-member-pm-"+id).addClass('fa-spinner fa-spin').removeClass('fa-user-tie');
      let formData = new FormData();
      formData.append('id', id);
      formData.append('setPM', 1);
      axios.post('{{route("project.member.setPM")}}', formData)
              .then(function (response) {
              toastr.success(response.data.member.messages)
              window.table_member.ajax.reload();
              $("#icon-member-pm-"+id).addClass('fa-user-tie').removeClass('fa-spinner fa-spin');
            })
            .catch(function (error) {
              $("#icon-member-pm-"+id).addClass('fa-user-tie').removeClass('fa-spinner fa-spin');
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
    function unsetPMAct(id)
    {
      $("#icon-member-pm-"+id).addClass('fa-spinner fa-spin').removeClass('fa-user-tie');
      let formData = new FormData();
      formData.append('id', id);
      formData.append('setPM', 0);
      axios.post('{{route("project.member.setPM")}}', formData)
              .then(function (response) {
              toastr.success(response.data.member.messages)
              window.table_member.ajax.reload();
              $("#icon-member-pm-"+id).addClass('fa-user-tie').removeClass('fa-spinner fa-spin');
            })
            .catch(function (error) {
              $("#icon-member-pm-"+id).addClass('fa-user-tie').removeClass('fa-spinner fa-spin');
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
    function deleteMember(id)
    {
      Swal.fire({
        title: 'Anda ingin menghapus member ini?',
        showCancelButton: true,
         confirmButtonColor: '#d9534f',
        confirmButtonText: `Hapus`,
      }).then((result) => {
        if (result.isConfirmed) {
          deleteMemberAct(id);
        }
      })
    }
    function setPM(id)
    {
      Swal.fire({
        title: 'Anda ingin menjadikan member ini Project Manager?',
        showCancelButton: true,
         // confirmButtonColor: '#d9534f',
        confirmButtonText: `Ya`,
      }).then((result) => {
        if (result.isConfirmed) {
          setPMAct(id);
        }
      })
    }
    function unsetPM(id)
    {
      Swal.fire({
        title: 'Anda ingin menghapus PM ini?',
        showCancelButton: true,
         // confirmButtonColor: '#d9534f',
        confirmButtonText: `Ya`,
      }).then((result) => {
        if (result.isConfirmed) {
          unsetPMAct(id);
        }
      })
    }
    function memberProject(id)
    {
        $("#memberTable").dataTable().fnClearTable();
        $("#memberTable").dataTable().fnDestroy();
        let formData = new FormData();
        $("#iconMember-"+id).addClass('fa-spinner fa-spin').removeClass('fa-users');
        formData.append('id', id);
        axios.post('{{route("project.show")}}', formData)
                .then(function (response) {
                $("#member_project_id").val(response.data.project.data.id)
                $("#member_project_name").html(response.data.project.data.name+" ("+response.data.project.data.client+")")
                $('#member-project').modal('show');
                $("#iconMember-"+id).addClass('fa-users').removeClass('fa-spinner fa-spin');

              window.table_member =  $('#memberTable').DataTable({
                                 "order": [[ 2, "asc" ]],
                                 processing: true,
                                 serverSide: true,
                                 autoWidth:false,
                                 "language": {
                 "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
                   "emptyTable": "Belum ada member di projek ini.",
                        "info":"Menampilkan _START_ sampai _END_ dari _TOTAL_ Anggota team",
                    "infoEmpty":  "Data masih kosong",
               },
                                 ajax: "{{ route('project.member.datatables')}}?id="+id,
                                 columns: [{
                                         data: 'nama',
                                         name: 'nama'
                                     },
                                     {
                                         data: 'jabatan',
                                         name: 'jabatan'
                                     },
                                     {
                                         data: 'ditambahkan_pada',
                                         name: 'ditambahkan_pada'
                                     },{
                                         data: 'aksi',
                                         name: 'aksi'
                                     },
                                 ]
                             });
                         })

              .catch(function (error) {
                $("#iconMember-"+id).addClass('fa-users').removeClass('fa-spinner fa-spin');

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
    $("#form-tambah-projek").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-tambah-projek')[0];
        let formData = new FormData(form);
        axios.post('{{route("project.save")}}', formData)
                .then(function (response) {
                  $('#create-project').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#nama_projek").val("")
                $("#client").val("")
                $("#tanggal").val("")
                $("#deadline").val("")
                $("#deskripsi").val("")
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
    });
    $("#form-ubah-projek").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-ubah-projek')[0];
        let formData = new FormData(form);
        axios.post('{{route("project.update")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();

                $('#form-ubah-projek-modal').modal('hide');
                $("[submit-button]").prop( "disabled", false );
                $("#ubah_nama_projek").val("")
                $("#ubah_client").val("")
                $("#ubah_tanggal").val("")
                $("#ubah_deadline").val("")
                $("#ubah_deskripsi").val("")
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
    });

    function deleteProject(id)
      {
        Swal.fire({
          title: 'Anda ingin mengarsipkan projek ini?',
          showCancelButton: true,
          confirmButtonText: `Arsipkan`,
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
        axios.post('{{route("project.delete")}}', formData)
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
        $('#member-project').on('hidden.bs.modal', function () {
          $("#member_project_id").val("");
          $("#member_project_name").html("");
              window.table.ajax.reload();
        });
      </script>
@endsection
