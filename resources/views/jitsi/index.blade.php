@extends('layouts/master_dashboard')
@section('title','Ruang Meeting')
@section('content')
<a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#create-meet"  ><i class="fas fa-plus mr-2"></i> Buat Meeting</a><hr>
	<div class="row">
    <?php $i=0; ?>
    @foreach($meeting as $m)
    @if(time() < strtotime($m->room_close_at))
    <?php $i++; ?>
		<div class="col-lg-3 col-6">
            <!-- small card -->
            @if(time() >= strtotime($m->room_open_at) AND time() <= strtotime($m->room_close_at))
            <div class="small-box bg-success" >
            @else
            <div class="small-box bg-light">
            @endif
              <div class="inner">
                <h5>{{$m->room_name}}</h5>
            @if($m->updated_by == auth()->user()->id)
                <button type="button"  onclick="event.preventDefault();
          document.getElementById('meet-{{$m->id}}').submit();" class="btn-danger btn btn-xs">
                Hapus
              </button>

                <form
                            id="meet-{{$m->id}}"
                            action="{{ route('meeting.delete') }}"
                            method="POST"
                            style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{$m->id}}">
                        </form>
              @endif
              @if(Agent::isMobile() || Agent::isTablet())
              <a target="_blank"  href="https://api.whatsapp.com/send?text=Kami mengundang anda untuk bergabung dengan meeting {{$m->room_name}} : %0D%0A {{route('meeting.share',['shr_code' => $m->share_code])}}%0D%0A Waktu meeting: %0D%0A {{$m->room_open_at}}  s/d {{$m->room_close_at}}" class="btn-primary btn btn-xs">
              @else
              <a  target="_blank" href="https://api.whatsapp.com/send?text=Kami mengundang anda untuk bergabung dengan meeting {{$m->room_name}} :%0D%0A{{route('meeting.share',['shr_code' => $m->share_code])}}%0D%0A Waktu meeting: %0D%0A {{$m->room_open_at}}  s/d {{$m->room_close_at}}" class="btn-primary btn btn-xs">
              @endif
                Bagikan ke Whatsapp
              </a>
              <hr>

                <small><b>Link dapat dibagikan</b><br><a class="bg-light" href="{{route('meeting.share',['shr_code' => $m->share_code])}}"> {{route('meeting.share',['shr_code' => $m->share_code])}}</a></small><br>

                <small><b>Link publik </b><br><a class="bg-light" href="{{route('pubshare',['shr_code' => $m->share_code])}}"> {{route('pubshare',['shr_code' => $m->share_code])}}</a></small><br>
                <small><b>Oleh</b><br>{{$m->user->name}}</small><br>
                <small><b>Waktu meeting</b><br>{{$m->room_open_at}} <br><b>s/d</b><br>{{$m->room_close_at}} </small><br>

              </div>
              @if(time() >= strtotime($m->room_open_at) AND time() <= strtotime($m->room_close_at))
                @if(empty($m->password))
									@if(empty($m->external_meeting_room))
	                 <a href="{{route('meeting.room',['room_name' => $m->room_code])}}" class="small-box-footer">
	                  Mulai Bergabung
	                </a>
								@else
									<a href="{{$m->external_meeting_room}}" target="_blank" class="small-box-footer">
									Mulai Bergabung
								</a>
								@endif
                @else
                 <a href="#" data-toggle="modal" data-target="#join-meet-{{$m->id}}" class="small-box-footer">
                  Mulai Bergabung
                </a>
                  <form method="POST" action="{{route('meeting.room',['room_name' => $m->room_code])}}">
                  <div class="modal fade" id="join-meet-{{$m->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Mulai Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body  text-dark" >
                               @csrf
                               <label>PIN Ruang Meeting</label>
                                  <input type="text" id="pincode" class="form-control" name="password" required>
                                  <input type="hidden" name="id" value="{{$m->id}}">
                      </div>

                      <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary" submit-button-project><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Mulai </button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

              @endif
              @else
              <span class="small-box-footer text-dark">
                Belum dimulai
              </span>

              @endif

            </div>
          </div>
      @endif
    @endforeach
    @if($i == 0)
    <div class="col-12"><div class="alert alert-warning" align="center">Belum ada meeting disini.</div></div>
    @endif
	</div>

	<form method="POST" id="meeting" action="{{route('meeting.create')}}">
         <div class="modal fade" id="create-meet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Buat Meeting Baru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" >
                         <div class="row">
                            <div class="col-md-12">
                              @csrf
                                <label>Nama Meeting</label>
                                <input type="text" required="" id="edit_name" placeholder="cth: Meeting Mingguan " name="name_room" class="form-control" required="">
                            </div>
                             <div class="col-md-6 col-sm-12">
				                <label>Waktu Mulai</label>
				                <div class="row">
				                  <div class="col-md-6">
				                    <input type="date" id="edit_tanggal" value="{{date('Y-m-d')}}" required name="tanggal_mulai" prequired="" class="form-control">
				                  </div>
				                  <div class="col-md-3">
				                    <input type="text" id="edit_jam" required name="jam_mulai" placeholder="--:--" required="" class="time form-control">
				                  </div>
				                </div>
				            </div>
                             <div class="col-md-6 col-sm-12">
				                <label>Waktu Selesai</label>
				                <div class="row">
				                  <div class="col-md-6">
				                    <input type="date" id="edit_tanggal_selesai" value="{{date('Y-m-d')}}" required name="tanggal_selesai" prequired="" class="form-control">
				                  </div>
				                  <div class="col-md-3">
				                    <input type="text" id="edit_jam_selesai" required name="jam_selesai" placeholder="--:--" required="" class="time form-control">
				                  </div>
				                </div>
				            </div>
										<div class="col-12 mt-2">
											<div class="icheck-primary d-inline">
											<input type="checkbox" id="external-meeting" >
											<label for="external-meeting">
												Gunakan Meeting External
											</label>
											</div>
										</div>
                    <div class="col-md-6" meeting-build-in>
                              @csrf
                                <label>PIN Ruangan</label><small> *Kosongkan jika tidak ingin menggunakan pin</small>
                                <input type="text" id="pincode-2"  name="password" >
                            </div>
                    <div class="col-md-6" style="display:none;" meeting-external>
											<label>Link Meeting Eksternal</label>
											<input class="form-control" placeholder="cth: https://meet.google.com/xxx-xxx-xxxx" name="external_link" id="external_link" disabled>
                    </div>
                            <div class="col-md-12">

                                <label>Deskripsi</label>
                                <textarea class="form-control" placeholder="Penjelasan meeting atau Agenda Meeting" name="deskripsi" style="min-height: 200px;"></textarea>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary" submit-button-project><i spinner style="display: none;" class="fas fa-spinner fa-spin"></i> Buat Meeting</button>
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
      </form>
      <link rel="stylesheet" href="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.css')}}">
      <script src="{{asset('assets/timepicker/dist/bootstrap-clockpicker.min.js')}}"></script>

        <link rel="stylesheet" href="{{asset('assets/pin-code/css/bootstrap-pincode-input.css')}}">
    <script src="{{asset('assets/pin-code/js/bootstrap-pincode-input.js')}}"></script>
      <script type="text/javascript">
      	 $('.time').clockpicker({donetext: 'Selesai',autoclose:true});
         $('#pincode').pincodeInput({inputs:6});
         $('#pincode-2').pincodeInput({inputs:6});
      </script>
@endsection
@section('javascript')
	<script>
		$('#external-meeting').change(function(e){
			if($(this).is(':checked'))
			{
				$('[meeting-build-in]').hide()
				$('[meeting-external]').show()
				$('#external_link').attr('disabled',false)
			} else{
				$('[meeting-build-in]').show()
				$('[meeting-external]').hide()
				$('#external_link').attr('disabled',true)
			}

		})
	</script>
@endsection
