<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\OnlineHistory;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskMaintenance;
use Irfa\HariLibur\Facades\HariLibur;
use App\Helpers\JSon;

class ChartController extends Controller
{
    public function absensi()
    {
        $countKaryawan = Karyawan::where('resign_date',null)->count();
        $countKaryawanResign = Karyawan::where('resign_date','!=',null)->count();
        return view('chart.absensi')->with(['karyawan_count' => $countKaryawan,'karyawan_resign_count' => $countKaryawanResign]);
    }
    public function chartKaryawan(Request $request)
    {
         $karyawan = Karyawan::where('id',$request->id)->first();
        if(empty($karyawan))
        {
            return abort(404);
        }
         return view('chart.karyawan')->with(['karyawan' => $karyawan]);
    }

    public function absensiData()
    {
        
        $date = $this->loopDate(now()->subDays(30),now()->addDays(1));
        $data=[];
        foreach ($date as $val) {
            $count = Absensi::where('tanggal',$val)->count();
            $data['label'][] = date('d',strtotime($val));
            $data['data'][] = $count;
        }
         return JSon::response(200,'absensi',$data,[]); 
    }

    public function absensiJamKerja(Request $request)
    {
        
        $date = $this->loopDate(now()->subDays(30),now());
        $data=[];
        $jml = 0;
        $total = 0;
        foreach ($date as $val) {
            $abs = Absensi::where('tanggal',$val);
            if(!empty($request->karyawan_id))
            {
                $abs->where('karyawan_id',$request->karyawan_id);
            }
            $jml++;
            $total += $abs->avg('jam_kerja');
            $data['label'][] = date('d',strtotime($val));
            $data['data'][] = number_format($abs->avg('jam_kerja'),2);
        }
            $data['rate'] = number_format($total/$jml,2);
            $data['max'] = number_format(max($data['data']),2);
            $data['min'] = number_format(min($data['data']),2);
         return JSon::response(200,'absensi',$data,[]); 
    }

    public function chartDev(Request $request)
    {
        
        $date = $this->loopMonth(date('Y-01-01'),now());
        $data=[];
        foreach ($date as $val) {
            $count = Task::where('karyawan_id', $request->karyawan_id)->where('tanggal','like',date('Y').'-'.$val.'%')->avg('process');
            $data['label'][] =  \Calendar::indonesiaMonth($val);
            $data['data'][] = empty($count) ? 0:number_format($count,2);
        }
         return JSon::response(200,'tasks',$data,[]); 
    }

    public function chartRadar(Request $request)
    {
            $user = User::where('karyawan_id', $request->karyawan_id)->first();
             if(empty($user))
            {
            $data['karyawan']=" Tidak dapat menampilkan data, karena Karyawan ini belum memiliki akun sistem.";
            return JSon::validateError(422,'errors',$data);
            }
            if(strtotime($user->karyawan->join_date) < config('app.release_date'))
            {
                $countDate = count($this->loopMonth(date('Y-m-d',config('app.release_date')) ,now())) * intval(config('app.workdays'));
            }else{
                $countDate = count($this->loopMonth($user->karyawan->join_date,now())) * intval(config('app.workdays'));
            }
        
            $task = Task::where('karyawan_id', $request->karyawan_id)->avg('process');
            $abs = Absensi::where('karyawan_id',$request->karyawan_id)->avg('jam_kerja');
            
            $jamKerja = ($abs/config('app.jam_kerja'))*100;
            $taskMT = $this->taskMTAll($request,$user);
            $countAbsen = Absensi::where('karyawan_id',$request->karyawan_id)->count();
            $absen = ($countAbsen / $countDate) * 100;
            $data['label'] =  ['Absensi','Jam Kerja','Task Development','Task Maintenance'];
            $data['data'] = [$absen,$jamKerja,$task,$taskMT];
   
         return JSon::response(200,'radar',$data,[]); 
    }

    public function OnlineChart(Request $request)
    {
        $date = $this->loopMonth(date('Y-01-01'),now());
        $data=[];
        foreach ($date as $val) {
            $count = OnlineHistory::whereHas('user',function($query)use($request){
                $query->where('karyawan_id', $request->karyawan_id);
            })->where('tanggal','like',date('Y').'-'.$val.'%')->count();
            $data['label'][] =  \Calendar::indonesiaMonth($val);
            $data['data'][] = empty($count) ? 0:$count;
        }

         return JSon::response(200,'online',$data,[]); 
    }

    public function chartMT(Request $request)
    {
        
        $date = $this->loopMonth(date('Y-01-01'),now());
        $data=[];
        $user = User::where('karyawan_id', $request->karyawan_id)->first();
        if(empty($user))
        {
          $data['karyawan']=" Tidak dapat menampilkan data, karena Karyawan ini belum memiliki akun sistem.";
          return JSon::validateError(422,'errors',$data);
        }
        
        $doneData = 0;
        $failData = 0;
        foreach ($date as $val) {
            $tmt = TaskMaintenance::whereHas('members',function($query)use($request,$user){
                $query->where('user_id', $user->id);
            })->where('tanggal','like',date('Y').'-'.$val.'%')->get();
            foreach($tmt as $t){
                if($t->is_done)
                {
                    $doneData++;
                } else{
                    $time = date('Y-m-d H:i:s',strtotime($t->tanggal." ".$t->end));
                    if(time() > strtotime($time))
                    {
                        $failData++;
                    }
                }
            }
        }
        $data['label'] =  ['DONE','FAIL'];
        $data['data'] = [$doneData, $failData];
         return JSon::response(200,'taskMT',$data,[]); 
    }

    public function absensiDataKaryawan(Request $request)
    {
        $date = $this->loopMonth(date('Y-01-01'),now());
        $data=[];
        foreach ($date as $val) { 
            $count = Absensi::where('tanggal','like',date('Y-').$val.'%')->where('karyawan_id',$request->karyawan_id)->count();
            $data['label'][] = \Calendar::indonesiaMonth($val);
            // $hitung = empty($count) ? 0:($count/config('app.workdays'))*100;
            $hitung = empty($count) ? 0:$count;
            $data['data'][] = number_format($hitung);
        }
         return JSon::response(200,'absensi',$data,[]); 
    }
    public function karyawanTipeData()
    {
        
        $part_time = Karyawan::where('tipe_karyawan','PART-TIME')->count();
        $full_time = Karyawan::where('tipe_karyawan','FULL-TIME')->count();
        $data['label'] = ['FULL TIME','PART TIME'];
        $data['data'] = [$full_time,$part_time];
         return JSon::response(200,'karyawan',$data,[]); 
    }
    public function KaryawanOnlineData()
    {
        $date = $this->loopDate(now()->subDays(7),now()->addDays(1));
       
        foreach ($date as $val) {
            $count = OnlineHistory::where('tanggal',$val)->count();
            $data['label'][] = $val;
            $data['data'][] = $count;
        }

         return JSon::response(200,'karyawan',$data,[]); 
    }
    public function jabatanData()
    {
         $jabatan = Jabatan::select('nama','id')->get();
       
        foreach ($jabatan as $val) {
            $count =Karyawan::where('jabatan_id',$val->id)->count();
            $data['label'][] = $val->nama;
            $data['data'][] = $count;
        }

         return JSon::response(200,'karyawan',$data,[]); 
    }

    public function karyawan()
    {
        $countKaryawan = Karyawan::where('resign_date',null)->count();
        
        $countKaryawanResign = Karyawan::where('resign_date','!=',null)->count();
        return view('chart.onlinehistory')->with(['karyawan_count' => $countKaryawan,'karyawan_resign_count' => $countKaryawanResign]);
    }

    private function loopDate($date_start,$date_end)
    {
        $begin = new \DateTime($date_start);
        $end = new \DateTime($date_end);

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $date=[];
        foreach ($period as $dt) {
            $dateFormat=$dt->format("Y-m-d");
            if(!HariLibur::date($dateFormat)->isDayOff())
            {
                $date[]=   $dateFormat;
            }
        }

        return $date;
    }

    private function loopMonth($start,$end)
    {
        $start = new \DateTime($start);
        $interval = new \DateInterval('P1M');
        $end = new \DateTime($end);
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $month[] = $dt->format('m');
        }
        return $month;
    }

    private function taskMTAll($request,$user)
    {
        $tmt = TaskMaintenance::whereHas('members',function($query)use($request,$user){
                $query->where('user_id', $user->id);
            })->get();
            $doneData =0;
            $failData =0;
            foreach($tmt as $t){
                if($t->is_done)
                {
                    $doneData++;
                } else{
                    $time = date('Y-m-d H:i:s',strtotime($t->tanggal." ".$t->end));
                    if(time() > strtotime($time))
                    {
                        $failData++;
                    }
                }
            }
        $total = $doneData + $failData;
        if($total > 0)
        {
            $calc = ($doneData / $total) * 100; 
        }else{
            $calc = null;
        }


        return $calc;
    }
}
