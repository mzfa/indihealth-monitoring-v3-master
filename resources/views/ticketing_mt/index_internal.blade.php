@extends('layouts/master_dashboard')
@section('title','Kelola Pengajuan Maintenance')
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
     <form id="form-ubah-status">
         <div class="modal fade" id="form-ubah-status-modal" -modaltabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Detail Ticket</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <input type="hidden" name="id" id="id_projek">
                            <div class="col-md-6">
                                <label>Email</label><br>
                                <a href="#" id="email"></a>
                            </div> 
                            <div class="col-md-6">
                                <label>No Telepon / Ponsel</label><br>
                                <a href="#"id="no_telp"></a>
                            </div> 
                            <div class="col-md-6">
                                <label>Status</label><br>
                                <span id="status"></span>
                            </div> 
                              <div class="col-md-6">
                                <label>Nomor Tiket</label><br>
                                <span id="no_ticket"></span><br>
                                <span id="waktu"></span>
                            </div> 
                          <div class="col-md-6">
                                <label>URL</label><br>
                               <a target="_blank" id="sites"></a>
                            </div>  
                            <div class="col-md-6">
                                <label>Client - Nama Perusahaan</label><br>
                                <span id="client"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Divisi yang ditujukan</label><br>
                                <span id="division"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Orang yang ditujukan</label><br>
                                <span id="orang"></span>
                            </div>
                            <div class="col-md-12">
                                <label>Projek</label><br>
                                <span id="project"></span>
                            </div>
                            <div class="col-md-12">
                                <label>Judul</label><br>
                                 <span id="judul"></span>
                            </div>
                            <div class="col-md-12">
                                <label>Kronologi</label><br>
                                <p id="kronologi" style=" text-align: justify; text-justify: inter-word;"></p>
                            </div> 
                            <div class="col-md-12">
                                <label>Gambar</label><br>
                                <a href="" target="_blank" id="img-zoom">
                                  <img src="" id="img" width="200px">
                                </a>
                            </div>
                            <div class="col-md-12">
                              <hr>
                              @csrf
                              <input type="hidden" name="id" id="task_id">
                                <label>Ubah Status</label>
                                <select name="status" id="status_ticket" class="form-control">
                                  <option value="UNDER-INVESTIGATION">UNDER-INVESTIGATION</option>
                                  <option value="FIXING">FIXING</option>
                                  <option value="DONE">DONE</option>
                                </select>
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
          </div>
      </form>

    <div class="col-12">
        <div class="table-responsive-sm">
            <table class="table  table-bordered table-hover" id="ticketingTable">
                <thead>
                    <th>Waktu Pengajuan</th>
                    <th>No Ticket</th>
                    <th>Judul</th>
                    <th>Yang mengajukan</th>
                    <th>Projek</th>
                    <th>Status</th>
                    <th>Aksi</th>
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
          @if(!empty(Request::get('mtarget')))
            ubahStatus({{Request::get('mtarget')}})
            @endif
               window.table = $('#ticketingTable').DataTable({
                                "order": [[ 2, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('ticketing.maintenance.datatables')}}",
                                columns: [{
                                        data: 'created_at',
                                        name: 'created_at'
                                    },
                                    {
                                        data: 'no_ticket',
                                        name: 'no_ticket'
                                    },
                                    {
                                        data: 'title',
                                        name: 'title'
                                    },
                                    {
                                        data: 'yg_mengajukan',
                                        name: 'yg_mengajukan'
                                    },
                                    {
                                        data: 'project',
                                        name: 'project'
                                    },
                                    {
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
    function ubahStatus(id)
    {
        console.log(id);
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
        formData.append('id', id);
        axios.post('{{route("ticketing.maintenance.showData")}}', formData)
                .then(function (response) {
                $('#form-ubah-status-modal').modal('show');
                $("#task_id").val(response.data.MTTicket.data.id)
                $("#status").html(response.data.MTTicket.data.status)
                $("#sites").html(response.data.MTTicket.data.alamat_situs)
                $("#client").html(response.data.MTTicket.data.client)
                $("#waktu").html(response.data.MTTicket.data.created_at)
                $("#division").html(response.data.MTTicket.data.division)
                $("#orang").html(response.data.MTTicket.data.orang)
                $("#no_telp").html(response.data.MTTicket.data.no_telp)
                $("#no_telp").prop('href',"tel:"+response.data.MTTicket.data.no_telp)
                $("#email").html(response.data.MTTicket.data.email)
                $("#email").prop('href',"mailto:"+response.data.MTTicket.data.email)
                $("#no_ticket").html(response.data.MTTicket.data.no_tiket)
                // $("#status").html(response.data.MTTicket.data.status)
                $("#project").html(response.data.MTTicket.data.project)
                $("#judul").html(response.data.MTTicket.data.judul)
                $("#kronologi").html(response.data.MTTicket.data.kronologi)
                $("#img").prop('src',response.data.MTTicket.data.img)
                $("#img-zoom").prop('href',response.data.MTTicket.data.img)
                $("#sites").prop('href',response.data.MTTicket.data.alamat_situs)
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
    $("#form-tambah-level").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-tambah-level')[0];
        let formData = new FormData(form);
        axios.post('{{route("task.maintenance.level.save")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#name").val("")
                $("#minutes").val("")
                $("#description").val("")
                $('#create-level').modal('hide');
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
    $("#form-ubah-status").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-ubah-status')[0];
        let formData = new FormData(form);
        axios.post('{{route("ticketing.maintenance.update")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                $('#form-ubah-status-modal').modal('hide');
              $("[submit-button]").prop( "disabled", false );
                window.table.ajax.reload();
                if($('#status_ticket').val() == "FIXING")
                {
                  window.location = '{{route('task.maintenance')}}?create=true'
                }
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

    function deleteLevel(id)
      {
        Swal.fire({
          title: 'Anda ingin mengarsipkan level ini?',
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
        axios.post('{{route("task.maintenance.level.delete")}}', formData)
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

      </script>
@endsection
