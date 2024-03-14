<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mail;
use Str;
use App\Exports\AbsensiExport;
use App\Exports\TaskExport;
use App\Mail\ReportAbsen;
use App\Mail\ReportTask;
use App\Mail\ReportNotulensi;
use App\Models\User;
use App\Mail\ReminderAbsenKeluar;
use Irfa\HariLibur\Facades\HariLibur;
use App\Models\Notulensi;
use App\Helpers\JSon;
use Carbon\Carbon;
use PDF;
use Log;

class MailSenderController extends Controller
{
    public function absenKeluarReminder(Request $request)
    {
        if(!HariLibur::date(date('Y-m-d'))->isDayOff())
        {
            if(md5($request->access_key) != md5(config('app.access_key')))
            {
                return abort(401);
            }
            set_time_limit (60*5);
            $user = User::select(['name','email'])->whereHas('role', function($query){
                $query->whereNotIn('name',['owner','hrd']);
            })->where('is_disabled',false)->get();
            $data=['message'=>'Pesan Terkirim.','code' => 'M01'];
            $i = 0;
            foreach ($user as $u) {
              $i++;
                Mail::to($u->email)->send(new ReminderAbsenKeluar($u));
            }
            $message['status'] =  "NOTIFIKASI PULANG TERKIRIM";
    				$message['ip_address'] = $request->ip();
    				$message['reqMethod'] = strtoupper($request->method());
    				$message['path_request'] = $request->path();
    				$message['agent'] = $_SERVER['HTTP_USER_AGENT'];
    				$message['user_sended'] = $i." user(s)";
    				$message['time'] = date('Y-m-d H:i:s');
    				Log::notice("MAIL-SENDER-SERVICES"." ".json_encode($message));
            return response()->json($data);
        } else{
           return response()->json(['message' => 'Sedang hari libur.','code' => 'M01L']);
        }
    }
     public function absenMasukReminder(Request $request)
    {
        if(!HariLibur::date(date('Y-m-d'))->isDayOff())
        {
            if(md5($request->access_key) != md5(config('app.access_key')))
            {
                return abort(401);
            }
            set_time_limit (60*5);
            $user = User::select(['name','email'])->whereHas('role', function($query){
                $query->whereNotIn('name',['owner','hrd']);
            })->where('is_disabled',false)->get();
            $data=['message'=>'Pesan Terkirim.','code' => 'M01'];
            $i = 0;
            foreach ($user as $u) {
              $i++;
                Mail::to($u->email)->send(new ReminderAbsenKeluar($u));
            }
            $message['status'] =  "NOTIFIKASI ABSEN MASUK TERKIRIM";
                    $message['ip_address'] = $request->ip();
                    $message['reqMethod'] = strtoupper($request->method());
                    $message['path_request'] = $request->path();
                    $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
                    $message['user_sended'] = $i." user(s)";
                    $message['time'] = date('Y-m-d H:i:s');
                    Log::notice("MAIL-SENDER-SERVICES"." ".json_encode($message));
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
        $message['status'] =  "LAPORAN ABSENSI TERKIRIM";
        $message['ip_address'] = $request->ip();
        $message['reqMethod'] = strtoupper($request->method());
        $message['path_request'] = $request->path();
        $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $message['user_sended'] = count($user)." user(s)";
        $message['time'] = date('Y-m-d H:i:s');
        Log::notice("MAIL-SENDER-SERVICES"." ".json_encode($message));
        // File::delete(storage_path($path));
        $data=['message'=>'Pesan Terkirim.','code' => 'M02'];
        return response()->json($data);
    }

    public function reportNotulensi(Request $request)
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
        $date = \Calendar::indonesiaMonth(date('m'),true)." ".date('Y');
        $data = Notulensi::where('waktu_meeting','like',date('Y').'-'.date('m').'%')->orderBy('waktu_meeting','DESC')->orderBy('project_id','DESC')->get();
        if(count($data) == 0)
        {
            $data=['message'=>'Tidak Ada Notulensi.','code' => 'M01N'];
            return response()->json($data);
        }
        $path = storage_path('app/temp_pdf/'. 'LAPORAN_NOTULENSI_'.$date."_".time().'.pdf');
        $pdf = PDF::loadView('pdf.notulensi', ['data'=>$data,'date' => $date]);
        $pdf->save($path);
        foreach ($user as $u) {
             Mail::to($u->email)->send(new ReportNotulensi($u,$path));
        }
        $message['status'] =  "LAPORAN NOTULENSI TERKIRIM";
        $message['ip_address'] = $request->ip();
        $message['reqMethod'] = strtoupper($request->method());
        $message['path_request'] = $request->path();
        $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $message['user_sended'] = count($user)." user(s)";
        $message['time'] = date('Y-m-d H:i:s');
        Log::notice("MAIL-SENDER-SERVICES"." ".json_encode($message));
        // File::delete($path);
        $data=['message'=>'Pesan Terkirim.','code' => 'M02'];
        return response()->json($data);

    }

    public function taskReport(Request $request)
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
        $path = 'temp_excel/'. 'LAPORAN_TUGAS_KARYAWAN_'.$ds.'-'.$de.'.xlsx';
        \Excel::store(new TaskExport($ds,$de),$path);
        foreach ($user as $u) {
             Mail::to($u->email)->send(new ReportTask($u,$path));
        }
        $message['status'] =  "LAPORAN TUGAS KARYAWAN TERKIRIM";
        $message['ip_address'] = $request->ip();
        $message['reqMethod'] = strtoupper($request->method());
        $message['path_request'] = $request->path();
        $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $message['user_sended'] = count($user)." user(s)";
        $message['time'] = date('Y-m-d H:i:s');
        Log::notice("MAIL-SENDER-SERVICES"." ".json_encode($message));
        // File::delete(storage_path($path));
        $data=['message'=>'Pesan Terkirim.','code' => 'M02'];
        return response()->json($data);

    }
}
