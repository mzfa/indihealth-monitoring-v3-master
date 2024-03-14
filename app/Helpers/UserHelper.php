<?php
namespace App\Helpers;

use Cache;
use Permission;
use App\Models\WebConfig;
use App\Models\IzinSakit;
use App\Models\Absensi;
use App\Models\Cuti;
use DateTime;

class UserHelper
{
	public static function isOnline($id){
        return Cache::has('uo-' . $id);
    }

    public static function sisaCuti($karyawan_id)
    {
        $cuti = Cuti::where('karyawan_id',$karyawan_id)->where('created_at','like',date('Y')."%")->where('status',1)->sum('jumlah');
        $calc = 12-$cuti;
        return $calc <=0 ? 0:$calc;
    } 

    public static function cekCuti($karyawan_id,$tgl)
    {
        $date = date("Y-m",strtotime($tgl));
        $cuti = Cuti::where('status',1)->where('karyawan_id',$karyawan_id)->where('start','like',$date.'%')->get();
        // dd($cuti);
       $arr = [];
        foreach ($cuti as $cuti) {
           
                $begin = new DateTime($cuti->start);
                $end   = new DateTime($cuti->end);
                // $arr = [];
                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $arr[] = $i->format('Y-m-d');
                }

                if(in_array($tgl,$arr))
                {
                    return true;
                } else{
                    // $ret = false;
                }
            
        }
    }  

    public static function cekIzinSakit($karyawan_id,$tgl)
    {
        $date = date("Y-m",strtotime($tgl));
        $izin = IzinSakit::where('status',1)->where('karyawan_id',$karyawan_id)->where('start','like',$date.'%')->get();
        // dd($izin);
        $ret = false;
        $arr = [];
        foreach ($izin as $izin) {
           
                $begin = new DateTime($izin->start);
                $end   = new DateTime($izin->end);
                // $arr = [];
                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $arr[] = $i->format('Y-m-d');
                }

                if(in_array($tgl,$arr))
                {
                    return true;
                } else{
                    // $ret = false;
                }
            
        }

      // dd($arr);
       
       
    }  

    public static function reasonCuti($karyawan_id,$tgl)
    {
       $date = date("Y-m",strtotime($tgl));
        $cuti = Cuti::where('status',1)->where('karyawan_id',$karyawan_id)->where('start','like',$date.'%')->get();
        // dd($cuti);
          $arr = [];
        foreach ($cuti as $cuti) {
           
                $begin = new DateTime($cuti->start);
                $end   = new DateTime($cuti->end);
                // $arr = [];
                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $arr[] = $i->format('Y-m-d');
                }

                if(in_array($tgl,$arr))
                {
                    return $cuti->reason_cuti;
                } else{
                    // $ret = false;
                }
            
        }
    }  

    public static function reasonIzinSakit($karyawan_id,$tgl)
    {
       $date = date("Y-m",strtotime($tgl));
        $izin = IzinSakit::where('status',1)->where('karyawan_id',$karyawan_id)->where('start','like',$date.'%')->get();
         $ret="";
         $arr = [];
        foreach ($izin as $izin) {
           
                $begin = new DateTime($izin->start);
                $end   = new DateTime($izin->end);
                // $arr = [];
                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $arr[] = $i->format('Y-m-d');
                }

                if(in_array($tgl,$arr))
                {
                    return $izin->keterangan;
                } else{
                    // $ret = false;
                }
            
        }
    } 

    public static function reasonIzinSakitType($karyawan_id,$tgl)
    {
       $date = date("Y-m",strtotime($tgl));
        $izin = IzinSakit::where('status',1)->where('karyawan_id',$karyawan_id)->where('start','like',$date.'%')->get();
       $ret="";
       $arr = [];
        foreach ($izin as $izin) {
           
                $begin = new DateTime($izin->start);
                $end   = new DateTime($izin->end);
                // $arr = [];
                for($i = $begin; $i <= $end; $i->modify('+1 day')){
                    $arr[] = $i->format('Y-m-d');
                }

                if(in_array($tgl,$arr))
                {
                    return $izin->jenis;
                } else{
                    // $ret = false;
                }
            
        }
        // return $ret;
    } 


    public static function cutiPending()
    {

        $cuti = Cuti::where('status',0)->where('created_at','like',date('Y')."%")->count();
        
        return $cuti;
    } 

    public static function joinAge($join_date)
    {
         $age = DateTime::createFromFormat('Y-m-d', $join_date)
             ->diff(new DateTime('now'))
             ->y;
        return $age;
    }
    public static function cutiByYear($karyawan_id,$mth)
    {
        $cuti = Cuti::where('karyawan_id',$karyawan_id)->where('created_at','like',$mth."%")->where('status',1)->sum('jumlah');
      
        return $cuti == 0 ? "":$cuti;
    }

    public static function userMode($id){
        return Cache::has($id.'-darkmode');
    }

	public static function isGuestOnline($id){
        return Cache::has('guo-' . $id);
    }

    public static function requiredAbsen()
    {
        if(Permission::for(['owner']))
        {
            return true;
        }


        $cfg = WebConfig::where('config_name', 'CFG-AUTOLOCK')->first()->config_value;
        if($cfg)
        {
            if(empty(auth()->user()->karyawan_id))
            {
                return true;
            }
            $absen = Absensi::where(['karyawan_id' => auth()->user()->karyawan_id,'tanggal' => date('Y-m-d')])->count();
            if($absen > 0)
            {
                return true;
            }

            return false;
        }

        return true;

    }
}
