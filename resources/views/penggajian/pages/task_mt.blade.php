@extends('layouts/master_dashboard_guest')
@section('title','Lihat Tugas Maintenance')
@section('content')
<style type="text/css">

</style>

<div class="row">
    <div class="col-md-6">
        <div class="row">
           
            <div class="col-md-6 col-sm-12">
                <button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#pilih-tanggal"><i class="fas fa-calendar"></i> Pilih Tanggal</button>
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
                                <div class="modal-body">
                                    <div class="row">
                                        @csrf

                                        <div class="col-md-12 col-sm-12">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal_select" id="tanggal_select" value="{{date('Y-m-d')}}" required="" class="form-control">
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" submit-button class="btn btn-primary btn-block"><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tampilkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-12">
                {{-- <a  adv-filter href="#" class="btn btn-outline-primary btn-sm mt-2" position="0">Filter Lanjutan <i chevron class="fa fa-chevron-down" aria-hidden="true"></i>
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
                                <input type="date" value="{{date("Y-m-d")}}" id="end_date-filter" name="end_date" class="form-control">
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
    
</div>
<div class="row">


    <div class="col-12">
        <hr>
        <div class="table-responsive">
            <table id="task-table" class="table table-striped projects">
                <thead>
                    <tr>

                        <th>
                            Kasus
                        </th>
                        <th>
                            Ticket
                        </th>
                        <th>
                            Tanggal Ticketing
                        </th>
                        <th>
                            Member
                        </th>
                        <th>
                            Timing
                        </th>

                        <th>
                            Progress Tugas
                        </th>
                        <th>
                            Status
                        </th>
                    </tr>
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
<link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
<script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>
<script type="text/javascript">
  
        $(function() {

            window.table = $('#task-table').DataTable({
                "order": [
                    [2, "asc"]
                ],
                processing: true,
                serverSide: true,
                autoWidth: false,
                "language": {
                    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                },
                ajax: "{{ route('guest.taskMT.datatables',['id' => $linked->project_id])}}",
                columns: [{
                        data: 'task_name',
                        name: 'task_name'
                    }, {
                        data: 'ticket',
                        name: 'ticket'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'member',
                        name: 'member'
                    },
                    {
                        data: 'timing',
                        name: 'timing'
                    }, {
                        data: 'progress_task',
                        name: 'progress_task'
                    }, {
                        data: 'status',
                        name: 'status'
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
            })
            window.process_new_slider = $('#process_edit').ionRangeSlider({
                min: 0,
                max: 100,
                type: 'single',
                color: 'blue',
                step: 1,
                postfix: '%',
                prettify: true,
                hasGrid: true
            })
        });

    $('#form-filter').submit(function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('start_date', $("#start_date-filter").val());
        formData.append('end_date', $("#end_date-filter").val());
        formData.append('progress', $("#progress-filter").val());
        $("#task-table").dataTable().fnDestroy()
        $('#task-table').DataTable({
            "order": [
                [2, "asc"]
            ],
            processing: true,
            serverSide: true,
            autoWidth: false,
            "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
            },
            ajax: {
                "url": "{{ route('guest.taskMT.datatables',['id' => $linked->project_id])}}?start_date=" + $("#start_date-filter").val() + "&end_date=" + $("#end_date-filter").val() + "&progress=" + $("#progress-filter").val(),
                "type": "GET",
            },
            columns: [{
                    data: 'task_name',
                    name: 'task_name'
                }, {
                    data: 'ticket',
                    name: 'ticket'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'member',
                    name: 'member'
                },
                {
                    data: 'timing',
                    name: 'timing'
                }, {
                    data: 'progress_task',
                    name: 'progress_task'
                }, {
                    data: 'status',
                    name: 'status'
                },
                
            ]
        });
    });

 
    $('#form-task-select-tanggal').submit(function(e) {
        e.preventDefault();
        let formData = new FormData();
        $("#pilih-tanggal").modal('hide')
        formData.append('start_date', $("#start_date-filter").val());
        formData.append('end_date', $("#end_date-filter").val());
        formData.append('progress', $("#progress-filter").val());
        $("#task-table").dataTable().fnDestroy()
        $('#task-table').DataTable({
            "order": [
                [2, "asc"]
            ],
            processing: true,
            serverSide: true,
            autoWidth: false,
            "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
            },
            ajax: {
                "url": "{{ route('guest.taskMT.datatables',['id' => $linked->project_id])}}?start_date=" + $("#tanggal_select").val() + "&end_date=" + $("#tanggal_select").val(),
                "type": "GET",
            },
            columns: [{
                    data: 'task_name',
                    name: 'task_name'
                }, {
                    data: 'ticket',
                    name: 'ticket'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'member',
                    name: 'member'
                },
                {
                    data: 'timing',
                    name: 'timing'
                }, {
                    data: 'progress_task',
                    name: 'progress_task'
                }, {
                    data: 'status',
                    name: 'status'
                },
                
            ]
        });
    })

    $("[adv-filter]").click(function(e) {
        e.preventDefault();
        console.log($(this).prop('position'));
        if ($(this).prop('position') == 0 || $(this).prop('position') == null) {
            $("[chevron]").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            $("#show-filter").slideDown();
            $(this).prop('position', 1);
        } else {
            $("[chevron]").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            $("#show-filter").slideUp();
            $(this).prop('position', 0);
        }
    });


    function memberList(id) {
        let formData = new FormData();
        formData.append('id', id);
        $("#table-member").dataTable().fnDestroy()
        $("#memberList-" + id).addClass('fa-spinner fa-spin').removeClass('fa-users');
        axios.post('{{route("task.maintenance.show")}}', formData)
            .then(function(response) {
                $("#memberList-" + id).addClass('fa-users').removeClass('fa-spinner fa-spin');
                $('#member-mt').modal('show');
                $('#mt-id').val(response.data.taskMT.data.id)
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

                    ajax: "{{ route('task.maintenance.member.datatables')}}?task_mt_id=" + id,
                    columns: [{
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        }, {
                            data: 'jabatan',
                            name: 'jabatan'
                        },{
                            data: 'tugas_individu',
                            name: 'tugas_individu'
                        },
                    ]
                });
            })
            .catch(function(error) {
                $("#memberList-" + id).addClass('fa-users').removeClass('fa-spinner fa-spin');

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

   
    function findDate(date) {
        $("#task-table").dataTable().fnDestroy()
        $('#task-table').DataTable({
            "order": [
                [2, "asc"]
            ],
            processing: true,
            serverSide: true,
            autoWidth: false,
            "language": {
                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
            },
            ajax: {
                "url": "{{ route('guest.taskMT.datatables',['id' => $linked->project_id])}}?start_date=" + date + "&end_date=" + date,
                "type": "GET",
            },
            columns: [{
                    data: 'task_name',
                    name: 'task_name'
                }, {
                    data: 'ticket',
                    name: 'ticket'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'member',
                    name: 'member'
                },
                {
                    data: 'timing',
                    name: 'timing'
                }, {
                    data: 'progress_task',
                    name: 'progress_task'
                }, {
                    data: 'status',
                    name: 'status'
                },
                
            ]
        });
    }

 function showTicket(id)
    {
        console.log(id);
        let formData = new FormData();
        $("#ticket-"+id).show();
        formData.append('id', id);
        axios.post('{{route("ticketing.maintenance.showData")}}', formData)
                .then(function (response) {
                $('#detail-ticket').modal('show');
                $("#task_id").val(response.data.MTTicket.data.id)
                $("#status").html(response.data.MTTicket.data.status)
                $("#client").html(response.data.MTTicket.data.client)
                $("#waktu").html(response.data.MTTicket.data.created_at)
                $("#no_ticket").html(response.data.MTTicket.data.no_tiket)
                // $("#status").html(response.data.MTTicket.data.status)
                $("#project").html(response.data.MTTicket.data.project)
                $("#judul").html(response.data.MTTicket.data.judul)
                $("#kronologi").html(response.data.MTTicket.data.kronologi)
                $("#img").prop('src',response.data.MTTicket.data.img)
                $("#img-zoom").prop('href',response.data.MTTicket.data.img)
                $("#sites").html(response.data.MTTicket.data.alamat_situs)
                $("#sites").prop('href',response.data.MTTicket.data.alamat_situs)
                $("#ticket-"+id).hide();
              })
              .catch(function (error) {
                $("#ticket-"+id).hide();

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
