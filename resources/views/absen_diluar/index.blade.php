@extends('layouts/master_dashboard')
@section('title', 'Absensi dari luar lokasi')
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
            <div class="table-responsive">
                <table class="table  table-bordered table-hover" id="penggajianTable">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>NIP</th>
                          <th>Nama Karyawan</th>
                          <th>Alasan</th>
                          <th>Waktu Permintaan</th>
                          <th>Status</th>
                          <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;   
                      @endphp
                      @foreach ($data as $item)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->isi_pesan }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
                        <td>{{ $item->status ?? '-' }}</td>
                        <td>
                            @if ($item->status !== null)
                                <a href="{{ url('absen_diluar/batal/'.$item->id) }}" class="btn btn-danger btn-sm">
                                    Batalkan Status
                                </a>
                            @else
                                <a href="{{ url('absen_diluar/terima/'.$item->id) }}" class="btn btn-primary btn-sm">
                                TERIMA
                                </a>
                                <a href="{{ url('absen_diluar/tolak/'.$item->id) }}" class="btn btn-danger btn-sm">
                                    TOLAK
                                  </a>
                            @endif
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
