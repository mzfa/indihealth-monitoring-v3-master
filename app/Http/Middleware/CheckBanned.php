<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckBanned
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
        if(auth()->user()->is_disabled){
         Auth::logout();
         return redirect()->route('login')->with(["banned_message" => "Akun ini telah di non-aktifkan"]);
        }else{
             return $next($request);
        }
    }
}
