<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Mail;
use Str;
use App\Exports\AbsensiExport;
use App\Mail\ReportAbsen;
use App\Models\User;
use App\Mail\ReminderAbsenKeluar;
use Irfa\HariLibur\Facades\HariLibur;

class MailSenderController extends Controller
{
    public function absenKeluarReminder(Request $request)
    {
        if(HariLibur::date(date('Y-m-d'))->isDayOff())
        {
            if(md5($request->access_key) != md5(config('app.access_key')))
            {
                return abort(401);
            }
            set_time_limit (60*5);
            $user = User::select(['name','email'])->whereHas('role', function($query){
                $query->whereNotIn('name',['owner']);
            })->where('is_disabled',false)->get();
            $data=['message'=>'Pesan Terkirim.','code' => 'M01'];
            foreach ($user as $u) {
                Mail::to($u->email)->send(new ReminderAbsenKeluar($u));
            }
            return response()->json($data);
        } else{
           return response()->json(['message' => 'Sedang hari libur.','code' => 'M01L']);
        }
    }

    public function sendLaporanAbsensi(Request $request)
    {
        if(md5($request->access_key) != md5(config('app.access_key')))
        {
            return abort(401);
        }
        set_time_limit (60*5);
         $user = User::select('name','email')->whereHas('role', function($query){
             $query->whereIn('name',['hrd']);
         })->where('is_disabled',false)->get();
         $data=['message'=>'Pesan Terkirim.'];
        //  dd($user);
        $ds = date('Y-m-01');
        $de = \Carbon\Carbon::now()->format('Y-m-d');
        $path = 'temp_excel/'. 'ABSENSI_'.$ds.'-'.$de.'.xlsx';
        \Excel::store(new AbsensiExport($ds,$de),$path);
        foreach ($user as $u) {
             Mail::to($u->email)->send(new ReportAbsen($u,$path));
        }
        File::delete(storage_path($path));
        $data=['message'=>'Pesan Terkirim.','code' => 'M02'];
        return response()->json($data);
    }
}
