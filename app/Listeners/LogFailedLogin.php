<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Request;

class LogFailedLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $title = "FAILED-LOGIN";
        $message['email'] = Request::input('email');
        $message['reqMethod'] = strtoupper(Request::method());
        $message['path_request'] = Request::path();
        $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $message['ip_address'] = Request::ip();
        $message['time'] = date('Y-m-d H:i:s');
        Log::warning($title." ".json_encode($message));
    }
}
