@extends('layouts/master_dashboard')
@section('title','Kelola Akun Guest')
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
        <a href="#mk_guest" title="Tambah Guest" data-toggle="modal" data-target="#create-guest"  class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Tambah Guest</a>
        <hr>
        <form id="form-tambah-guest">
         <div class="modal fade" id="create-guest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Tambah Guest Baru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <div class="col-md-6">
                                <label>Nama Guest</label>
                                <input type="text" required="" id="create_name" placeholder="cth: Suzuka Gozen" name="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Nama Perusahaan</label>
                                <input type="text" required="" id="create_nama_perusahaan" placeholder="cth: PT XYZ ABC" name="nama_perusahaan" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Jabatan</label>
                                <input type="text" required="" placeholder="cth: IT Manager" id="create_jabatan" name="jabatan" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Username</label>
                                <input type="text" required="" placeholder="cth: budisetiawan123" id="create_username" name="username" class="form-control">
                            </div> 
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" required="" id="create_email"  placeholder="cth: gozen123@xyz.com" name="email" class="form-control">
                              </div> 
                            <div class="col-md-6">
                                <label>No Hp / Telp</label>
                                <input type="text" placeholder="cth: 022-3023431"   id="create_no_telp" name="no_telp" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="password" required="" placeholder="Kata sandi" id="create_password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Password Konfirmasi</label>
                                <input type="password" required="" placeholder="Kata sandi Konfirmasi" id="create_password_confirm" name="password_confirmation" class="form-control">
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
<form id="form-edit-guest">
         <div class="modal fade" id="edit-guest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Ubah data guest </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <div class="col-md-6">
                              @csrf
                              <input type="hidden" name="id" id="id_guest">
                                <label>Nama Guest</label>
                                <input type="text" required="" id="edit_name" placeholder="cth: Suzuka Gozen" name="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Nama Perusahaan</label>
                                <input type="text" required="" id="edit_nama_perusahaan" placeholder="cth: PT XYZ ABC" name="nama_perusahaan" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Jabatan</label>
                                <input type="text" required="" placeholder="cth: IT Manager" id="edit_jabatan" name="jabatan" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Username</label>
                                <input type="text" required="" placeholder="cth: budisetiawan123" id="edit_username" name="username" class="form-control">
                            </div> 
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" required="" id="edit_email"  placeholder="cth: gozen123@xyz.com" name="email" class="form-control">
                              </div> 
                            <div class="col-md-6">
                                <label>No Hp / Telp</label>
                                <input type="text" placeholder="cth: 022-3023431"   id="edit_no_telp" name="no_telp" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="password"  placeholder="Kata sandi" id="edit_password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Password Konfirmasi</label>
                                <input type="password"  placeholder="Kata sandi Konfirmasi" id="edit_password_confirm" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                </div>
               
                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" submit-button-project><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
      </form>

         <div class="modal fade" id="add-project-guest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Kaitkan Project ke akun <span id="guest_name"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         
                              <div class="callout callout-info">
                              Dengan dikaitkannya akun  ini ke project maka guest tersebut dapat melihat Task Development, Task Maintenance, dan Notulensi sesuai dengan project yang ditambahkan di sini.
                              </div>
                              <form id="form-add-project">
                                <div class="row">
                                <div class="col-md-6 col-sm-12">
                                  @csrf
                                  <input type="hidden" id="guest_id" name="guest_id">
                                    <label>Projek</label><br>
                                     <select name="project_id" class="select-project form-control">
 
                                      </select>
                                     
                                  </div>

                                  
                                  </div> 
                                  <div class="row">
                                    <div class="col-md-6">
                                      <label>Apa saja yang akan di-share?</label><br>
                                    <input type="checkbox" value="true" class="" name="shareable_task_dev" id="shareTaskDev">
                                        <label class="form-check-label"  for="shareTaskDev">Task Development</label> 
                          

                                        {{-- <input type="checkbox"  class="ml-3"value="true" name="shareable_task_mt" id="shareTaskMT">
                                        <label class="form-check-label" for="shareTaskMT">Task Maintenance</label> --}}
                                  
                                    
                                        <input type="checkbox"  checked="" class="ml-3" value="true" name="shareable_notulensi" id="shareNotulensi">
                                        <label class="form-check-label" for="shareNotulensi">Notulensi</label>
                                  </div> 
                                  </div>
                                      <hr>
                                  <div class="row">
                                  <div class="col-md-6 col-sm-12">
                                   <button class="btn btn-primary btn-block"><i class="fas fa-plus mr-2" spinner-project></i> Tambahkan</button>
                                  </div>
                                </div>
                              </form>
                              <hr>
                              <div class="callout callout-info">
                              Keterangan:
                              <ul>
                                <li>
                                    DEV : Task Development
                                </li>
                                {{-- <li>
                                    MT : Task Maintenance
                                </li> --}}
                                <li>
                                    N : Notulensi
                                </li>
                              </ul>
                              <span class="badge badge-success">Berbagi Aktif</span>
                              <span class="badge badge-secondary">Berbagi Non-aktif</span>
                              </div>
                              <div class="table-responsive">
                              <table class="table  table-bordered table-hover" id="projectTable">
                                <thead>
                                      <th>Nama Project</th>
                                      <th>Client</th>
                                      <th>Tanggal Mulai</th>
                                      <th>Deadline</th>
                                      <th>Share Link</th>
                                      <th>Aksi</th>
                                  </thead>
                                  <tbody>
                                      
                                  </tbody>
                              </table>
                            </div>
                          
                        </div>
           
               
                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" submit-button><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table  table-bordered table-hover" id="guestTable">
                <thead>
                    <th>Online</th>
                    <th>Status</th>
                    <th>Nama</th>
                    <th>Nama Perusahaan</th>
                    <th>Jabatan</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No Telp / HP</th>
                    <th>Projek Terhubung</th>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$('.select-project').select2({
  width: '100%',
   // tags: true,
  dropdownParent: $("#add-project-guest"),
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
               window.table = $('#guestTable').DataTable({
                                "order": [[ 2, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('guest.datatables')}}",
                                columns: [
                                  {
                                        data: 'online',
                                        name: 'online'
                                    },
                                  {
                                        data: 'status',
                                        name: 'status'
                                    },
                                  {
                                        data: 'name',
                                        name: 'name'
                                    },
                                    {
                                        data: 'nama_perusahaan',
                                        name: 'nama_perusahaan'
                                    },{
                                        data: 'jabatan',
                                        name: 'jabatan'
                                    },{
                                        data: 'username',
                                        name: 'username'
                                    },
                                    {
                                        data: 'email',
                                        name: 'email'
                                    },
                                    {
                                        data: 'no_telp',
                                        name: 'no_telp'
                                    },
                                    {
                                        data: 'projek_terhubung',
                                        name: 'projek_terhubung'
                                    },
                                     {
                                        data: 'aksi',
                                        name: 'aksi'
                                    },
                                ]
                            });
                        });
    function editGuest(id)
    {
        console.log(id);
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
        formData.append('id', id);
        axios.post('{{route("guest.show")}}', formData)
                .then(function (response) {
                $('#edit-guest').modal('show');
                $("#id_guest").val(response.data.guest.data.id)
                $("#edit_name").val(response.data.guest.data.name)
                $("#edit_nama_perusahaan").val(response.data.guest.data.nama_perusahaan)
                $("#edit_jabatan").val(response.data.guest.data.jabatan)
                $("#edit_username").val(response.data.guest.data.username)
                $("#edit_email").val(response.data.guest.data.email)
                $("#edit_no_telp").val(response.data.guest.data.no_telp)
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

    function addProject(id)
    {
        console.log(id);
        let formData = new FormData();
         $("#projectTable").dataTable().fnDestroy()
         $("#link-project-"+id).prop('disabled',true)
        $("#icon-project-"+id).addClass('fa-spinner fa-spin').removeClass('fa-project-alt');
        formData.append('id', id);
        axios.post('{{route("guest.show")}}', formData)
                .then(function (response) {
                $("#link-project-"+id).prop('disabled',false)
                $('#guest_id').val(response.data.guest.data.id)
                $('#guest_name').text(response.data.guest.data.name)
                $('#add-project-guest').modal('show');
              window.tb_project  = $('#projectTable').DataTable({
                                "order": [[ 2, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('linkedProject.datatables')}}?guest_id="+id,
                                columns: [{
                                        data: 'project_name',
                                        name: 'project_name'
                                    }, 
                                    {
                                        data: 'project_client',
                                        name: 'project_client'
                                    },{
                                        data: 'tanggal',
                                        name: 'tanggal'
                                    },{
                                        data: 'deadline',
                                        name: 'deadline'
                                    },{
                                        data: 'link',
                                        name: 'link'
                                    },
                                     {
                                        data: 'aksi',
                                        name: 'aksi'
                                    },
                                ]
                            });
                // $("#id_guest").val(response.data.guest.data.id)
                // $("#edit_name").val(response.data.guest.data.name)
                // $("#edit_nama_perusahaan").val(response.data.guest.data.nama_perusahaan)
                // $("#edit_jabatan").val(response.data.guest.data.jabatan)
                // $("#edit_username").val(response.data.guest.data.username)
                // $("#edit_email").val(response.data.guest.data.email)
                // $("#edit_no_telp").val(response.data.guest.data.no_telp)
                $("#icon-project-"+id).addClass('fa-project-alt').removeClass('fa-spinner fa-spin');
              })
              .catch(function (error) {
                $("#link-project-"+id).prop('disabled',false)
                $("#icon-project-"+id).addClass('fa-project-alt').removeClass('fa-spinner fa-spin');
               
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
    $("#form-add-project").submit(function(e){
        e.preventDefault();
        $("[spinner-project]").addClass('fa-spinner fa-spin').removeClass('fa-plus');
        $("[submit-button-project]").prop( "disabled", true );
        let form = $('#form-add-project')[0];
        let formData = new FormData(form);
        axios.post('{{route("linkedProject.save")}}', formData)
                .then(function (response) {
                $("[spinner-project]").addClass('fa-plus').removeClass('fa-spinner fa-spin');
                $("[submit-button-project]").prop( "disabled", false );
                window.tb_project.ajax.reload();
              })
              .catch(function (error) {
              $("[spinner-project]").addClass('fa-plus').removeClass('fa-spinner fa-spin');
               $("[submit-button-project]").prop( "disabled", false );
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

    $("#form-tambah-guest").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-tambah-guest')[0];
        let formData = new FormData(form);
        axios.post('{{route("guest.save")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#create_name").val("")
                $("#create_nama_perusahaan").val("")
                $("#create_jabatan").val("")
                $("#create_username").val("")
                $("#create_email").val("")
                $("#create_no_telp").val("")
                $("#create_password").val("")
                $("#create_password_confirm").val("")
                $('#create-guest').modal('hide');
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
    $("#form-edit-guest").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-edit-guest')[0];
        let formData = new FormData(form);
        axios.post('{{route("guest.update")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                
                $('#edit-guest').modal('hide');
                $("[submit-button]").prop( "disabled", false );
                 $("#id_guest").val("")
                $("#edit_name").val("")
                $("#edit_nama_perusahaan").val("")
                $("#edit_jabatan").val("")
                $("#edit_username").val("")
                $("#edit_email").val("")
                $("#edit_no_telp").val("")
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

    function disableGuest(id)
      {
        Swal.fire({
          title: 'Anda ingin menonaktifkan guest ini?',
          text: "Pengguna ini tidak dapat memasuki sistem dan akan terlogout otomatis jika telah login.",
          showCancelButton: true,
          confirmButtonText: `Non-aktifkan`,

          confirmButtonColor: '#d33',
        }).then((result) => {
          if (result.isConfirmed) {
            disableAct(id);
          }
        })
      }
    function disableAct(id){
        // alert("ok");
        let formData = new FormData();
        formData.append('id', id);
        axios.post('{{route("guest.disable")}}', formData)
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
      function enableGuest(id)
      {
        Swal.fire({
          title: 'Anda ingin mengaktifkan guest ini?',
          text: "Pengguna ini dapat memasuki sistem lagi.",
          showCancelButton: true,
          confirmButtonText: `Aktifkan`,
        }).then((result) => {
          if (result.isConfirmed) {
            enableAct(id);
          }
        })
      }
    function enableAct(id){
        // alert("ok");
        let formData = new FormData();
        formData.append('id', id);
        axios.post('{{route("guest.enable")}}', formData)
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

      function deleteProject(id)
      {
        Swal.fire({
          title: 'Anda ingin memutus projek yang terhubung pada pengguna ini?',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          text: "Pengguna tidak dapat melihat task development dan task maintenance projek ini.",
          confirmButtonText: `Putuskan`,
        }).then((result) => {
          if (result.isConfirmed) {
            deleteProjectAct(id);
          }
        })
      }
      function deleteProjectAct(id){
        // alert("ok");
        let formData = new FormData();
        formData.append('id', id);
        $("#project-"+id).addClass('fa-spinner fa-spin').removeClass('fa-unlink');
        axios.post('{{route("linkedProject.delete")}}', formData)
                .then(function (response) {
                  $("#project-"+id).addClass('fa-unlink').removeClass('fa-spinner fa-spin');
                window.tb_project.ajax.reload();
              })
              .catch(function (error) {
                $("#project-"+id).addClass('fa-unlink').removeClass('fa-spinner fa-spin');
               
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
function copyLink(id) {
  /* Get the text field */
  var copyText = document.getElementById(id);

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
   Swal.fire({
                    title: 'Link telah dicopy!',
                    text: copyText.value,
                    icon: 'success',
                    confirmButtonText: 'OK'
                  })
} 
      </script>
@endsection