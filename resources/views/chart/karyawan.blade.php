@extends('layouts/master_dashboard')
    @section('title', 'Portofolio Karyawan')
    @section('subtitle', $karyawan->nama_lengkap." (".$karyawan->jabatan->nama.")")
    @section('content')
    <div class = "row" >
      <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Absensi  <i id="spinner_absen" style="display: none;" class="fas fa-spinner fa-spin"></i><br> <a href="{{route('absensi.detail.karyawan',['kry_id' => $karyawan->id])}}"  class="btn btn-primary btn-sm">Lihat detail</a></h4>
            </div>
            <div class="card-body overflow-auto" align="center">
                <canvas id="absen" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
            </div>
        </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Task Development  <i id="spinner_task" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
                </div>
                <div class="card-body overflow-auto" align="center">
                    <canvas id="tasks" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Task Maintenance  <i id="spinner_task_mt" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
                </div>
                <div class="card-body overflow-auto" align="center">
                    <div id="mt_check">
                        <canvas id="task_mt" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Online <i id="spinner_online" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
                </div>
                <div class="card-body overflow-auto" align="center">
                    <canvas id="online" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
                </div>
            </div>

        </div>
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Projek yang terhubung</h4>
                </div>
                <div class="card-body overflow-auto" align="center">
                    <table class="table table-striped" id="project-list">
                      <thead>
                      <th>Nama Projek </th>
                      <th>Client</th>
                      <th>Posisi</th>
                      <th>Tanggal Ditambahkan</th>
                    </thead>
                    <tbody>

                    </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Jam kerja <i id="spinner_jam_kerja" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
                </div>
                <div class="card-body overflow-auto" align="center">
                    <canvas id="jam_kerja" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
                </div>
            </div>

        </div>
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Semua <i id="spinner_radar" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
                </div>
                <div class="card-body overflow-auto" align="center">
                    <canvas id="semua" style="@if(Agent::isMobile())min-height: 300px @endif"></canvas>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('javascript')
<script>

$(function(){
   loadAbsen()
   loadTask()
   loadTaskMT()
   loadOnline()
   jamKerja()
   loadRadar()
   tableProjects("{{$karyawan->user->id}}")
})

function tableProjects(id)
{
  window.project_list =  $('#project-list').DataTable({
                     "order": [[ 2, "asc" ]],
                     processing: true,
                     serverSide: true,
                     autoWidth:false,
                     "searching": false,
                    "lengthChange": false,
                     "language": {
     "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
       "emptyTable": "Belum ada projek ditemukan."
   },
                     ajax: "{{ route('project.karyawan.get')}}?id="+id,
                     columns: [{
                             data: 'nama_projek',
                             name: 'nama_projek'
                         },{
                             data: 'client',
                             name: 'client'
                         },

                         {
                             data: 'tipe',
                             name: 'tipe'
                         },
                         {
                             data: 'ditambahkan_pada',
                             name: 'ditambahkan_pada'
                         },
                     ]
                 });
             }

    function loadAbsen()
    {
         let formData = new FormData();
        $('#spinner_absen').fadeIn();
        axios.post('{{route("chart.api.absensi.karyawan")}}?karyawan_id={{Request::get('id')}}', formData)
                .then(function (response) {
               $('#spinner_absen').fadeOut();
               var ctx = document.getElementById('absen');
                window.absen = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.absensi.label,
                        datasets: [{
                            label: 'Melakukan Absen',
                            lineTension: 0.4,
                            data: response.data.absensi.data,
                            backgroundColor:
                                'rgba(103, 58, 183,0.2)',
                            borderColor:
                                'rgba(103, 58, 183,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                          @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                        bezierCurve: true,
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Jumlah Hari'
                                },ticks: {
                                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                    suggestedMax: 22,
                                    stepSize:2    // minimum will be 0, unless there is a lower value.
                                }
                            }],
                           xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Bulan'
                                }
                            }],
                            y: {
                                min: 0,
                                max: 2,
                                beginAtZero: true
                            }
                        }
                    }
                });
              })
              .catch(function (error) {
                 $('#spinner_absen').fadeOut();
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
    function loadTaskMT(){
    let formData = new FormData();
    $('#spinner_task_mt').fadeIn();
        axios.post('{{route("chart.api.chartMT")}}?karyawan_id={{Request::get('id')}}', formData)
                .then(function (response) {
            $('#spinner_task_mt').fadeOut();
            if(response.data.taskMT.data[0] == 0 && response.data.taskMT.data[1] == 0)
             {
                $('#mt_check').html('<div class="alert alert-warning" align="center">Belum ada data yang dapat ditampilkan</div>');

                return false;
             }
              var xValues = response.data.taskMT.label;
              var yValues = response.data.taskMT.data;
              var barColors = [
                "#81c784",
                "#ff5252",
                "#2b5797",
                "#e8c3b9",
                "#1e7145"
              ];

          window.tipe = new Chart("task_mt", {
                type: "pie",
                data: {
                  labels: xValues,
                  datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                  }]
                },
                options: {
                      @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                  title: {
                    display: true,
                    text: "Status"
                  }
                }
              });
              })
              .catch(function (error) {
                $('#spinner_task_mt').fadeOut();
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
    function loadTask()
    {
         let formData = new FormData();
        $('#spinner_task').fadeIn();
        axios.post('{{route("chart.api.chartDev")}}?karyawan_id={{Request::get('id')}}', formData)
                .then(function (response) {
               $('#spinner_task').fadeOut();
               var ctx = document.getElementById('tasks');
                window.absen = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.tasks.label,
                        datasets: [{
                            label: 'Task Karyawan',
                            lineTension: 0.4,
                            data: response.data.tasks.data,
                            backgroundColor:
                                'rgba(212, 225, 87,0.2)'
                            ,
                            borderColor:  'rgba(212, 225, 87,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                          @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                        bezierCurve: true,
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Persentase'
                                },ticks: {
                                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                    suggestedMax: 100,
                                    stepSize:20    // minimum will be 0, unless there is a lower value.
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Bulan'
                                }
                            }],
                            y: {
                                min: 0,
                                max: 2,
                                beginAtZero: true
                            }
                        }
                    }
                });
              })
              .catch(function (error) {
                 $('#spinner_task').fadeOut();
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
    function loadOnline()
    {
         let formData = new FormData();
        $('#spinner_online').fadeIn();
        axios.post('{{route("chart.api.online")}}?karyawan_id={{Request::get('id')}}', formData)
                .then(function (response) {
               $('#spinner_online').fadeOut();
               var ctx = document.getElementById('online');
                window.absen = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.online.label,
                        datasets: [{
                            label: 'Online',
                            lineTension: 0.4,
                            data: response.data.online.data,
                            backgroundColor:
                                'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                          @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                        bezierCurve: true,
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Jumlah Online'
                                },
                                ticks: {
                                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                    suggestedMax: 22,
                                    stepSize:2    // minimum will be 0, unless there is a lower value.
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Bulan'
                                }
                            }],
                            y: {
                                min: 0,
                                max: 2,
                                beginAtZero: true
                            }
                        }
                    }
                });
              })
              .catch(function (error) {
                 $('#spinner_online').fadeOut();
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

    function loadRadar()
    {
         let formData = new FormData();
        $('#spinner_radar').fadeIn();
        axios.post('{{route("chart.api.chartRadar")}}?karyawan_id={{Request::get('id')}}', formData)
                .then(function (response) {
               $('#spinner_radar').fadeOut();
                var ctx = document.getElementById('semua');
                window.myChart = new Chart(ctx, {
                    type: 'radar',
                     data: {
                    labels: response.data.radar.label,
                    datasets: [
                        {
                            label: "Stat Karyawan",
                            backgroundColor: "rgba(99, 164, 255,0.5)",
                            borderColor: "rgba(25, 118, 210,1)",
                            pointBackgroundColor: "rgba(25, 118, 210,1)",
                            pointBorderColor: "#fff",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(25, 118, 210,1)",
                            data: response.data.radar.data
                        },
                    ]
                },
                options: {
                      @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                    scale: {
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            max: 100,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }
                }
                });
              })
              .catch(function (error) {
                 $('#spinner_radar').fadeOut();
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

    function jamKerja(){
    let formData = new FormData();
    $('#spinner_jam_kerja').fadeIn();
        axios.post('{{route("chart.api.absensiJamKerja")}}?karyawan_id={{Request::get('id')}}', formData)
                .then(function (response) {
                     $('#spinner_jam_kerja').fadeOut();
               var ctx = document.getElementById('jam_kerja');
                window.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.data.absensi.label,
                        fillColor: "rgba(151,187,205,0.5)",
                        datasets: [{
                            label: 'Rata-Rata jam kerja',
                            backgroundColor:'rgba(0, 176, 255,0.2)',
                            data: response.data.absensi.data,
                            borderWidth: 1
                        }]
                    },
                    options: {
                          @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                        bezierCurve: true,
                        scales: {
                             yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Jam Kerja'
                                },ticks: {
                                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                    suggestedMax: 10,
                                    stepSize: 2    // minimum will be 0, unless there is a lower value.
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Tanggal bulan ini'
                                }
                            }],
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
              })
              .catch(function (error) {
                 $('#spinner_jam_kerja').fadeOut();
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
