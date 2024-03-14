<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use TaskHelper;

class CheckPM
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
      if(TaskHelper::cekPMProject(auth()->user()->id,$request->route('project_id')))
      {
           return $next($request);
      } else{
        return abort(404);
      }


    }
}
