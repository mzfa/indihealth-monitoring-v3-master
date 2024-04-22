<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $beda = app('App\Http\Controllers\OtherController')->getDistanceBetweenPointsNew($data->long,$data->lat,$request->lat,$request->lng);
        // if($beda > $data->radius_kantor){
        //     $data="Anda tidak dapat melakukan absen, karena jarak anda ke kantor masih ". $beda." Meter lagi";
        //     return JSon::response(400,'absensi',[],$data);
        // }
        // dd('ok');
        $token = \Str::random(32);
        session(['absen_token' => $token]);
        return view('dashboard.index_dashboard');
    }
}
