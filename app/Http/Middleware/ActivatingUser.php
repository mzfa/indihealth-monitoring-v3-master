<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ActivatingUser
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
        $usr = User::where('id', auth()->user()->id)->first();
        if(empty($usr->activated_at))
        {
            return redirect()->route('password.new');
        }
        return $next($request);
    }
}
