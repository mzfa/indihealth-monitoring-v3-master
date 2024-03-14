@extends('layouts/master_dashboard')
@section('title','Kelola Absensi Karyawan')
@section('content')

<!-- Modal -->
<div class="modal fade" id="detail-absen" tabindex="-1" role="dialog" aria-labelledby="absenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Absensi  <span id="nama_lengkap"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr>
            <td colspan="2"><b>Informasi Detail</td>
          </tr>
          <tr>
            <td>Foto Masuk<br><img src="" id="foto_masuk" width="150px"></td>
            <td>Foto Pulang<br><img src="" id="foto_pulang" width="150px"></td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td><span id="tanggal"></span></td>
          </tr>
          <tr>
            <td>Masuk</td>
            <td><span id="jam_masuk"></span></td>
          </tr>
          <tr>
            <td>Keluar</td>
            <td><span id="jam_keluar"></span></td>
          </tr>
          <tr>
            <td>Jam Kerja</td>
            <td><span id="jam_kerja"></span></td>
          </tr>
          <tr>
            <td>Ip Address</td>
            <td><span id="ip_address"></span></td>
          </tr>
          <tr>
            <td>Browser</td>
            <td><span id="browser"></span></td>
          </tr>
          <tr>
            <td>Platform</td>
            <td><span id="platform"></span></td>
          </tr>
          <tr>
            <td>Tempat Absen Masuk</td>
            <td><span id="addr_masuk"></span></td>
          </tr>
          <tr>
            <td>Tempat Absen Pulang</td>
            <td><span id="addr_pulang"></span></td>
          </tr>
        </table>
        <hr>
        <h5>Lokasi Absen Masuk</h5>
        <div id="map" style='width: 100%; height: 300px'>
          {{-- https://embed.waze.com/iframe?zoom=14&lat={{$data->lat}}&lon={{$data->lng}}&pin=1&desc=1 --}}
          {{-- <iframe id="map-frame" src=""
                    width="100%" height="520"></iframe> --}}
         </div>
         <hr>
         <h5>Lokasi Absen Pulang</h5>
        <div id="map-pulang" style='width: 100%; height: 300px'>
         </div>
         </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>

  </div>
</div>
</div>

    <div class="row">
        <div class="col-12">
            @error('start_date')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('end_date')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
         @Permission(['superadmin'])
        <div class="col-md-2 col-sm-12">
          
           <button type="button" title="Lihat Detail" id="btn-add" class="btn btn-success btn-block"><i class="fas fa-calendar-plus mr-2"></i> Tambahkan absensi</button> 
          
        </div>
          @endPermission
        <div class="col-md-2 col-sm-12">
          
           <button type="button" title="Lihat Detail" data-toggle="modal" data-target="#export-absensi" class="btn btn-primary btn-block"><i class="fas fa-download mr-2"></i> Export</button>
          <hr>
        </div>
        <div class="col-12 mb-3">
          <form action="" method="GET">
          <div class="row">
                    <div class="col-12">
                       <b>Cari berdasarkan bulan dan tahun</b>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <select class="form-control" id="bulan-export"  name="bulan">

                        <option value="01" {{Request::get('bulan') == '01' ? "selected":(date('m') == '01' ? 'selected':null) }}>Januari</option>
                        <option value="02" {{Request::get('bulan') == '02' ? "selected":(date('m') == '02' ? 'selected':null) }}>Februari</option>
                        <option value="03" {{Request::get('bulan') == '03' ? "selected":(date('m') == '03' ? 'selected':null) }}>Maret</option>
                        <option value="04" {{Request::get('bulan') == '04' ? "selected":(date('m') == '04' ? 'selected':null) }}>April</option>
                        <option value="05" {{Request::get('bulan') == '05' ? "selected":(date('m') == '05' ? 'selected':null) }}>Mei</option>
                        <option value="06" {{Request::get('bulan') == '06' ? "selected":(date('m') == '06' ? 'selected':null) }}>Juni</option>
                        <option value="07" {{Request::get('bulan') == '07' ? "selected":(date('m') == '07' ? 'selected':null) }}>Juli</option>
                        <option value="08" {{Request::get('bulan') == '08' ? "selected":(date('m') == '08' ? 'selected':null) }}>Agustus</option>
                        <option value="09" {{Request::get('bulan') == '09' ? "selected":(date('m') == '09' ? 'selected':null) }}>September</option>
                        <option value="10" {{Request::get('bulan') == '10' ? "selected":(date('m') == '10' ? 'selected':null) }}>Oktober</option>
                        <option value="11" {{Request::get('bulan') == '11' ? "selected":(date('m') == '11' ? 'selected':null) }}>November</option>
                        <option value="12" {{Request::get('bulan') == '12' ? "selected":(date('m') == '12' ? 'selected':null) }}>Desember</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-sm-6">

                      <select class="form-control" id="tahun-export" name="tahun">
                      @foreach(range(date('Y'), 2015) as $year)
                        <option value="{{$year}}" {{Request::get('tahun') == $year ? "selected": (date('Y') == $year ? 'selected':null)}}>{{$year}}</option>
                      @endforeach
                      </select>
                    </div>
                     <div class="col-md-2 col-sm-12 ">
                      <button class="btn btn-outline-primary btn-block"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </div>

          </form>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box clearfix mb-3" id="total_r_jam_kerja_bulan">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-clock"></i></span>

            <div class="info-box-content">
                <small>{{\Carbon\Carbon::now()->format('d-m-Y')}}</small>
              <span class="info-box-text">Absensi Masuk Hari ini</span>
              <span class="info-box-number">
               <span id="r_masuk">-</span> dari <span class="r_total_karyawan">-</span> orang
              </span>
            </div>
              <div class="overlay overlay-stat" >
              <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box clearfix mb-3" id="total_r_jam_kerja_bulan">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-clock"></i></span>

            <div class="info-box-content">
                <small>{{\Carbon\Carbon::now()->format('d-m-Y')}}</small>
              <span class="info-box-text">Absensi Keluar Hari ini</span>
              <span class="info-box-number">
               <span id="r_keluar">-</span> dari <span class="r_total_karyawan">-</span> orang
              </span>
            </div>
              <div class="overlay overlay-stat" >
              <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <div class="col-12">
            <div class="table-responsive-sm">
            <table class="table  table-bordered table-hover" id="absenTable">
                <thead>
                    <th>Foto</th>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>Tipe</th>
                    <th>Tanggal</th>
                    <th>Jam Kerja</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Dibuat pada</th>
                    <th>Aksi</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        </div>

    </div>

<form action="{{route('absen.export')}}" method="POST">
<div class="modal fade" id="export-absensi" tabindex="-1" role="dialog" aria-labelledby="export-absensi-lbl" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export Absensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <label>Pilih karyawan</label>
                <select 
                        name="karyawan_id" required 
                        id="select-absen-karyawan"
                        class="select-absen-karyawan form-control">
                         <option>Semua</option>
                        </select>
            </div>
            </div>
        <div class="row">
            <div class="col-md-6">
                <label>Tanggal awal</label>
                <input type="date" name="start_date" value="{{date('Y-m-d')}}" class="form-control">
            </div>
            <div class="col-md-6">
                @csrf
                <label>Tanggal akhir</label>
                <input type="date" name="end_date" value="{{date('Y-m-d')}}" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" ><i class="fas fa-download mr-2"></i>  Export</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>
@Permission(['superadmin'])
{{-- <form action="{{route('absen.export')}}" method="POST"> --}}
<div class="modal fade" id="tambah-absensi" tabindex="-1" role="dialog" aria-labelledby="export-absensi-lbl" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Absensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <label>Pilih karyawan</label>
                <select 
                        name="karyawan_id" id="karyawan_id" required 
                        {{-- id="select-absen-karyawan" --}}
                        class="select-absen-karyawan-create form-control">
                         <option>Pilih</option>
                        </select>
            </div>
            </div>
        <div class="row">
            <div class="col-md-6">
                <label>Tanggal</label>
                <input type="date" name="tanggal" id="tgl" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" class="form-control">
            </div>
            <div class="col-md-12">
                <input type="hidden"  id="lat" name="lat">
                <input type="hidden" id="lng"  name="lng">
            </div>
            <div class="col-md-6">
                <label>Jam Masuk</label>
                <input type="text" name="masuk" id="masuk" value="{{date('H:i')}}"  class="time form-control">
            </div> 
            <div class="col-md-6">
                <label>Jam Keluar</label>
                <input type="text" name="keluar" id="keluar" value="{{date('H:i')}}"  class="time form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btn-submit-absen" class="btn btn-success" ><i id="spinner" class="fas fa-plus mr-2"></i>  Tambah</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- </form> --}}
@endPermission
@endsection

@section('javascript')
<link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
<script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>

  <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?key=AgCRMh3Aq-zhk5GKgMC9NX25AHTnH5RjDbJ5zJapwOVhaynZu-iQl4YK28aVzJig&callback=loadMapScenario' async
        defer></script>
 <script type="text/javascript">
$('#btn-submit-absen').click(function(){
    $('#spinner').removeClass('fa-plus');
    $('#spinner').addClass('fa-spin fa-spinner');
    let formData = new FormData();
    formData.append('karyawan_id', $('#karyawan_id').val());
    formData.append('tanggal', $('#tgl').val());
    formData.append('lat', $('#lat').val());
    formData.append('lng', $('#lng').val());
    formData.append('masuk', $('#masuk').val());
    formData.append('keluar', $('#keluar').val());
    axios.post('{{route("absen.register")}}', formData)
                .then(function (response) {
       $('#tambah-absensi').modal('hide');
        Swal.fire({
        title: 'Sukses!',
        text: response.data.absensi.message_success,
        icon: 'success',
        confirmButtonText: 'OK'
      })
      $('#absenTable').DataTable().ajax.reload();
      $('#karyawan_id').val("")
      $('#tgl').val("")
      $('#lat').val("")
      $('#lng').val("")
      $('#masuk').val("")
      $('#keluar').val("")
      $('#spinner').removeClass('fa-spin fa-spinner');
      $('#spinner').addClass('fa-plus');

  }).catch(function (error) {

    $('#spinner').removeClass('fa-spin fa-spinner');
    $('#spinner').addClass('fa-plus');
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
$('#btn-add').click(function(){
  if((localStorage.getItem("lng") == null) || (localStorage.getItem("lat") == null))
        {
            getGeolocation();
           Swal.fire({
              title: 'Error!',
              text: 'Mohon untuk mengaktifkan lokasi anda.',
              icon: 'error',
              confirmButtonText: 'OK'
            })
          return false;
        }
  $('#lat').val(localStorage.getItem("lat"))
  $('#lng').val(localStorage.getItem("lng"))
  $('#tambah-absensi').modal('show');
})
  
          $('.time').clockpicker({donetext: 'Selesai',autoclose:true});
        $('.select-absen-karyawan').select2({
            dropdownAutoWidth: true,
            dropdownParent: $("#export-absensi"),
            width: '100%',
            ajax: {
                delay: 250,
                url: '{{route("karyawan.getSelectKaryawan")}}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {results: data};
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full
                // code of this example
            }
        });
        $('.select-absen-karyawan-create').select2({
            dropdownAutoWidth: true,
            dropdownParent: $("#tambah-absensi"),
            width: '100%',
            ajax: {
                delay: 250,
                url: '{{route("karyawan.getSelectKaryawan")}}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {results: data};
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full
                // code of this example
            }
        });
        function getGeolocation() {
              if (navigator.geolocation) {
                return navigator.geolocation.getCurrentPosition(showCoordinates);
              } else {
               alert("Browser anda tidak mendukung geolocation, mohon perbaharui browser anda.");
              }
            }
            function showCoordinates(position) {
             console.log(position.coords)
             localStorage.setItem("lat", position.coords.latitude);
             localStorage.setItem("lng", position.coords.longitude);

          }
        $(function() {
          setInterval(function(){ loadStat() }, 5000);

              window.tableAbsen =  $('#absenTable').DataTable({
                    "order": [[ 8, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
                    "emptyTable": "Tidak ada data absensi yang dapat ditampilkan pada bulan ini."
                  },
                    ajax: "{{ route('absen.datatables')}}?tahun={{Request::get('tahun')}}&bulan={{Request::get('bulan')}}&absen_id={{Request::get('absen_id')}}",
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
                            data: 'jam_kerja',
                            name: 'jam_kerja'
                        },
                        {
                            data: 'jam_masuk',
                            name: 'jam_masuk'
                        },
                         {
                            data: 'jam_keluar',
                            name: 'jam_keluar'
                        },
                         {
                            data: 'created_at',
                            name: 'created_at'
                        },
                         {
                            data: 'aksi',
                            name: 'aksi'
                        },
                    ]
                });
            });
      function details(id){
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-eye');
        formData.append('id', id);
        axios.post('{{route("absen.showAbsen")}}', formData)
                .then(function (response) {
                  $("#nama_lengkap").html(response.data.absensi.nama_lengkap)
                  $("#tanggal").html(response.data.absensi.tanggal)
                  $("#jam_masuk").html(response.data.absensi.jam_masuk)
                  $("#jam_keluar").html(response.data.absensi.jam_keluar)
                  $("#jam_kerja").html(response.data.absensi.jam_kerja)
                  $("#ip_address").html(response.data.absensi.ip_address)
                  $("#browser").html(response.data.absensi.browser)
                  $("#platform").html(response.data.absensi.platform)
                  if(response.data.absensi.foto != null)
                  {
                    $("#foto_masuk").attr('src','')
                    $("#foto_masuk").attr('src',response.data.absensi.foto)
                  }
                  if(response.data.absensi.foto_pulang != null)
                  {
                    $("#foto_pulang").attr('src','')
                    $("#foto_pulang").attr('src',response.data.absensi.foto_pulang)
                  }

                  if(response.data.absensi.lat != null && response.data.absensi.lng != null)
                  {
                    loadMap(response.data.absensi.lat, response.data.absensi.lng,'map','addr_masuk')
                  } else{
                     $("#map").html('<div class="alert alert-warning" align="center">Tidak dapat menampilkan peta karena karyawan ini belum melakukan absensi masuk.</div>')
                     $("#addr_masuk").html('<span class="badge badge-warning">Belum melakukan absensi masuk</span>')
                    }
                  if(response.data.absensi.lat_pulang != null && response.data.absensi.lng_pulang != null)
                  {
                  loadMap(response.data.absensi.lat_pulang, response.data.absensi.lng_pulang,'map-pulang','addr_pulang')
                  } else{

                    $("#addr_pulang").html('<span class="badge badge-warning">Belum melakukan absensi pulang</span>')
                    $("#map-pulang").html('<div class="alert alert-warning" align="center">Tidak dapat menampilkan peta karena karyawan ini belum melakukan absensi pulang.</div>')
                  }
                  // $("#map-frame").attr('src',' https://www.bing.com/maps/embed?h=400&w=500&cp='+response.data.absensi.lat+'~'+response.data.absensi.lng+'&lvl=9&typ=d&sty=r&src=SHELL&FORM=MBEDV8')
                  // $("#map-frame").attr('src','https://maps.google.com/maps?q='',&hl=id&z=14&amp;output=embed')
                 $("#detail-absen").modal('show');
                 $("#icon-"+id).addClass('fa-eye').removeClass('fa-spinner fa-spin');
              })
              .catch(function (error) {
                console.log(error)
                $("#icon-"+id).addClass('fa-eye').removeClass('fa-spinner fa-spin');

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
      @Permission(['superadmin'])
      function accAbsen(id){
        Swal.fire({
          title: 'Anda ingin menyetujui absensi ini?',
          showCancelButton: true,
          confirmButtonText: `Setujui`,
        }).then((result) => {
          if (result.isConfirmed) {
          accAbsenAct(id)
          }
        })
      }
      function accAbsenAct(id){
        let formData = new FormData();
        $("#icon-req-"+id).addClass('fa-spinner fa-spin').removeClass('fa-check');
        formData.append('id', id);
        axios.post('{{route("services.notif.accAbsen")}}', formData)
                .then(function (response) {
              $("#icon-req-"+id).addClass('fa-check').removeClass('fa-spinner fa-spin');
              Swal.fire({

                 text: response.data.absensi.message,
                 icon: 'success',
                 confirmButtonText: 'OK'
               })
                 window.tableAbsen.ajax.reload();
              })
              .catch(function (error) {

              $("#icon-req-"+id).addClass('fa-check').removeClass('fa-spinner fa-spin');

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
      @endPermission

      function loadStat()
      {
        let formData = new FormData();
        axios.post('{{route("absen.getDataAbsensiStat")}}', formData)
                .then(function (response) {
                  $("#r_masuk").html(response.data.absensi.absensi_masuk)
                  $(".r_total_karyawan").html(response.data.absensi.total_karyawan)
                  $("#r_keluar").html(response.data.absensi.absensi_keluar)
                  $(".overlay-stat").fadeOut();

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
      function loadMap(lat,lng,element,id_addr) {
           var map = new Microsoft.Maps.Map(document.getElementById(element), {
            // customMapStyle: {
            //       elements: {
            //           area: { fillColor: '#b6e591' },
            //           water: { fillColor: '#75cff0' },
            //           tollRoad: { fillColor: '#a964f4', strokeColor: '#a964f4' },
            //           arterialRoad: { fillColor: '#ffffff', strokeColor: '#d7dae7' },
            //           road: { fillColor: '#ffa35a', strokeColor: '#ff9c4f' },
            //           street: { fillColor: '#ffffff', strokeColor: '#ffffff' },
            //           transit: { fillColor: '#000000' }
            //       },
            //       settings: {
            //           landColor: '#efe9e1'
            //       }
            //     }
          });
          map.setOptions({
            minZoom: 16
          });
          map.setView({
              mapTypeId: Microsoft.Maps.MapTypeId.aerial,
          });
          Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
          var searchManager = new Microsoft.Maps.Search.SearchManager(map);
          var reverseGeocodeRequestOptions = {
              location: new Microsoft.Maps.Location(lat,lng),
              callback: function (answer, userData) {
                 console.log(answer.bestView)
                  map.setView({ bounds: answer.bestView });
                  map.entities.push(new Microsoft.Maps.Pushpin(reverseGeocodeRequestOptions.location,{icon: 'https://www.bingmapsportal.com/Content/images/poi_custom.png',}));
                  document.getElementById(id_addr).innerHTML =
                      answer.address.formattedAddress;
              }
          };
          searchManager.reverseGeocode(reverseGeocodeRequestOptions);
});

        }
      </script>
@endsection
