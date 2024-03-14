@extends('layouts/master_dashboard')
@section('title', "Grafik Absensi Karyawan Bulan Ini")
@section('content')
<div class="row justify-content-center">

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4>Absensi karyawan bulan ini
                    <i id="spinner" style="display: none;" class="fas fa-spinner fa-spin"></i>
                </h4>
            </div>
            <div class="card-body overflow-auto" align="center">
                <div align="left">
                <span><b>Total Karyawan Aktif :</b> {{number_format($karyawan_count)}}</span><br>
                <span><b>Total Karyawan Resign :</b> {{number_format($karyawan_resign_count)}}</span>
            </div>
                <hr>
                <canvas id="absen" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4>Rata-rata jam kerja karyawan per-hari
                    <i id="spinner_jam_kerja" style="display: none;" class="fas fa-spinner fa-spin"></i>
                </h4>
            </div>
            <div class="card-body overflow-auto" align="center">
                <div align="left">
                 <span><b>Rata-rata jam kerja:</b> <span id="rata_rata_jk"><i class="fas fa-spinner fa-spin"></i></span></span><br>
                <span><b>Jam Kerja Paling Tinggi:</b> <span id="max_jk"><i class="fas fa-spinner fa-spin"></i></span></span><br>
                <span><b>Jam Kerja Paling Rendah:</b> <span id="min_jk"><i class="fas fa-spinner fa-spin"></i></span></span>
                </div>
                <hr>
                <canvas id="jam_kerja" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
            </div>
        </div>
    </div>

</div>

<form id="form-absen">
    <div
        class="modal fade"
        id="absen-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail absensi tanggal
                        <span id="absensi-tanggal"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover" id="absenTable">
                            <thead>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama Karyawan</th>
                                <th>Tipe</th>
                                <th>Tanggal</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="submit"
                        class="btn btn-outline-primary"
                        submit-button="submit-button">
                        <i spinner="spinner" style="display: none;" class="fas fa-spinner fa-spin"></i>
                        Simpan</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('javascript')
<script>
$(function(){
    fetchAbsen()
    jamKerja()
});
$('#absen').click(function(evt) {
    $("#absenTable").dataTable().fnDestroy()
   window.activePoint = window.myChart.getElementAtEvent(evt)[0];


                      $('#absenTable').DataTable({
                    "order": [[ 3, "desc" ],[4,'desc']],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                            },
                    ajax: "{{ route('absen.datatables')}}?tanggal={{date('Y-m-')}}"+window.activePoint._model.label,
                    columns: [{
                            data: 'foto',
                            name: 'foto'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },{
                            data: 'nama_karyawan',
                            name: 'nama_karyawan'
                        },{
                            data: 'tipe',
                            name: 'tipe'
                        },{
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'jam_masuk',
                            name: 'jam_masuk'
                        },
                         {
                            data: 'jam_keluar',
                            name: 'jam_keluar'
                        },
                    ]
                });
               $("#absen-modal").modal('show')
             
});              
function fetchAbsen(){
    let formData = new FormData();
    $('#spinner').fadeIn();
        axios.post('{{route("chart.api.absensi")}}', formData)
                .then(function (response) {
                     $('#spinner').fadeOut();
               var ctx = document.getElementById('absen');
                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.absensi.label,
                        datasets: [{
                            label: 'Karyawan yang absen',
                            lineTension: 0.4,
                            data: response.data.absensi.data,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.7)',
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
                                    labelString: 'Jumlah karyawan'
                                },ticks: {
                                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                    suggestedMax: {{$karyawan_count}},
                                    stepSize:{{$karyawan_count}}/10    // minimum will be 0, unless there is a lower value.
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
                 $('#spinner').fadeOut();
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
        axios.post('{{route("chart.api.absensiJamKerja")}}', formData)
                .then(function (response) {
                     $('#spinner_jam_kerja').fadeOut();
                $('#rata_rata_jk').html(response.data.absensi.rate+" jam")
                $('#max_jk').html(response.data.absensi.max+" jam")
                $('#min_jk').html(response.data.absensi.min+" jam")
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
                                    suggestedMax: 12,
                                    stepSize:2    // minimum will be 0, unless there is a lower value.
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

  $("#myChart").click( 
                        function(evt){
                            var activePoints = myChart.getElementsAtEvent(evt);
                            var url = "http://example.com/?label=" + activePoints[0].label + "&value=" + activePoints[0].value;
                            alert(url);
                        }
                    );   
</script>

@endsection