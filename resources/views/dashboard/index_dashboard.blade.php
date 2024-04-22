@extends('layouts/master_dashboard')
@section('content')
	<div class="row justify-content-md-center">
		<div class="col-md-6" id="camera" align="center" style="background-color:chocolate;border-radius:3%;">
			<span style="font-size: 16px; color: white; font-weight: bold;" id="time"></span>
			<div id="cam_absensi"></div>
	<form>
		<button type='button' class="btn btn-primary btn-block"  onClick="take_snapshot()"><i class="fas fa-check ml-3"></i> Absen</button>
	</form>
		</div>

	</div>
	

	 
@endsection

@section('javascript')
@if(Agent::isDesktop() || Agent::isTablet())
<script type="text/javascript">


	$(document).ready(function() {
		$.ajax({ 
            type : 'get',
            url : "{{ url('absen/cek_lokasi')}}",
            data:{'lat': localStorage.getItem("lat"),lng: localStorage.getItem("lng")}, 
            success:function(tampil){
				console.log(tampil);
				if(tampil == 'berhasil'){
					Webcam.set({
						width: 500,
						height: 375,
						image_format: 'jpeg',
						jpeg_quality: 90
					});
					Webcam.attach( '#cam_absensi' );
				}else if(tampil == 'belum_acc'){
					Swal.fire({
						title: 'Anda sudah melakukan pengajuan absen diluar tempat kerja. Silahkan hubungi admin untuk tindak lanjutnya',
					});
				}else if(tampil == 'ditolak'){
					Swal.fire({
						title: 'Mohon maaf untuk absen di luar kantor di tolak oleh admin',
					});
				}else if(tampil == 'belum_terhubung_karyawan'){
					Swal.fire({
						title: 'Akun anda belum terhubung dengan karyawan. Silahkan menghubungi admin',
					});
				}else{
					Swal.fire({
						title: 'Error!',
						input: "text",
						text: 'Anda sedang diluar daerah kerja',
						icon: 'error',
						confirmButtonText: 'Kirim'
					}).then((result) => {
						$.ajax({ 
							type : 'get',
							url : "{{ url('absen/cek_lokasi')}}",
							data:{'data': result.value,'jenis': 'kirim_alasan'}, 
							success:function(tampil){
								console.log(result)
								
								if (result.isConfirmed) {
									Swal.fire({
									title: 'Alasan anda sudah terkirim. silahkan follow up ke admin',
									showConfirmButton: false,
									footer: '<a class="btn btn-primary" href="">Klik disini untuk merefresh halaman</a>'
									});
								}
							}
						});
					});
				}
            } 
        })
	});
</script>
@else
<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({ 
            type : 'get',
            url : "{{ url('absen/cek_lokasi')}}",
            data:{'lat': localStorage.getItem("lat"),lng: localStorage.getItem("lng")}, 
            success:function(tampil){
				console.log(tampil);
				if(tampil == 'berhasil'){
					Webcam.set({
						width: 375,
						height: 500,
						image_format: 'jpeg',
						jpeg_quality: 90
					});
					
					Webcam.attach( '#cam_absensi' );
				}else if(tampil == 'belum_acc'){
					Swal.fire({
						title: 'Anda sudah melakukan pengajuan absen diluar tempat kerja. Silahkan hubungi admin untuk tindak lanjutnya',
					});
				}else if(tampil == 'ditolak'){
					Swal.fire({
						title: 'Mohon maaf untuk absen di luar kantor di tolak oleh admin',
					});
				}else if(tampil == 'belum_terhubung_karyawan'){
					Swal.fire({
						title: 'Akun anda belum terhubung dengan karyawan. Silahkan menghubungi admin',
					});
				}else{
					Swal.fire({
						title: 'Error!',
						input: "text",
						text: 'Anda sedang diluar daerah kerja',
						icon: 'error',
						confirmButtonText: 'Kirim'
					}).then((result) => {
						$.ajax({ 
							type : 'get',
							url : "{{ url('absen/cek_lokasi')}}",
							data:{'data': result.value,'jenis': 'kirim_alasan'}, 
							success:function(tampil){
								console.log(result)
								
								if (result.isConfirmed) {
									Swal.fire({
									title: 'Alasan anda sudah terkirim. silahkan follow up ke admin',
									showConfirmButton: false,
									footer: '<a class="btn btn-primary" href="">Klik disini untuk merefresh halaman</a>'
									});
								}
							}
						});
					});
				}
            } 
        })
	});
</script>
@endif
	<script language="javascript">
var timeDisplay = document.getElementById("time");


function refreshTime() {
  var dateString = new Date().toLocaleString("id-ID", {timeZone: "Asia/Jakarta"});
  var formattedString = dateString.replace(", ", " - ");
  timeDisplay.innerHTML = formattedString;
}

setInterval(refreshTime, 1000);

		@if(Agent::is("Mac OS"))
		function take_snapshot() {
			
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				var geo = getGeolocation();
				if.((geo.coords.latitude == null) || (geo.coords.longitude == null))
				{
					 Swal.fire({
						  title: 'Error!',
						  text: 'Tidak dapat mengambil lokasi anda saat ini, mohon izinkan website ini untuk mengakses lokasi anda.',
						  icon: 'error',
						  confirmButtonText: 'OK'
						})
					return false;
				} else{
					$("#camera").loading({theme: 'dark',message: 'Memproses...'});
					axios.post('{{route("absen.doAbsen")}}', {
					    lat: localStorage.getItem("lat"),
					    lng:  localStorage.getItem("lng"),
					    img:  data_uri,
					    token_absen:  "{{session('absen_token')}}",
					  })
					  .then(function (response) {
					  	$("#camera").loading('stop');
					    Toast.fire({
							  icon: 'success',
							  title: 'Berhasil melakukan absensi'
							})
							$(".item-sidebar").slideDown();
					  })
					  .catch(function (error) {
					  	$("#camera").loading('stop');
					  	// console.log(error);
					  	if(error.response.status == 500)
					  	{
					  		 Swal.fire({
							  title: 'Error!',
							  text: 'Internal Server Error',
							  icon: 'error',
							  confirmButtonText: 'OK'
							})
					  	} else {
					  		 Swal.fire({
							  title: 'Absensi!',
							  text: error.response.data.errors,
							  icon: 'warning',
							  confirmButtonText: 'OK'
							})
					  	}
					     
					  });
					  	

				}
			} );
		}
		@else
		function take_snapshot() {
			
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				if((localStorage.getItem("lng") == null) || (localStorage.getItem("lat") == null))
				{
					 Swal.fire({
						  title: 'Error!',
						  text: 'Tidak dapat mengambil lokasi anda saat ini, mohon izinkan website ini untuk mengakses lokasi anda.',
						  icon: 'error',
						  confirmButtonText: 'OK'
						})
					return false;
				} else{
					$("#camera").loading({theme: 'dark',message: 'Memproses...'});
					axios.post('{{route("absen.doAbsen")}}', {
					    lat: localStorage.getItem("lat"),
					    lng:  localStorage.getItem("lng"),
					    img:  data_uri,
					    token_absen:  "{{session('absen_token')}}",
					  })
					  .then(function (response) {
					  	$("#camera").loading('stop');
					  	$(".item-sidebar").slideDown();
					    Toast.fire({
							  icon: 'success',
							  title: 'Berhasil melakukan absensi'
							})

					  })
					  .catch(function (error) {
					  	$("#camera").loading('stop');
					  	// console.log(error);
					  	if(error.response.status == 500)
					  	{
					  		 Swal.fire({
							  title: 'Error!',
							  text: 'Internal Server Error',
							  icon: 'error',
							  confirmButtonText: 'OK'
							})
					  	} else {
					  		 Swal.fire({
							  title: 'Absensi!',
							  text: error.response.data.errors,
							  icon: 'warning',
							  confirmButtonText: 'OK'
							})
					  	}
					     
					  });
					  	

				}
			} );
		}
		@endif
	</script>
	@endsection