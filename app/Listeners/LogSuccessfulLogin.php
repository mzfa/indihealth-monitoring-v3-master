<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Request;
use Cookie;
class LogSuccessfulLogin
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
        $user = auth()->user();
        $title = "INTERNAL LOGIN";
        $message['email'] = $user->email;
        $message['role'] = $user->role->name;
        $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $message['ip_address'] = Request::ip();
        $message['time'] = date('Y-m-d H:i:s');
        Log::info($title." ".json_encode($message));
        Cookie::queue('c_user_id', $user->id, (840*1440));
    }
}
