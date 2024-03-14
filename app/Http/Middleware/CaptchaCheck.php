<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Request as Req;
use Illuminate\Support\Facades\Log;
use HCaptcha;
use Session;

class CaptchaCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty(Req::post('email'))){
            if(empty(Req::post('h-captcha-response')))
            {
                $title = "CAPTCHA-EMPTY";
                $message['input_user'] = Req::post('email');
                $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
                $message['ip_address'] = Req::ip();
                $message['time'] = date('Y-m-d H:i:s');
                Log::warning($title." ".json_encode($message));
                Session::put('fail', 'Captcha harus diisi.');
                return redirect()->back();
            }
            
            // dd(Req::post('h-captcha-response'));
            if(!HCaptcha::check(Req::post('h-captcha-response')))
            {

                $title = "CAPTCHA-FAIL";
                $message['input_user'] = Req::post('email');
                $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
                $message['ip_address'] = Req::ip();
                $message['time'] = date('Y-m-d H:i:s');
                Log::warning($title." ".json_encode($message));
                Session::put('fail', 'Captcha tidak sesuai.');
                return redirect()->back();
            }

            return $next($request);
        }

         return $next($request);
    }
}
