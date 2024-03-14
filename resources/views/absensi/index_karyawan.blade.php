@extends('layouts/master_dashboard')
@section('title','Absensi Detail '.'Bulan '.Calendar::indonesiaMonth(empty(Request::get('bulan'))?date('m'):Request::get('bulan'),true) )
@section('subtitle')
<hr>
<div class="row">
  <div align="center" class="mb-3 col-xs-12 col-md-1"><img loading="lazy" src="{{route('showFotoKaryawan',['file' => empty($karyawan->foto)?'default.jpg':$karyawan->foto])}}"  data-action="zoom" class="img-fluid"></div>
  <div class="col-md-3 col-xs-12">
  <h6>
    <table class="table">
      <tr>
        <td>NIK</td>
        <td>{{$karyawan->nip}}</td>
      </tr> 
      <tr>
        <td>Nama</td>
        <td>{{$karyawan->nama_lengkap}}</td>
      </tr> 
      <tr>
        <td>Jabatan</td>
        <td>{{$karyawan->jabatan->nama}}</td>
      </tr> 
      <tr>
        <td>Tgl Bergabung</td>
        <td>{{$karyawan->join_date}}</td>
      </tr>
      @if(!empty($karyawan->resign_date))
      <tr>
        <td>Tgl Resign</td>
        <td>{{$karyawan->resign_date}}</td>
      </tr>
      @endif
    </table>
  </h6>
  </div>
</div> 



@endsection
@section('content')
<div id="absensi-content">
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
            @if(empty($karyawan->id))
              <div class="alert alert-warning" align="center"><i class="fas fa-exclamation-triangle"></i> Akun anda belum terhubung dengan data karyawan.</div>
            @endif
            @error('start_date')
              <div class="alert alert-danger" align="center">{{ $message }}</div>
            @enderror
            @error('end_date')
              <div class="alert alert-danger" align="center">{{ $message }}</div>
            @enderror
        </div>
         @if(!empty($karyawan->id))
        <div class="col-md-12 col-sm-12">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box" id="total_absen">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total kehadiran bulan {{Calendar::indonesiaMonth(empty(Request::get('bulan'))?date('m'):Request::get('bulan'),true)}}</span>
                <span class="info-box-number">
                  <span id="t_kehadiran">0</span>
                </span>
              </div>
               <div class="overlay overlay-stat" >
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box clearfix mb-3" id="total_r_jam_kerja_bulan">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rata-rata jam kerja bulan {{Calendar::indonesiaMonth(empty(Request::get('bulan'))?date('m'):Request::get('bulan'),true)}}</span>
                <span class="info-box-number">
                 <span id="r_jam_kerja_bulan">0</span>
                </span>
              </div>
                <div class="overlay overlay-stat" >
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3" id="total_r_jam_kerja">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rata-rata jam kerja</span>
                <span class="info-box-number">
                <span id="r_jam_kerja">0</span>
                </span>
              </div>
               <div class="overlay overlay-stat" >
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
        </div>
        <div class="col-12">
         {!! Calendar::absenGenerate((empty(Request::get('bulan'))? date('m'):Request::get('bulan')),(empty(Request::get('tahun'))? date('Y'):Request::get('tahun')),$karyawan->id)!!}
         <label>Keterangan</label>
          <br>
          <div class="row">
            <div class="col-md-4 col-xs-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-12">
                             <span class="bg-navy border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Cuti
                          </div>
                          <div class="col-md-12"></div>
                          <div class="col-md-12">
                            <span class="bg-indigo border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Sakit
                          </div>
                          <div class="col-md-12"></div>
                          <div class="col-md-12">
                            <span class="bg-orange border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Izin
                          </div>
                          
                      </div>
                    </div> 


                    <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-12">
                            <span class="bg-light border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Tidak Absen
                          </div>
                          <div class="col-md-12"></div>
                          <div class="col-md-12">
                            <span class="bg-warning border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Tidak Absen keluar
                          </div>
                          <div class="col-md-12"></div>
                          <div class="col-md-12">
                            <span class="bg-success border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Telah Absen
                          </div>
                          <div class="col-md-12"></div>
                          <div class="col-md-12">
                            <span class="bg-info border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Libur
                          </div>
                        </div>
                        </div>
                    </div>
                   
                  </div>
          </div>
          </div>
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
        <div class="col-12">
          <hr>
            <div class="table-responsive-sm">
            <table class="table  table-bordered table-hover" id="absenTable">
                <thead>
                    <th>Foto</th>

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
        @endif

    </div>
    </div>


@endsection

@section('javascript')
  <link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
  <script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>

@if(!empty($karyawan->id))
  <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?key=AgCRMh3Aq-zhk5GKgMC9NX25AHTnH5RjDbJ5zJapwOVhaynZu-iQl4YK28aVzJig&callback=loadMapScenario' async
        defer></script>
 <script type="text/javascript">
// $('#absensi-content').click(function(e){
//   $('.jam').hide()
//   $('.actabsen').show()
// })
function requestAbsen(id)
{
  $('.jam').attr('disabled',true);
  $('#icon-absen-'+id).show()
  let formData = new FormData();
  formData.append('id', id);
  formData.append('jam', $('#input-jam-'+id).val());
  axios.post('{{route("absen.keluar.request")}}', formData)
          .then(function (response) {
              $('.jam').attr('disabled',false);
              $('#icon-absen-'+id).hide()
              Swal.fire({
                 // title: 'Error!',
                 text: response.data.absensi.message,
                 icon: 'success',
                 confirmButtonText: 'OK'
               })
        window.tableSelf.ajax.reload();
          // location.reload();
        })
        .catch(function (error) {
          $('.jam').attr('disabled',false);
        $('#icon-absen-'+id).hide()
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

        $(function() {

              loadStat();
          // $("#total_absen").loading({theme: 'light',message: 'Memuat...'});
          // $("#total_r_jam_kerja_bulan").loading({theme: 'light',message: 'Memuat...'});
          // $("#total_r_jam_kerja").loading({theme: 'light',message: 'Memuat...'});
    window.tableSelf = $('#absenTable').DataTable({
                    "order": [[ 5, "desc" ]],
                    processing: true,
                    serverSide: true,
                    autoWidth:false,
                    "language": {
                    "processing": "<i class='fas fa-spinner fa-spin fa-1x'></i> Sedang mengambil data...",
                    "emptyTable": "Tidak ada data absensi yang dapat ditampilkan pada bulan ini."
                  },
                  "initComplete": function(settings, json) {
                      $('.time').clockpicker({donetext: 'Selesai',placement: 'top',autoclose:true});
                      $('[show-req-absen]').click(function(event) {
                                 event.stopPropagation();
                                 var id = $(this).attr('absen-id')
                                 $('#btnabsen-'+id).hide();
                                 $('#jam-'+id).show();
                             });
                      $('.jam').click(function(event) {
                                 event.stopPropagation();
                             });

                  },
                    ajax: "{{ route('absensi.api.karyawan')}}?tahun={{Request::get('tahun')}}&bulan={{Request::get('bulan')}}&karyawan_id={{$karyawan->id}}",
                    columns: [{
                            data: 'foto',
                            name: 'foto'
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
      function loadStat()
      {
        let formData = new FormData();
        axios.get('{{route("absen.getDataAbsenStatKaryawan")}}?tahun={{Request::get('tahun')}}&bulan={{Request::get('bulan')}}&karyawan_id={{$karyawan->id}}', formData)
                .then(function (response) {
                  $("#t_kehadiran").html(response.data.absensi.kehadiran_bulan_ini)
                  $("#r_jam_kerja_bulan").html(response.data.absensi.avg_jam_kerja_bln)
                  $("#r_jam_kerja").html(response.data.absensi.avg_jam_kerja)
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
      function details(id){
        let formData = new FormData();
        $("#icon-"+id).addClass('fa-spinner fa-spin').removeClass('fa-eye');
        formData.append('id', id);
        axios.post('{{route("absen.showAbsenKaryawan")}}', formData)
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
@endif
@endsection
