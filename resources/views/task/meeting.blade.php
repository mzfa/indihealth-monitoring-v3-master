@extends('layouts/master_dashboard')
@section('title', $meet->room_name)
@section('content')
<div id="meet">
	</div>
@if(!empty($meet->description))
<div class="row">
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

</script>
@endsection