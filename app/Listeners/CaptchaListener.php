<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use HCaptcha;
use Request;
use Session;

class CaptchaListener
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
        // if(empty(Request::post('h-captcha-response')))
        // {
        //     Session::put('fail', 'Captcha harus diisi.');
        //     return redirect()->back();
        // }
        
        // if(!HCaptcha::check(Request::post('h-captcha-response')))
        // {

        //     $title = "CAPTCHA-FAIL";
        //     $message['input_user'] = Request::post('email');
        //     $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
        //     $message['ip_address'] = Request::ip();
        //     $message['time'] = date('Y-m-d H:i:s');
        //     Log::warning($title." ".json_encode($message));
        //     Session::put('fail', 'Captcha tidak sesuai.');
        // }
    }
}
