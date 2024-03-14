@extends('layouts/master_dashboard_guest')
@section('title','Status Pengajuan Maintenance')
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


    <div class="col-12">
        
          <form id="form-feedback">
         <div class="modal fade" id="form-feedback-modal" -modaltabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Kirim Feedback untuk maintenance ini</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                  @csrf
                      <input type="hidden" id="ticket_id" name="id">
                        <label>Feedback</label>
                        <textarea name="feedback" id="feedback" class="form-control"  placeholder="Berikan masukan anda..."></textarea>
                </div>
                         <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" submit-button><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Kirim Feedback</button>
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </div>
               
               
              </div>
            </div>
          </div>
      </form>
      <div class="table-responsive">
            <table class="table  table-bordered table-hover" id="ticketingTable">
                <thead>
                    <th>Waktu Pengajuan</th>
                    <th>No Ticket</th>
                    <th>Judul</th>
                    <th>Orang ditujukan</th>
                    <th>Yang ditujukan</th>
                    <th>Projek</th>
                    <th>Status</th>
                    <th>Proses Pengerjaan</th>
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
               window.table = $('#ticketingTable').DataTable({
                                "order": [[ 2, "asc" ]],
                                processing: true,
                                serverSide: true,
                                autoWidth:false,
                                "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
              },
                                ajax: "{{ route('guest.ticketing.datatables')}}",
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
                                        data: 'target_user',
                                        name: 'target_user'
                                    },
                                    {
                                        data: 'division',
                                        name: 'division'
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
                                        data: 'progress',
                                        name: 'progress'
                                    },
                                     {
                                        data: 'aksi',
                                        name: 'aksi'
                                    },
                                ]
                            });
                        });
   function sendFeedback(id)
   {
        console.log(id);
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-comment');
        formData.append('id', id);
        axios.post('{{route("guest.check.ticketdone")}}', formData)
                .then(function (response) {
                  console.log(response.data)
                  $("#ticket_id").val(response.data.MTTicket.id)
                $('#form-feedback-modal').modal('show');
                
                $("#icon-"+id).addClass('fa-comment').removeClass('fa-spinner fa-spin');
              })
              .catch(function (error) {
                $("#icon-"+id).addClass('fa-comment').removeClass('fa-spinner fa-spin');

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

   $('#form-feedback').submit(function(e){
    e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop( "disabled", true );
        let form = $('#form-feedback')[0];
        let formData = new FormData(form);
        axios.post('{{route("guest.ticketing.sendFeedback")}}', formData)
                .then(function (response) {
                $("[spinner]").hide();
                $("[submit-button]").prop( "disabled", false );
                $("#ticket_id").val("")
                $("#feedback").val("")
                $('#form-feedback-modal').modal('hide');
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
@endsection
