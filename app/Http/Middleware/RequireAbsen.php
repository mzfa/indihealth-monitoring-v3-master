<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use UserHelper;

class RequireAbsen
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
       if(UserHelper::requiredAbsen())
       {
            return $next($request);
        } 
        return redirect()->route('home')->with(['message_warning' => 'Harus Absen Dahulu.']);
    }
}
