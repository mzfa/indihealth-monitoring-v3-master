<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use AuthGuest;

class AuthGuestCheck
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
        if(AuthGuest::check()){
          return $next($request);
        }else{
            // dd($request->url());
            session(['url_previous'=>$request->url()]);
            return redirect()->route('guest.login_form')->with(['message_fail' => "Sebelum melanjutkan, dimohon untuk login dahulu."]);;
        }
    }
}
