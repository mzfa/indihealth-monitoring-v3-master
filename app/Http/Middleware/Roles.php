<?php

namespace App\Http\Middleware;

use Closure;

class Roles
{
    
    public function handle($request, Closure $next)
    {

        $roles = $this->cekRoute($request->route());
        // dd(($request->user()->hasRole($roles)));
        
        if($request->user()->hasRole($roles) || !$roles)
        {
            return $next($request);
        }
        return abort(404,"Halaman ini tidak tersedia.");
    }
 
    private function cekRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
