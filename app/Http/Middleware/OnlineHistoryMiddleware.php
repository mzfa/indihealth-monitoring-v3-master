<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OnlineHistory;

class OnlineHistoryMiddleware
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
        $this->putOnline($request);
        return $next($request);
    }

    private function putOnline($request)
    {
        $cek = OnlineHistory::where(['user_id' => auth()->user()->id,'tanggal' => date('Y-m-d')]);
        if($cek->count() == 0)
        {
            OnlineHistory::create(['user_id' => auth()->user()->id,'tanggal' => date('Y-m-d'),'ip_address' => $request->ip(),'user_agent' =>  $_SERVER['HTTP_USER_AGENT']]);
        }
    }
}
