@extends('layouts/master_dashboard')
@section('title', $meet->room_name)
@section('content')
@if(session('meet-auth-'.$meet->id))
<div class="row">
    <div class="col-md-7">
        <div class="overlay  h-100" style="min-height:500px;"  id="loader-jitsi">
            <span class="text-primary"><i class="fas fa-2x fa-spinner fa-spin mr-3"></i>Memuat Ruang Meeting...</span>
        </div>
        <div id="meet" style="display:none;"></div>
    </div> 
    <div class="col-md-5">
        <div class="card h-100"> 
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Chat</button>
                        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Daftar Hadir</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane h-100 fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="">
                            <div class="chatbox">
                                <div class="top-bar">
                                    <div class="avatar"><p>M</p></div>
                                    <div class="name">Indihealth</div>
                                    <!-- <div class="icons">
                                        <i class="fas fa-phone"></i>
                                        <i class="fas fa-video"></i>
                                    </div> -->
                                    <div class="menu mr-4">
                                        <div class="dots"></div>
                                    </div>
                                    </div>
                                    <div class="middle">
                                    <div class="voldemort">
                                        <div class="incoming">
                                        <div class="bubble">Hey, Father's Day is coming up..</div>
                                        <div class="bubble">What are you getting.. Oh, oops sorry dude.</div>
                                        </div>
                                        <div class="outgoing">
                                        <div class="bubble lower">Nah, it's cool.</div>
                                        <div class="bubble">Well you should get your Dad a cologne. Here smell it. Oh wait! ...</div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="bottom-bar">
                                        <div class="chat">
                                            <p class="image_upload mt-3">
                                                <label for="userImage">
                                                <a class="btn btn-light btn-sm" rel="nofollow"> <img src="https://telemedicine-internal.indihealth.com/assets/dashboard/img/file.png" alt=""></a>
                                                </label>
                                                <input type="file" name="userImage" id="userImage" accept=".jpg,.jfif,.jpeg,.png,.txt,.docx,.doc,.pdf">
                                            </p>
                                            <input class="ml-3" type="text" placeholder="Type a message..." />
                                            <button class="mr-5 button-chat" type="submit"><i class="fas fa-paper-plane"></i></button>
                                            
                                        </div>
                                    </div>
                            </div>
                        </div>
                    <div class="tab-pane h-100 w-100 fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row mt-2">
                                <div class="col-2">
                                    <img class="img-fluid" src="{{asset('assets/dashboard/lte/img/logo.png')}}">
                                </div>
                                <div class="col-10">Irfa Ardiansyah<br>Web Programmer</div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <img class="img-fluid" src="{{asset('assets/dashboard/lte/img/logo.png')}}">
                                </div>
                                <div class="col-10">Irfa Ardiansyah<br>Web Programmer</div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
        

@if(!empty($meet->description))
<div class="row mt-5">
<div class="col-md-12">
    <div class="callout callout-success">
        <b>Deskripsi:<br></b>
        {!!$meet->description!!}
    </div>

</div>
</div>
@endif
<script src='https://meet.jit.si/external_api.js'></script>
<script type="text/javascript">
	const domain = '{{config('app.jitsi_server')}}';
    const options = {
        roomName: 'INDIHEALTH-{{hash('sha1',$room_name." ".$meet->updated_by." ".$meet->room_name)}}',
      	 userInfo: {
            email: '{{Auth::user()->email}}',
            displayName: '{{Auth::user()->name}}',
           },
        interfaceConfigOverwrite: {
                        DEFAULT_BACKGROUND: "#89b4c4",
                        DEFAULT_WELCOME_PAGE_LOGO_URL: '{{asset('assets/dashboard/lte/img/logo.png')}}',
                        DEFAULT_LOGO_URL: '{{asset('assets/dashboard/lte/img/logo.png')}}',
                        HIDE_INVITE_MORE_HEADER: true,
                    },

         configOverwrite: {
                        prejoinPageEnabled: false,
                    },
        height: 500,    
        parentNode: document.querySelector('#meet')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
$(document).ready(function(){
    var iframe = $('#jitsiConferenceFrame0');
        iframe.ready(function(){
            $('#loader-jitsi').hide();
            $('#meet').show();
        })
})
</script>

<script type="text/javascript">
$(".person").on('click', function(){
    $(this).toggleClass('focus').siblings().removeClass('focus');
 })

</script>

@else
<div class="alert alert-warning" align="center">Tidak dapat mengakses meeting</div>
@endif
@endsection