<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageTracking;
use App\Models\Absensi;
use App\Models\User;
use App\Helpers\JSon;
use App\Http\Resources\TelemetryGet;
use App\Http\Resources\UserDevices;
use App\Http\Resources\UsersRes;
use Illuminate\Support\Facades\DB;

class MonitoringAppController extends Controller
{
  private $data;
    public function index()
    {
    	return view('monitoring.index');
    }
    public function telemetry(Request $request)
    {
      if(!empty($_SERVER['HTTP_ORIGIN']))
      {
        header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);

      }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        header('Content-Type: application/json');

      if(sha1($request->access_key) != sha1("IDH-MONITORING-QxYvlscCrC51TYavgQXUIYnyZjHZMBncTk33vRmzu4EaGzjB4IL7mt7pMvAxIlKL-TELEMETRY-A-2022"))
      {
          return abort(401);
      }
       $data = TelemetryGet::collection(PageTracking::all());
    	 return JSon::response(200,'user_usage',$data,[]);
    }

    public function user_devices(Request $request)
    {
      if(!empty($_SERVER['HTTP_ORIGIN']))
      {
        header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);

      }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        header('Content-Type: application/json');

      if(sha1($request->access_key) != sha1("IDH-MONITORING-QxYvlscCrC51TYavgQXUIYnyZjHZMBncTk33vRmzu4EaGzjB4IL7mt7pMvAxIlKL-DEVICES-A-2022"))
      {
          return abort(401);
      }
       $data = UserDevices::collection(Absensi::select(DB::raw("concat(browser,' - ',platform) as browser_platform"),DB::raw("count(*) as total"))
       ->groupBy('browser_platform')
       ->orderBy('total','DESC')
       ->get());
    	 return JSon::response(200,'devices',$data,[]);
    }

    public function user_data(Request $request)
    {

      if(!empty($_SERVER['HTTP_ORIGIN']))
      {
        header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);

      }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        header('Content-Type: application/json');

      if(sha1($request->access_key) != sha1("IDH-MONITORING-QxYvlscCrC51TYavgQXUIYnyZjHZMBncTk33vRmzu4EaGzjB4IL7mt7pMvAxIlKL-USERS-A-2022"))
      {
          return abort(401);
      }
       $arr['data']['active_users'] = User::whereNotNull('activated_at')->count();
       $arr['data']['not_active_users'] = User::whereNull('activated_at')->count();
       $arr['data']['disabled_users'] = User::where('is_disabled',0)->count();
       $arr['data']['enabled_user'] = User::where('is_disabled',1)->count();

       $data = new UsersRes((object) $arr['data']);
    	 return JSon::response(200,'users',$data,[]);
    }




}
