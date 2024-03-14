@extends('layouts/master_public')
@section('title', $meet->room_name)
@section('content')
<style type="text/css">
  #jitsiConferenceFrame0{
    min-height:100vh;
  }
 
</style>
@if(session('meet-auth-'.$meet->id))
<div class="row">
    <div class="col-md-12 " style="min-height:100vh;">
        <div class="overlay  h-100" style="min-height:500px;"  id="loader-jitsi">
            <span class="text-primary"><i class="fas fa-2x fa-spinner fa-spin mr-3"></i>Memuat Ruang Meeting...</span>
        </div>
        <div id="meet" style="display:none;"></div>
    </div> 
    
</div>
        


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
        height: '100vh',    
        parentNode: document.querySelector('#meet')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
$(document).ready(function(){
    var iframe = $('#jitsiConferenceFrame0');
        iframe.ready(function(){
            $('#loader-jitsi').hide();
            $('#meet').show();
            // console.log(iframe.contents().find('<d'));
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