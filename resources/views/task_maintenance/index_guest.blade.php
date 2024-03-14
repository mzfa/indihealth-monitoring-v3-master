@extends('layouts/master_dashboard')
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
    <div class="col-md-6">
        <div id="calendar">
            {!! Calendar::taskMTGenerate(date('m'),date('Y'))!!}
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
                        <th>
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




@endsection

@section('javascript')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
<script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>
<script type="text/javascript">
    $('.time').clockpicker({
        donetext: 'Selesai',
        autoclose: true
    }); @Permission(['superadmin'])
        $('.select-project-edit').select2({
            width: '100%',
            placeholder: "Pilih Projek",
            ajax: {
                delay: 250,
                url: '{{route("project.select")}}',
                dropdownParent: $("#tugas-edit"),
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
        }); @endPermission
        @Permission(['superadmin'])
        $('.select-project').select2({
            width: '100%',
            placeholder: "Pilih Projek",
            ajax: {
                delay: 250,
                url: '{{route("project.select")}}',
                dropdownParent: $("#tugas-baru"),
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
    $('.pilih-user').select2({
        width: '100%',
        placeholder: "Pilih Pengguna ",
        dropdownParent: $("#member-mt"),
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
    $('.select-ticket').select2({
        width: '100%',
        dropdownParent: $("#tugas-baru"),
        placeholder: "Pilih Ticket",
        ajax: {
            delay: 250,
            url: '{{route("ticketing.maintenance.select")}}',
            dataType: 'json',
            data: function(params) {
                var query = {
                    search: params.term,
                    project_id: $(".select-project").val(),
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    });
    $('.select-ticket-edit').select2({
        width: '100%',
        dropdownParent: $("#tugas-edit"),
        placeholder: "Pilih Ticket",
        ajax: {
            delay: 250,
            url: '{{route("ticketing.maintenance.select")}}',
            dataType: 'json',
            data: function(params) {
                var query = {
                    search: params.term,
                    project_id: $(".select-project-edit").val(),
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    });
    $('.select-project').change(function() {
        $('.select-ticket').prop('disabled', false);
        $(".select-ticket").empty().trigger('change')
    });
    $('.select-level').select2({
        width: '100%',
        ajax: {
            delay: 250,
            dropdownParent: $("#tugas-baru"),
            url: '{{route("task.maintenance.level.select")}}',
            dataType: 'json',
            data: function(params) {
                var query = {
                    search: params.term,
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    }); @endPermission
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
                ajax: "{{ route('task.maintenance.datatables')}}",
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
                "url": "{{ route('task.maintenance.datatables')}}?start_date=" + $("#start_date-filter").val() + "&end_date=" + $("#end_date-filter").val() + "&progress=" + $("#progress-filter").val(),
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
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]
        });
    });

    $('#test').click(function() {
        window.table.ajax.reload();
    });

    $('#form-task').submit(function(e) {
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop("disabled", true);
        let form = $('#form-task')[0];
        let formData = new FormData(form);
        axios.post('{{route("task.maintenance.save")}}', formData)
            .then(function(response) {

                window.table.ajax.reload();
                $('#tugas-baru').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop("disabled", false);
                $("#task_name_new").val("")
                $("#start_date_new").val("")
                $("#start_time_new").val("")
                $("#process_new").val("")
                $("#kesulitan_new").val("")
                $("#solusi_new").val("")
                $("#selesai_new").checked(false)
                $("#calendar").load(location.href + " #calendar");
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
    $('.select-level').change(function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('id', $(this).val());
        axios.post('{{route("task.maintenance.level.description")}}', formData)
            .then(function(response) {
                $('[name="start_time"]').val("")
                $('.level_description').hide();
                $('.level_description').fadeIn();
                $('.level_description').html(response.data.level.data.description);
                $('.timing').val(response.data.level.data.minutes)
            })
            .catch(function(error) {

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
    $('.calc_time_new').change(function(e) {
        e.preventDefault();
        let formData = new FormData();
        $('.calc-loading').fadeIn('fast')
        formData.append('start_date', $('#start_date_new').val());
        formData.append('start_time', $('#start_time_new').val());
        formData.append('timing', $('#timing').val());
        axios.post('{{route("task.maintenance.calctime")}}', formData)
            .then(function(response) {
                $('.calc-loading').fadeOut('fast')
                $('#end_date_new').val(response.data.taskMT.date);
                $('#end_time_new').val(response.data.taskMT.time);

            })
            .catch(function(error) {

                $('.calc-loading').fadeOut('fast')
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
    $('.calc_time_edit').change(function(e) {
        e.preventDefault();
        let formData = new FormData();
        $('.calc-loading').fadeIn('fast')
        formData.append('start_date', $('#start_date_edit').val());
        formData.append('start_time', $('#start_time_edit').val());
        formData.append('timing', $('#timing_edit').val());
        axios.post('{{route("task.maintenance.calctime")}}', formData)
            .then(function(response) {
                $('.calc-loading').fadeOut('fast')
                $('#end_date_edit').val(response.data.taskMT.date);
                $('#end_time_edit').val(response.data.taskMT.time);

            })
            .catch(function(error) {

                $('.calc-loading').fadeOut('fast')
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
    $('#form-task-edit').submit(function(e) {
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop("disabled", true);
        let form = $('#form-task-edit')[0];
        let formData = new FormData(form);
        axios.post('{{route("task.maintenance.update")}}', formData)
            .then(function(response) {
                $('#tugas-edit').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop("disabled", false);
                $("#calendar").load(location.href + " #calendar");
                window.table.ajax.reload();
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
    $('#form-member').submit(function(e) {
        e.preventDefault();
        $("[spinner]").show();
        $("[submit-button]").prop("disabled", true);
        let form = $('#form-member')[0];
        let formData = new FormData(form);
        axios.post('{{route("task.maintenance.member.save")}}', formData)
            .then(function(response) {
                $('#edit-task').modal('hide');
                $("[spinner]").hide();
                $("[submit-button]").prop("disabled", false);
                $("#calendar").load(location.href + " #calendar");
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
                "url": "{{ route('task.maintenance.datatables')}}?start_date=" + $("#tanggal_select").val() + "&end_date=" + $("#tanggal_select").val(),
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
                {
                    data: 'aksi',
                    name: 'aksi'
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

    function editTask(id) {
        // alert("ok");
        let formData = new FormData();
        $("#icon-" + id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
        formData.append('id', id);
        axios.post('{{route("task.maintenance.show")}}', formData)
            .then(function(response) {
                // $("#task_name_edit").val(response.data.task.data.task_name)
                window.process_new_slider.data('ionRangeSlider').update({
                    from: response.data.taskMT.data.process
                });
                $("#task_mt_id").val(response.data.taskMT.data.id)
                $("#task_name_edit").val(response.data.taskMT.data.task_name)
                $("#start_date_edit").val(response.data.taskMT.data.start_date)
                $("#start_time_edit").val(response.data.taskMT.data.start_time)
                $("#start_time_edit").val(response.data.taskMT.data.start_time)
                $("#end_date_edit").val(response.data.taskMT.data.end_date)
                $("#end_time_edit").val(response.data.taskMT.data.end_time)
                $(".process-edit").val(response.data.taskMT.data.process)
                $(".timing").val(response.data.taskMT.data.timing)
                $("#kesulitan_edit").val(response.data.taskMT.data.kesulitan)
                $("#solusi_edit").val(response.data.taskMT.data.solusi)
                $("#project_id_edit").append(new Option(response.data.taskMT.data.project_name, response.data.taskMT.data.project_id));
                $("#task_maintenance_level_id_edit").append(new Option(response.data.taskMT.data.level_name, response.data.taskMT.data.level_id));
                $("#ticketing_id_edit").append(new Option(response.data.taskMT.data.ticketing_name, response.data.taskMT.data.ticketing_id));
                if (response.data.taskMT.data.solusi != null) {
                    $("#hidden-done-edit").show();
                }
                $('#tugas-edit').modal('show');
                $("#icon-" + id).addClass('fa-pencil-alt').removeClass('fa-spinner fa-spin');

            })
            .catch(function(error) {
                $("#icon-" + id).addClass('fa-pencil-alt').removeClass('fa-spinner fa-spin');

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

    function deleteTask(id) {
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
                        }, @Permission(['superadmin'])  {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi'
                        },
                        @endPermission
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

    function unlinkMember(id) {
        Swal.fire({
            title: 'Anda ingin menghapus member ini?',
            showCancelButton: true,
            confirmButtonText: `Hapus`,
        }).then((result) => {
            if (result.isConfirmed) {
                unlinkMemberAct(id);
            }
        })
    }

    function unlinkMemberAct(id) {
        // alert("ok");
        let formData = new FormData();
        formData.append('id', id);
        axios.post('{{route("task.maintenance.member.delete")}}', formData)
            .then(function(response) {

                window.tbMember.ajax.reload();
            })
            .catch(function(error) {

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
                "url": "{{ route('task.maintenance.datatables')}}?start_date=" + date + "&end_date=" + date,
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
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]
        });
    }

    function deleteAct(id) {
        // alert("ok");
        let formData = new FormData();
        formData.append('id', id);
        axios.post('{{route("task.maintenance.delete")}}', formData)
            .then(function(response) {

                window.table.ajax.reload();
            })
            .catch(function(error) {

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

    function changeStatus(target, value) {
        if (value >= 100) {
            $(target).slideDown();
        } else {
            $(target).slideUp();
        }
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
