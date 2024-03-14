@extends('layouts/master_dashboard')
    @section('title', 'Chart Karyawan')
    @section('content') 
    <div class = "row" > 
      <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Karyawan Online (7 Hari) <i id="spinner_online" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
            </div>
            <div class="card-body overflow-auto" align="center">
                <canvas id="online" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Tipe Karyawan <i id="spinner_tipe" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
            </div>
            <div class="card-body  overflow-auto" align="center">
                <canvas id="tipe" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Jabatan Karyawan <i id="spinner_jabatan" style="display: none;" class="fas fa-spinner fa-spin"></i></h4>
            </div>
            <div class="card-body" align="center">
                <canvas id="jabatan" style="@if(Agent::isMobile())height: 300px @endif"></canvas>
            </div>
        </div>
    </div>  
  </div>

  <form id="form-online">
    <div
        class="modal fade"
        id="online-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Karyawan Online
                        <span id="absensi-tanggal"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover" id="online-table">
                            <thead>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Waktu mulai Online</th>
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

<form id="form-online">
    <div
        class="modal fade"
        id="karyawan-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Karyawan
                        <span id="absensi-tanggal"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover" id="karyawan-table">
                            <thead>
                                <th>Foto</th>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>No Telp</th>
                    <th>Tipe</th>
                    <th>Jabatan</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                   
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
    fetchOnline()
    fetchTipe()

    fetchJabatan()
});
 $('#online').click(function(evt) {
   var activePoint = window.myChart.getElementAtEvent(evt)[0];
    $("#online-table").dataTable().fnDestroy()
                   $('#online-table').DataTable({
                    // "order": [[ 2, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                            },
                    ajax: "{{ route('online.datatable')}}?tanggal="+activePoint._model.label,
                    columns: [{
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'jabatan',
                            name: 'jabatan'
                        },{
                            data: 'waktu',
                            name: 'waktu'
                        },
                    ]
                });
               $("#online-modal").modal('show')
});    
 $('#tipe').click(function(evt) {
   var tipe = window.tipe.getElementAtEvent(evt)[0];
    $("#karyawan-table").dataTable().fnDestroy()
                   $('#karyawan-table').DataTable({
                    // "order": [[ 2, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    autoWidth:false,
                    "language": {
                                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                            },
                    ajax: "{{ route('karyawan.datatables')}}?tipe="+tipe._model.label.replace(' ','-'),
                    columns: [{
                            data: 'foto',
                            name: 'foto'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },{
                            data: 'nama_lengkap',
                            name: 'nama_lengkap'
                        },
                        {
                            data: 'no_telp',
                            name: 'no_telp'
                        },
                        {
                            data: 'tipe',
                            name: 'tipe'
                        },
                         {
                            data: 'jabatan',
                            name: 'jabatan'
                        },
                         
                    ]
                });
               $("#karyawan-modal").modal('show')
    console.log(tipe._model.label.replace(' ','-'))
}); 
 $('#jabatan').click(function(evt) {
   var jabatan = window.jabatan.getElementAtEvent(evt)[0];
    $("#karyawan-table").dataTable().fnDestroy()
                   $('#karyawan-table').DataTable({
                    // "order": [[ 2, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    autoWidth:false,
                    "language": {
                                "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
                            },
                    ajax: "{{ route('karyawan.datatables')}}?jabatan="+jabatan._model.label,
                    columns: [{
                            data: 'foto',
                            name: 'foto'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },{
                            data: 'nama_lengkap',
                            name: 'nama_lengkap'
                        },
                        {
                            data: 'no_telp',
                            name: 'no_telp'
                        },
                        {
                            data: 'tipe',
                            name: 'tipe'
                        },
                         {
                            data: 'jabatan',
                            name: 'jabatan'
                        },
                         
                    ]
                });
               $("#karyawan-modal").modal('show')
    console.log(jabatan._model.label.replace(' ','-'))
}); 

function fetchOnline(){
    let formData = new FormData();
    $('#spinner_online').fadeIn();
        axios.post('{{route("chart.api.KaryawanOnline")}}', formData)
                .then(function (response) {
              $('#spinner_online').fadeOut();
               var ctx = document.getElementById('online');
                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.karyawan.label,
                        datasets: [{
                            label: 'Karyawan yang online',
                            lineTension: 0.4,
                            data: response.data.karyawan.data,
                            borderWidth: 1
                        }]
                    },
                     onComplete: () => {
                      delayed = true;
                    },
                    options: {
                      @if(Agent::isMobile())
                       responsive: false,
                        maintainAspectRatio: false,
                      @endif
                      title: {
                            display: true,
                            text: "Karyawan Online"
                          },
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
                    }, onClick: function (e) {
                        var activePointLabel = this.getElementsAtEvent(e)[0]._model.label;
                        alert(e);
                    }
                });
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
function fetchTipe(){
    let formData = new FormData();
    $('#spinner_tipe').fadeIn();
        axios.post('{{route("chart.api.karyawanTipe")}}', formData)
                .then(function (response) {
                  $('#spinner_tipe').fadeOut();
              var xValues = response.data.karyawan.label;
              var yValues = response.data.karyawan.data;
              var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9",
                "#1e7145"
              ];

          window.tipe = new Chart("tipe", {
                type: "pie",
                autoWidth:false,
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
                    text: "Tipe Karyawan"
                  }
                }
              });
              })
              .catch(function (error) {
                $('#spinner_tipe').fadeOut();
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

function fetchJabatan(){
    let formData = new FormData();
     $('#spinner_jabatan').fadeIn();
        axios.post('{{route("chart.api.jabatan")}}', formData)
                .then(function (response) {
                    $('#spinner_jabatan').fadeOut();
              var xValues = response.data.karyawan.label;
              var yValues = response.data.karyawan.data;
              var barColors = ['#076cab','#606dbc','#9e68be','#d260b0','#fa5c93','#ff686d','#ff8442','#ffa600','#cfdae0','#f1f1f1','#f1d4d4','#f0b8b8','#ec9c9d','#e67f83','#de6069','#d43d51'];

            window.jabatan =  new Chart("jabatan", {
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
                    text: "Jabatan Karyawan"
                  }
                }
              });
              })
              .catch(function (error) {
                $('#spinner_jabatan').fadeOut();
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
$('#online').click(function(evt) {
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
</script>

@endsection