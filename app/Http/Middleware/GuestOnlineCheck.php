<?php

namespace App\Http\Middleware;
// 
use Closure;
use AuthGuest;
use Cache;
use Carbon\Carbon;

class GuestOnlineCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(AuthGuest::check()) {
            $expiresAt = Carbon::now()->addMinutes(3);
            Cache::put('guo-' . AuthGuest::guest()->id, true, $expiresAt);
        }
        return $next($request);
    }
}
