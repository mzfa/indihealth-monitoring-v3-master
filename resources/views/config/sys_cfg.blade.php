@extends('layouts/master_dashboard')
@section('title','Atur Aplikasi')
@section('content')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<form id="form-config" action="{{route('config.sys.save')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <label>Kunci Fitur Jika belum melakukan Absensi Masuk</label>
                </div>
                <div class="col-md-12">
                    <input type="checkbox" value="1" name="autolock" @if($config->autolock) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Non-Aktif" data-onstyle="success" data-offstyle="secondary" data-size="sm">
                </div>
            </div>
            
            <!--   <div class="row mt-3">
                <div class="col-md-12">
                    <label>Background Halaman Login</label>
                </div>
                <div class="col-md-12">
                    
                    <input type="file" id="file" class="form-control">
                </div>
            </div> -->
            <!--  <div class="row mt-3">
                <div class="col-md-12">
                    
                    <label>Brand Logo Dashboard</label>
                </div>
                <div class="col-md-12">
                    <input type="file" id="file" class="form-control">
                </div>
            </div> -->
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12"><h4><b>Geofence</b></h4><small>Fitur ini untuk membatasi absensi hanya di daerah tertentu atau sekitar tempat bekerja.</div>
        <div class="col-md-6">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" value="1" name="geofence"  id="toggle-geofence" @if($data->status == 1) checked @endif>
                            <label class="custom-control-label" for="toggle-geofence">Aktifkan GeoFence</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="geofence-cfg" @if($data->status != 1) style="display:none;" @endif>
                <div class="row">
                    
                    <div class="col-md-6 col-xs-12">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" name="status_absen_dirumah" type="checkbox" id="absen-rumah" value="1" @if($data->status_absen_dirumah == 1) checked @endif>
                            <label for="absen-rumah" class="custom-control-label">Aktifkan Absensi dari Rumah Karyawan</label><br>
                            <small>Jika diaktifkan maka karyawan dapat absensi dari rumah.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Radius Absensi dari rumah (meter)</label><br>
                            </div>
                            <div class="col-md-12 col-xs-12" >
                                <input type="number" value="{{ $data->radius_rumah }}" min="0" max="5000" id="radius_rumah" name="radius_rumah" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <label>Radius Absensi dari lokasi (meter)</label><br>
                    </div>
                    <div class="col-md-12 col-xs-12" >
                        <input type="number" value="{{ $data->radius_kantor }}" min="0" max="8000" id="radius_kantor" name="radius_kantor" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label>Longitude</label><br>
                    </div>
                    <div class="col-md-12 col-xs-12" >
                        <input type="text" id="long" name="long" value="{{ $data->long }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label>Latitude</label><br>
                    </div>
                    <div class="col-md-12 col-xs-12" >
                        <input type="text" id="lat" name="lat" value="{{ $data->lat }}" class="form-control">
                    </div>
                </div>
                
                {{-- <div class="row">
                    <div class="col-md-12">
                        <label>Pilih Alamat Tempat Bekerja</label>
                    </div>
                    <div class="col-md-4 col-xs-12" >
                        <input type="text" value=""  id="addr_kantor" name="addr_kantor" class="form-control">
                        <button type="button" class="btn btn-success mt-2 btn-sm" id="getLatLng">Cari</button>
                        <button type="button" class="btn btn-primary mt-2 btn-sm" id="getSelf">Lokasi Sekarang</button>
                    </div>
                    <div class="col-md-12 col-xs-12" >
                        <div id="map" style='width: 100%; height: 300px'>
                            
                        </div>
                        
                    </div>
                </div> --}}
            </div>
            
            <!--   <div class="row mt-3">
                <div class="col-md-12">
                    <label>Background Halaman Login</label>
                </div>
                <div class="col-md-12">
                    
                    <input type="file" id="file" class="form-control">
                </div>
            </div> -->
            <!--  <div class="row mt-3">
                <div class="col-md-12">
                    
                    <label>Brand Logo Dashboard</label>
                </div>
                <div class="col-md-12">
                    <input type="file" id="file" class="form-control">
                </div>
            </div> -->
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-success btn-block" type="submit">Simpan Perubahan</button>
        </div>
    </div>
</form>
@endsection
@section('javascript')

  <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?key=AgCRMh3Aq-zhk5GKgMC9NX25AHTnH5RjDbJ5zJapwOVhaynZu-iQl4YK28aVzJig&callback=loadMapScenario' async
        defer></script>

        <script>
            $(function(){
              
                // loadMap('map','addr_kantor',);
                getLatLng("ITB")
                // var search = new Microsoft.Maps.Search.SearchManager(map);
                    $('#toggle-geofence').change(function(){
                        if($(this).is(':checked')){
                             $('#geofence-cfg').slideDown();
                        } else{
                            $('#geofence-cfg').slideUp();
                        }
                       
                        
                    }) 
                // console.log(search.geocode({where:"Institut Teknologi Bandung", count:10, callback:geocodeCallback}));
            })

            $('#getLatLng').click(function(){
                getLatLng($('#addr_kantor').val());
            })  

             $('#getSelf').click(function(){
                // var geo = getGeolocation();
                if((localStorage.getItem("lat") == null) || (localStorage.getItem("lng") == null))
                {
                     Swal.fire({
                          title: 'Error!',
                          text: 'Tidak dapat mengambil lokasi anda saat ini, mohon izinkan website ini untuk mengakses lokasi anda.',
                          icon: 'error',
                          confirmButtonText: 'OK'
                        })
                    return false;
                } else{
                    loadMap('map',localStorage.getItem("lat"), localStorage.getItem("lng"),$('#radius').val());    
                   
                }
                
            }) 



            $('#radius').change(function(){
                getLatLng($('#addr_kantor').val());
            })

            function getLatLng(string)
            {
                axios.post('{{route('services.getLatLng')}}',{ address: string })
                  .then(function (response) {
                    // handle success
                    if(response.data.status)
                    {
                        loadMap('map',response.data.lat,response.data.lng,$('#radius').val());
                    }else{

                                   Swal.fire({
                                      title: 'Error!',
                                      text: response.data.message,
                                      icon: 'warning',
                                      confirmButtonText: 'OK'
                                    })
                    }
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                
            }
             function loadMap(element,lat,lng,$radius) {
          map = new Microsoft.Maps.Map(document.getElementById("map"), {
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
            minZoom: 16,
            // maxZoom: 1
          });
         map.setView({
              mapTypeId: Microsoft.Maps.MapTypeId.aerial,
          });

          Microsoft.Maps.loadModule(
                'Microsoft.Maps.SpatialMath',
                function () {
                    // Get locations of a regular hexagon, 5 miles from each vertex the map center
                    var locations = Microsoft.Maps.SpatialMath.getRegularPolygon(new Microsoft.Maps.Location(lat,lng), $radius, 1000, Microsoft.Maps.SpatialMath.DistanceUnits.Meters);
                    var polygon = new Microsoft.Maps.Polygon(locations, null);
                    map.entities.push(polygon);
                }
            );
          
          Microsoft.Maps.loadModule(
            'Microsoft.Maps.Traffic',
            function () {
                var manager = new Microsoft.Maps.Traffic.TrafficManager(map);
                manager.show();
            }
        );

          Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
          var searchManager = new Microsoft.Maps.Search.SearchManager(map);
          var reverseGeocodeRequestOptions = {
              location: new Microsoft.Maps.Location(lat,lng),
              callback: function (answer, userData) {
                 // console.log(answer.bestView)
                 map.setView({ bounds: answer.bestView });
                 map.entities.push(new Microsoft.Maps.Pushpin(reverseGeocodeRequestOptions.location,{icon: 'https://www.bingmapsportal.com/Content/images/poi_custom.png',}));
                 
              }
          };
          searchManager.reverseGeocode(reverseGeocodeRequestOptions);
            });
      }
        </script>
@endsection