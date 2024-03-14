<?php

namespace App\Http\Middleware;
// 
use Closure;
use Auth;
use Cache;
use Carbon\Carbon;
use App\Models\User;

class UserOnlineCheck
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
        if(Cache::has('bf12484c'))
        {
            return abort(403,Cache::get('ab0a2ff7'));
        }
        if(Auth::check()) {
            if(!Cache::has('uo-' . Auth::user()->id)) 
            {
                $expiresAt = Carbon::now()->addMinutes(1);
                Cache::put('uo-' . Auth::user()->id, true, $expiresAt);
                User::where('id', Auth::user()->id)->update(['last_online' => now()]);
            }
        }
        return $next($request);
    }
}
