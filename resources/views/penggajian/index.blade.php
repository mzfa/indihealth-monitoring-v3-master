@extends('layouts/master_dashboard')
@section('title', 'Kelola Penggajian')
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
            <a href="#mk_penggajian" title="Tambah Penggajian" data-toggle="modal" data-target="#create-penggajian"
                class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Tambah Penggajian</a>
            <hr>
            <form action="{{ url('penggajian/save') }}" method="post">
              @csrf
                <div class="modal fade" id="create-penggajian" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Penggajian Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nama Penggajian</label>
                                        <input type="text" required="" id="nama_penggajian"
                                            placeholder="Penggajian Bulan Januari 2024" name="nama_penggajian" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Keterangan</label>
                                        <input type="text" required="" id="keterangan" placeholder="cth: Semua Karyawan" name="keterangan" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary" submit-button><i spinner
                                        style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ url('penggajian/update') }}" method="post">
              @csrf
                <div class="modal fade" id="edit-penggajian" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Ubah data Penggajian </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="tampildata"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary" submit-button-project><i spinner
                                        style="display: none;" class="fas fa-spinner fa-spin"></i> Simpan</button>
                                <button type="button" class="btn btn-outline-secondary"
                                    data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        
        <div class="col-12">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover" id="penggajianTable">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Penggajian</th>
                          <th>Keterangan</th>
                          <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;   
                      @endphp
                      @foreach ($penggajian as $item)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama_penggajian }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            @if (auth()->user()->role_id !== 5)
                          <button class="btn btn-info btn-sm" onclick="edit({{$item->id}})">
                            <i class="fas fa-pencil-alt" id="icon-{{$item->id}}"></i>
                          </button> 
                          <a href="{{ url('penggajian/delete/'.$item->id) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt" id="icon-{{$item->id}}"></i>
                          </a>
                          @endif
                          <a href="{{ url('penggajian/detail/'.$item->id) }}" class="btn btn-warning btn-sm">
                            @if (auth()->user()->role_id == 5)
                                Acc                                
                            @else
                                Detail
                            @endif
                          </a>
                        </td>
                      </tr>
                      @endforeach
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
        $(function() {
            $('#penggajianTable').DataTable();
        });

        function editpenggajian(id) {
            console.log(id);
            let formData = new FormData();
            $("#icon-" + id).addClass('fa-spinner fa-spin').removeClass('fa-pencil-alt');
            formData.append('id', id);
            axios.post('{{ route('penggajian.show') }}', formData)
                .then(function(response) {
                    $('#edit-penggajian').modal('show');
                    $("#id_penggajian").val(response.data.penggajian.data.id)
                    $("#edit_name").val(response.data.penggajian.data.name)
                    $("#edit_nama_perusahaan").val(response.data.penggajian.data.nama_perusahaan)
                    $("#edit_jabatan").val(response.data.penggajian.data.jabatan)
                    $("#edit_username").val(response.data.penggajian.data.username)
                    $("#edit_email").val(response.data.penggajian.data.email)
                    $("#edit_no_telp").val(response.data.penggajian.data.no_telp)
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

        function edit(id){
            $.ajax({ 
                type : 'get',
                url : "{{ url('penggajian/edit')}}/"+id,
                success:function(tampil){
                    $('#tampildata').html(tampil);
                    $('#edit-penggajian').modal('show');
                } 
            })
        }

        function addProject(id) {
            console.log(id);
            let formData = new FormData();
            $("#projectTable").dataTable().fnDestroy()
            $("#link-project-" + id).prop('disabled', true)
            $("#icon-project-" + id).addClass('fa-spinner fa-spin').removeClass('fa-project-alt');
            formData.append('id', id);
            axios.post('{{ route('penggajian.show') }}', formData)
                .then(function(response) {
                    $("#link-project-" + id).prop('disabled', false)
                    $('#penggajian_id').val(response.data.penggajian.data.id)
                    $('#penggajian_name').text(response.data.penggajian.data.name)
                    $('#add-project-penggajian').modal('show');
                    window.tb_project = $('#projectTable').DataTable({
                        "order": [
                            [2, "asc"]
                        ],
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        "language": {
                            "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                        },
                        ajax: "{{ route('linkedProject.datatables') }}?penggajian_id=" + id,
                        columns: [{
                                data: 'project_name',
                                name: 'project_name'
                            },
                            {
                                data: 'project_client',
                                name: 'project_client'
                            }, {
                                data: 'tanggal',
                                name: 'tanggal'
                            }, {
                                data: 'deadline',
                                name: 'deadline'
                            }, {
                                data: 'link',
                                name: 'link'
                            },
                            {
                                data: 'aksi',
                                name: 'aksi'
                            },
                        ]
                    });
                    // $("#id_penggajian").val(response.data.penggajian.data.id)
                    // $("#edit_name").val(response.data.penggajian.data.name)
                    // $("#edit_nama_perusahaan").val(response.data.penggajian.data.nama_perusahaan)
                    // $("#edit_jabatan").val(response.data.penggajian.data.jabatan)
                    // $("#edit_username").val(response.data.penggajian.data.username)
                    // $("#edit_email").val(response.data.penggajian.data.email)
                    // $("#edit_no_telp").val(response.data.penggajian.data.no_telp)
                    $("#icon-project-" + id).addClass('fa-project-alt').removeClass('fa-spinner fa-spin');
                })
                .catch(function(error) {
                    $("#link-project-" + id).prop('disabled', false)
                    $("#icon-project-" + id).addClass('fa-project-alt').removeClass('fa-spinner fa-spin');

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
        $("#form-add-project").submit(function(e) {
            e.preventDefault();
            $("[spinner-project]").addClass('fa-spinner fa-spin').removeClass('fa-plus');
            $("[submit-button-project]").prop("disabled", true);
            let form = $('#form-add-project')[0];
            let formData = new FormData(form);
            axios.post('{{ route('linkedProject.save') }}', formData)
                .then(function(response) {
                    $("[spinner-project]").addClass('fa-plus').removeClass('fa-spinner fa-spin');
                    $("[submit-button-project]").prop("disabled", false);
                    window.tb_project.ajax.reload();
                })
                .catch(function(error) {
                    $("[spinner-project]").addClass('fa-plus').removeClass('fa-spinner fa-spin');
                    $("[submit-button-project]").prop("disabled", false);
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
        });

        $("#form-tambah-penggajian").submit(function(e) {
            e.preventDefault();
            $("[spinner]").show();
            $("[submit-button]").prop("disabled", true);
            let form = $('#form-tambah-penggajian')[0];
            let formData = new FormData(form);
            axios.post('{{ route('penggajian.save') }}', formData)
                .then(function(response) {
                    $("[spinner]").hide();
                    $("[submit-button]").prop("disabled", false);
                    $("#create_name").val("")
                    $("#keterangan").val("")
                    $("#create_jabatan").val("")
                    $("#create_username").val("")
                    $("#create_email").val("")
                    $("#create_no_telp").val("")
                    $("#create_password").val("")
                    $("#create_password_confirm").val("")
                    $('#create-penggajian').modal('hide');
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
        });
        $("#form-edit-penggajian").submit(function(e) {
            e.preventDefault();
            $("[spinner]").show();
            $("[submit-button]").prop("disabled", true);
            let form = $('#form-edit-penggajian')[0];
            let formData = new FormData(form);
            axios.post('{{ route('penggajian.update') }}', formData)
                .then(function(response) {
                    $("[spinner]").hide();

                    $('#edit-penggajian').modal('hide');
                    $("[submit-button]").prop("disabled", false);
                    $("#id_penggajian").val("")
                    $("#edit_name").val("")
                    $("#edit_nama_perusahaan").val("")
                    $("#edit_jabatan").val("")
                    $("#edit_username").val("")
                    $("#edit_email").val("")
                    $("#edit_no_telp").val("")
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
        });

        function disablepenggajian(id) {
            Swal.fire({
                title: 'Anda ingin menonaktifkan Penggajian ini?',
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

        function disableAct(id) {
            // alert("ok");
            let formData = new FormData();
            formData.append('id', id);
            axios.post('{{ route('penggajian.disable') }}', formData)
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

        function enablepenggajian(id) {
            Swal.fire({
                title: 'Anda ingin mengaktifkan Penggajian ini?',
                text: "Pengguna ini dapat memasuki sistem lagi.",
                showCancelButton: true,
                confirmButtonText: `Aktifkan`,
            }).then((result) => {
                if (result.isConfirmed) {
                    enableAct(id);
                }
            })
        }

        function enableAct(id) {
            // alert("ok");
            let formData = new FormData();
            formData.append('id', id);
            axios.post('{{ route('penggajian.enable') }}', formData)
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

        function deleteProject(id) {
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

        function deleteProjectAct(id) {
            // alert("ok");
            let formData = new FormData();
            formData.append('id', id);
            $("#project-" + id).addClass('fa-spinner fa-spin').removeClass('fa-unlink');
            axios.post('{{ route('linkedProject.delete') }}', formData)
                .then(function(response) {
                    $("#project-" + id).addClass('fa-unlink').removeClass('fa-spinner fa-spin');
                    window.tb_project.ajax.reload();
                })
                .catch(function(error) {
                    $("#project-" + id).addClass('fa-unlink').removeClass('fa-spinner fa-spin');

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
