<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageTracking;
use Auth;

class PageTrackingMiddleware
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
        if(Auth::check())
        {
            $this->trackRecord(Auth::user()->id,$request);
        }

        return $next($request);
    }

    private function trackRecord($user_id,$request)
    {
        $url =  $request->fullUrl();
        $route =  $request->route()->getName();

        $expRoute = explode('.', $route);
        $pg = PageTracking::where(['user_id' => $user_id,'page' => $url]);
        $params = ['user_id' => $user_id,'kategori' =>$expRoute[0],'route_name' => $route,'page' => $url];
        if($pg->count()==0)
        {
            $params['count'] = \DB::raw('1');
            PageTracking::create($params);   
        } else{
            $params['count'] = \DB::raw('count+1');
            $pg->update($params);
        }
        try{
            $post = [
                  'token' => 'afa9c3ba00734440b6af0dcb57ef4958e22a38b26fe81e3f0e5bef48718b59dcdb619bfb217ce7d14cd13b8e32f65d321e8d7c3898f9deef0deb754fa3b9b944',
                  'route_group' => $expRoute[0],
                  'route_name' =>  $route,
                  'page' => $url,
              ];

            $ch = curl_init('https://tx-srv1-chk.indihealth.com/api/v1/trx/send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          
            $response = curl_exec($ch);
            // dd(curl_error($ch))
            curl_close($ch);
            $pr  = json_decode($response);
            
        } catch(\Exception $e)
        {
            
        }
          

        return true;
    }
}
