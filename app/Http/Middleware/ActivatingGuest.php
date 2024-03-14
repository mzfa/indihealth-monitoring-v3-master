<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Guest;
use AuthGuest;

class ActivatingGuest
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
        $usr = Guest::where('id', AuthGuest::guest()->id)->first();
        if(empty($usr->activated_at))
        {
            return redirect()->route('password.guest');
        }
        return $next($request);
    }
}
