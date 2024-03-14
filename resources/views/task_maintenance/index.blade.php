@extends('layouts/master_dashboard')
@section('title','Kelola Tugas Maintenance')
@section('content')
<style type="text/css">

</style>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            @Permission(['superadmin'])
            <div class="col-md-6 col-sm-12">
                <button class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#tugas-baru"><i class="fas fa-plus"></i> Maintenance Baru</button>
            </div>


            <form id="form-task">
                <div class="modal fade" id="tugas-baru" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tugas Maintenance Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger level_description" style="display: none" align="center"></div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        @csrf
                                        <label>Nama Tugas</label>
                                        <input type="text" id="task_name_new" name="task_name" placeholder="Contoh: Membuat modul absensi" required="" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Projek</label><br>
                                        <select name="project_id" class="select-project form-control"></select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Level Maintenance</label><br>
                                        <select name="task_maintenance_level_id" name="task_maintenance_level_id" class="select-level form-control"></select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Ticketing</label>
                                        <select name="ticketing_id" disabled="" name="ticketing_id" class="select-ticket form-control"></select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Waktu Mulai</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="date" id="start_date_new" name="start_date" value="{{date('Y-m-d')}}" required="" class="calc_time_new form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="00:00" id="start_time_new" name="start_time" required="" class="time calc_time_new form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Target Selesai </label> <small><span id="calc-loading" class="calc-loading" style="display: none"><i class="fas fa-spinner fa-spin ml-2"></i> Calculating...</span></small>
                                        <input type="hidden" name="time" class="timing" id="timing">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="date" readonly="" id="end_date_new" name="end_date" value="{{date('Y-m-d')}}" required="" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" readonly="" placeholder="00:00" id="end_time_new" name="end_time" required="" class="time form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <label>Progress</label>
                                        <input id="process_new" type="text" name="process" onchange="changeStatus('#hidden-done-new',this.value)" value="0">
                                    </div>
                                    <div class="col-md-6 col-sm-12" id="hidden-done-new" style="display: none;">
                                        <div>
                                            <hr>
                                            <label>Kesulitan</label>
                                            <input id="kesulitan" type="text" class="form-control" name="kesulitan">
                                            <label>Solusinya</label>
                                            <input id="solusi" type="text" class="form-control" name="solusi">
                                            <span class="badge badge-warning">Jika sudah ditandai selesai maka tugas ini tidak dapat diubah</span>
                                            <div class="custom-control custom-checkbox">
                                                <input id="selesai" class="custom-control-input" type="checkbox" name="selesai">
                                                <label for="selesai" class="custom-control-label">Tandai Sudah Selesai</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" submit-button class="btn btn-primary"><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endPermission
             <div class="modal fade" id="detail-ticket" -modaltabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                        </div>
                </div>

                <div class="modal-footer">

                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
            <!-- Modal -->
            <div class="modal fade" id="member-mt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Invite Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @Permission(['superadmin'])
                            <form id="form-member">
                                <div class="row">

                                    <div class="col-md-6 col-sm-12">
                                        @csrf
                                        <input type="hidden" name="task_maintenance_id" id="mt-id">
                                        <label>Pilih User</label>
                                        <select class="form-control pilih-user" id="pilih-user" name="user_id"></select>

                                    </div><div class="col-md-6 col-sm-12">
                                        <label>Tugas</label>
                                        <input type="text" name="task_user" id="task_user" class="form-control" required="" placeholder="cth: Perbaiki validasi re-captcha ">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">

                                        <button type="submit" submit-button class="btn btn-primary btn-block mt-2"><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Tambah</button>
                                    </div>
                                </div>
                            </form>
                            @endPermission
                            <hr>
                            <div class="table-responsive">
                                <table id="table-member" class="table table-bordered">
                                    <thead>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Tugas</th>
                                        @Permission(['superadmin'])
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        @endPermission
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
            <!-- Modal -->
            <!-- Modal -->
            <form id="form-task-edit">
                <div class="modal fade" id="tugas-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Ubah Tugas maintenance</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @Permission(['employee'])
                                <div class="alert alert-info" align="center">Anda hanya dapat mengubah progress.</div>
                                @endPermission
                                <div class="alert alert-danger level_description" style="display: none" align="center"></div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        @csrf
                                        <input type="hidden" id="task_mt_id" name="id">
                                        <label>Nama Tugas</label>
                                        <input type="text" @Permission(['employee']) readonly
                                        @endPermission id="task_name_edit" name="task_name" placeholder="Contoh: Membuat modul absensi" required="" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Projek</label><br>
                                        <select name="project_id" @Permission(['employee']) readonly
                                        @endPermission id="project_id_edit" class="select-project-edit form-control"></select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Level Maintenance</label><br>
                                        <select @Permission(['employee']) readonly
                                        @endPermission name="task_maintenance_level_id" id="task_maintenance_level_id_edit" class="select-level form-control"></select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Ticketing</label>
                                        <select @Permission(['employee']) readonly
                                        @endPermission name="ticketing_id" id="ticketing_id_edit" class="select-ticket-edit form-control"></select>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Waktu Mulai</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input @Permission(['employee']) readonly
                                                @endPermission type="date" id="start_date_edit" name="start_date" value="{{date('Y-m-d')}}" required="" class="calc_time_edit form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input @Permission(['employee']) readonly
                                                @endPermission type="text" placeholder="00:00" id="start_time_edit" name="start_time" required="" class="time calc_time_edit form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label>Target Selesai </label> <small><span id="calc-loading" class="calc-loading" style="display: none"><i class="fas fa-spinner fa-spin ml-2"></i> Calculating...</span></small>
                                        <input type="hidden" name="time" class="timing" id="timing_edit">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="date" readonly="" id="end_date_edit" name="end_date" value="{{date('Y-m-d')}}" required="" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" readonly="" placeholder="00:00" id="end_time_edit" name="end_time" required="" class="time form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <label>Progress</label>
                                        <input id="process_edit" class="process-edit" type="text" name="process" onchange="changeStatus('#hidden-done-edit',this.value)" value="0">
                                    </div>
                                    <div class="col-md-6 col-sm-12" id="hidden-done-edit" style="display: none;">
                                        <div>
                                            <hr>
                                            <label>Kesulitan</label>
                                            <input id="kesulitan_edit" type="text" class="form-control" name="kesulitan">
                                            <label>Solusinya</label>
                                            <input id="solusi_edit" type="text" class="form-control" name="solusi">
                                            <span class="badge badge-warning">Jika sudah ditandai selesai maka tugas ini tidak dapat diubah</span>
                                            <div class="custom-control custom-checkbox">
                                                <input id="selesai_edit" class="custom-control-input" type="checkbox" name="selesai">
                                                <label for="selesai_edit" class="custom-control-label">Tandai Sudah Selesai</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" submit-button class="btn btn-primary"><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Update Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            @if(!empty(Request::get('membertarget')))
            memberList({{Request::get('membertarget')}})
            @endif
            @if(!empty(Request::get('create')))
            $('#tugas-baru').modal('show')
            @endif
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
                memberList(response.data.taskMT.data.id)
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
