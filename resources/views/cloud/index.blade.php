@extends('layouts/master_dashboard')
@section('title','Penyimpanan Online ')
@section('subtitle',$project->name." (".$project->client.")")
@section('content')
	<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active " href="{{route('cloud',['project_id' => Request::route('project_id')])}}" role="tab"  >File Publik</a>
      </li>
      {{-- <li class="nav-item ">
        <a class="nav-link  " href="{{route('cloud.private',['project_id' => Request::route('project_id')])}}"  role="tab" >File Privat</a>
      </li> --}}

      {{-- <li class="nav-item ">
        <a class="nav-link  " href="{{route('cloud.private')}}"  role="tab" >Tempat Sampah</a>
      </li> --}}
    </ul>


	<div class="row mt-3">
		<div class="col-md-3 col-12">
				<a href=""  data-toggle="modal" data-target="#uploadModal" class="btn btn-success btn-block">Upload File</a>
		</div>
	</div>
	<hr>
	<div class="row">
		@foreach($cloud as $c)

		<div class="col-md-3 col-12">
				<a href="#file-{{$c->id}}" details-show file-id="{{$c->id}}" action-form="{{route('cloud.download',['url' => $c->url_name])}}" password="{{$c->password != null ? "1":"0"}}">
			<div id="file-{{$c->id}}" style="background:url('{{\App\Helpers\Cloud::background($c->category->category,$c->id)}}');background-size:cover; color:#000 !important;" class="card card-outline card-secondary shadow-sm">
				<div class="card-body border border-secondary">
					<h5>{{$c->name}}</h5>
					<small>Kategori : {{$c->category->category}}</small><br>
					<small>Ukuran : {{\App\Helpers\Cloud::formatBytes($c->size)}}</small><br>
				</div>

			</div>
			</a>
		</div>


	@endforeach
	@if(count($cloud) < 1)
	<div class="col-12">
		<div align="center" class="alert alert-info">
			Belum ada dokumen disini.
		</div>
	</div>
	@endif

	</div>
<form enctype='multipart/form-data' action="{{route('cloud.save')}}" method="POST">
	@csrf
		 <input type="hidden" name="project_id" value="{{Request::route('project_id')}}">
	<div class="modal fade " id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
			<div class="modal-content">
		 <div class="modal-header">
			 <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">&times;</span>
			 </button>
		 </div>
		 <div class="modal-body">
			 <div class="row">
				 <div class="col-md-12">
					 <div class="form-group">
						 <label for="name" class="col-form-label">Nama:</label>
						 <input type="text" class="form-control" name="nama" placeholder="cth: Dokumen Analisis Sistem Informasi Management Rumah Sakit" id="name">
					 </div>
				 </div>

				 {{-- <div class="col-md-6" style="display:none">

						<label class="col-form-label">Projek</label>
					 <select name="project_id_D" id="lproject" class="select-project form-control">
					 </select>

				 </div> --}}
				 <div class="col-md-6">

					<div class="form-group">
						<label for="category" class="col-form-label">Kategori:</label>
					 <select name="kategori" id="category" class="form-control">
						 <option>Pilih Salah Satu</option>
						 @foreach($category as $c)
							 <option value="{{$c->id}}">{{$c->category}}</option>
						 @endforeach
					 </select>
					</div>
				</div>
			 </div>

			 	 <div class="row">
					<div class="col-md-6">
						<div class="custom-control custom-checkbox">
                          <input class="custom-control-input" name="pwdcheck" value="1" type="checkbox" id="pwdcheck">
                          <label for="pwdcheck" class="custom-control-label">Aktifkan Password File</label>
                        </div>
					</div>
				 </div>

			 <div class="row" id="pwdForm" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
					 <label for="password" class="col-form-label">Password:<small> Minimal 8 Karakter</small></label>
					 <input type="password" placeholder="Kata Sandi" disabled class="form-control" name="password" id="password">


				 </div>
				 </div>
				 <div class="col-md-6">
					<div class="form-group">
						<label for="cpassword" class="col-form-label">Konfirmasi Kata Sandi:</label>
					 <input type="password" placeholder="Konfirmasi Kata Sandi" disabled class="form-control" name="password_confirmation" id="cpassword">


				 </div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">

				 <div class="form-group">

						 <div class="form-group">

											<label for="fileinput" class="col-form-label">Pilih File: <small>Maksimal 50MB</label>
												<div class="alert alert-warning" id="alertfile" style="display:none;">Ukuran file melebihi yang diizinkan</div>
											<div class="input-group">
												<div class="custom-file">
													<input type="file" name="file" class="custom-file-input" id="fileinput">
													<label class="custom-file-label" id="file-select" for="exampleInputFile">Pilih File...</label>
												</div>
												{{-- <div class="input-group-append">
													<span class="input-group-text" id="">Upload</span>
												</div> --}}
											</div>
										</div>
				 </div>
			 </div>
			</div>

			<div class="row">
			 <div class="col-md-6">
				 <hr>
				 <div class="custom-control custom-checkbox">
											 <input class="custom-control-input"  name="private" value="1" type="checkbox" id="private">
											 <label for="private" class="custom-control-label">Hanya Saya Saja yang dapat melihat file ini</label>
										 </div>
			 </div>
			</div>




		 </div>
		 <div class="modal-footer">
			 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			 <button type="submit" id="submit-btn" class="btn btn-primary">Upload</button>
		 </div>
	 </div>
	  </div>
	</div>
</form>
<form enctype='multipart/form-data' action="" id="form-file" method="POST">
	@csrf
	<div class="modal fade " id="detailFile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
			<div class="modal-content">
		 <div class="modal-header">
			 <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">&times;</span>
			 </button>
		 </div>
		 <div class="modal-body">
			<div class='row'>

				<div class="col-md-12">
					<input type="hidden" value="" id="id-file">
					<button delete-file type="button" class="btn btn-block btn-outline-danger"><i class="fas fa-spin fa-spinner icon-file" style="display:none;"> </i> Hapus File</button>
				</div>
			</div>
			<hr>
			<div class='row'>
				<div class="col-md-12">
					@csrf
					<button type="submit" class="btn btn-block btn-success">Download File</button>
				</div>

			</div>
		 </div>
		 {{-- <div class="modal-footer">
			 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			 <button type="submit" id="submit-btn" class="btn btn-primary">Upload</button>
		 </div> --}}
	 </div>
	  </div>
	</div>
</form>

<form enctype='multipart/form-data' action="" id="form-file-pwd" method="POST">
	@csrf
	<div class="modal fade " id="detailFile-pwd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
			<div class="modal-content">
		 <div class="modal-header">
			 <h5 class="modal-title" id="exampleModalLabel">File Terenkripsi</h5>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">&times;</span>
			 </button>
		 </div>
		 <div class="modal-body">
			 <div class='row'>

 				<div class="col-md-12">
 					<input type="hidden" value="" id="id-file">
 					<button delete-file type="button" class="btn btn-block btn-outline-danger"><i class="fas fa-spin fa-spinner icon-file" style="display:none;"> </i> Hapus File</button>
 				</div>
 			</div>
			<hr>
			<div class='row'>
				<div class="col-md-12">
					@csrf
					<label>Masukan Kata Sandi</label>
					<input type="password" autocomplete="off" name='password' placeholder="Masukan Kata Sandi File" class='form-control'>
					<hr>
					<button type="submit" class="btn btn-block btn-success">Download File</button>
				</div>

			</div>
		 </div>
		 {{-- <div class="modal-footer">
			 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			 <button type="submit" id="submit-btn" class="btn btn-primary">Upload</button>
		 </div> --}}
	 </div>
	  </div>
	</div>
</form>

@endsection
@section('javascript')
<script>
$(function(){
	@if(Request::get('upload'))
	// $('#uploadModal').modal('show');
	@endif
})
$('[details-show]').click(function(e){
	e.preventDefault();
	if($(this).attr('password') == 1)
	{
		$('#form-file-pwd').attr('action',$(this).attr('action-form'))
		$('#id-file').val($(this).attr('file-id'))
		$('#detailFile-pwd').modal('show');
		return true;
	}

	$('#form-file').attr('action',$(this).attr('action-form'))
	$('#detailFile').modal('show');
	return true;

})

$("#pwdcheck").change(function(e)
	{
		if($(this).is(':checked'))
		{
			$('#pwdForm').slideDown();
			$('#password').prop('disabled',false);
			$('#cpassword').prop('disabled',false);
		} else{
			$('#pwdForm').slideUp();
				$('#cpassword').prop('disabled',true);
				$('#password').prop('disabled',true);
		}
	});
	$('#fileinput').change(function(e)
	{
		var filename = $(this).val().split('\\').pop();
		var file_size = $('#fileinput')[0].files[0].size;
			if(file_size>51100000) {
				$('#alertfile').fadeIn();
				$('#submit-btn').prop('disabled',true);
				return false;
			} else{
				$('#alertfile').fadeOut();
				$('#submit-btn').prop('disabled',false);
			}
		$('#file-select').html(filename)
	})
	$('#lproject').select2({
	  width: '100%',
	  dropdownAutoWidth: true,
	  dropdownParent: $("#uploadModal"),
	  ajax: {
	    delay: 250,
	    url: '{{route("project.select")}}',
	    dataType: 'json',
	     data: function (params) {
	        var query = {
	            search: params.term,
	          }
	          return query;
	    },
	       processResults: function (data) {
	      return {
	        results: data
	      };
	    }
	  }
	});
$('[delete-file]').click(function(){
	// {{route('cloud.delete')}}
	Swal.fire({
		title: 'Anda ingin menghapus file ini?',
		showCancelButton: true,
		confirmButtonText: `Hapus`,
	}).then((result) => {
		if (result.isConfirmed) {
			deleteAct($('#id-file').val());
		}
	})
	function deleteAct(id){
		// alert("ok");
		$('[delete-file]').attr('disabled',true);
		$('.icon-file').show()
		let formData = new FormData();
		formData.append('id', id);

		formData.append('project_id', "{{Request::route('project_id')}}");
		axios.post('{{route("cloud.delete")}}', formData)
						.then(function (response) {
							$('[delete-file]').attr('disabled',false);
							$('.icon-file').hide()
							 toastr.success(response.data.file.messages)
						location.reload();
					})
					.catch(function (error) {
						$('[delete-file]').attr('disabled',false);
					$('.icon-file').hide()
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
})
</script>
@endsection
