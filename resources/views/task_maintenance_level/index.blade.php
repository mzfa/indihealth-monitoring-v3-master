@extends('layouts/master_dashboard')
@section('title','Kelola Level Maintenance')
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
        <a href="#" title="Tambah Level" data-toggle="modal" data-target="#create-level"  class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Tambah Level</a>
        <hr>

        <form id="form-tambah-level">
         <div class="modal fade" id="create-level" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Tambah Level Maintenance</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <div class="col-md-6">
                                <label>Nama Level</label>
                                <input type="text" required="" placeholder="cth: Level 1" id="name" name="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Menit</label>
                                <input type="number" required="" placeholder="cth: 15" min="1" value="15" id="minutes" name="minutes" class="form-control">
                            </div>
                            <div class="col-12">
                                <label>Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
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

       <form id="form-edit-level">
         <div class="modal fade" id="edit-level" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Ubah data Level Maintenance</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <div class="col-md-6">
                              @csrf
                              <input type="hidden" name="id" id="id_level">
                                <label>Nama Level</label>
                                <input type="text" required="" placeholder="cth: Level 1" id="ubah_name" name="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Menit</label>
                                <input type="number" required="" placeholder="cth: 15" min="1" value="15" id="ubah_minutes" name="minutes" class="form-control">
                            </div>
                            <div class="col-12">
                                <label>Description</label>
                                <textarea class="form-control" id="ubah_description" name="description"></textarea>
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

    </div>
    <div class="col-12">
        <div class="table-responsive-sm">
            <table class="table  table-bordered table-hover" id="levelTable">
                <thead>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Minutes</th>
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
  
        $(function() {
               window.table = $('#levelTable').DataTable({
                                "order": [[ 2, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('task.maintenance.level.datatables')}}",
                                columns: [{
                                        data: 'name',
                                        name: 'name'
                                    },
                                    {
                                        data: 'description',
                                        name: 'description'
                                    },{
                                        data: 'minutes',
                                        name: 'minutes'
                                    },
                                     {
                                        data: 'aksi',
                                        name: 'aksi'
                                    },
                                ]
                            });
                        });
    function editLevel(id)
    {
        console.log(id);
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
        formData.append('id', id);
        axios.post('{{route("task.maintenance.level.show")}}', formData)
                .then(function (response) {
                $('#form-ubah-projek-modal').modal('show');
                $("#id_level").val(response.data.level.data.id)
                $("#ubah_name").val(response.data.level.data.name)
                $("#ubah_minutes").val(response.data.level.data.minutes)
                $("#ubah_description").val(response.data.level.data.description)
                
                $('#edit-level').modal('show');
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
    $("#form-edit-level").submit(function(e){
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-edit-level')[0];
        let formData = new FormData(form);
        axios.post('{{route("task.maintenance.level.update")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                
                $('#edit-level').modal('hide');
                $("[submit-button]").prop( "disabled", false );
                $("#ubah_name").val("")
                $("#ubah_minutes").val("")
                $("#ubah_description").val("")
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