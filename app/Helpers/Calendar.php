<?php
namespace App\Helpers;

use Cache;
use App\Models\Task;
use App\Models\IzinSakit;
use App\Models\Absensi;
use App\Models\TaskMaintenance;
use Irfa\HariLibur\Facades\HariLibur;
use UserHelper;
use Spatie\GoogleCalendar\Event;

class Calendar
{
		static function taskGenerate($month, $year,$karyawan_id = null) {
			$daysOfWeek = array('Min','Sen','Sel','Rab','Kam','Jum','Sab');
			$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
			$numberDays = date('t',$firstDayOfMonth);
			$dateComponents = getdate($firstDayOfMonth);
			$monthName = $dateComponents['month'];
			$dayOfWeek = $dateComponents['wday'];
			$calendar = "<table class='calendar table   table-bordered'>";
			$calendar .= "<caption><b>".self::indonesiaMonth($monthName,true)."$year</b></caption>";
			$calendar .= "<tr>";
			foreach($daysOfWeek as $day) {
				$calendar .= "<th class='header' align='center'>$day</th>";
			}
			$currentDay = 1;
			$calendar .= "</tr><tr>";
			if ($dayOfWeek > 0) {
				$calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
			}
			$month = str_pad($month, 2, "0", STR_PAD_LEFT);
			while($currentDay <= $numberDays){
				if($dayOfWeek == 7){
					$dayOfWeek = 0;
					$calendar .= "</tr><tr>";
				}
				$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
				$date = "$year-$month-$currentDayRel";

				// Is this today?
				if(date('Y-m-d') == $date) {
					$calendar .= "<td data-toggle='tooltip' data-placement='bottom' class='day  ".self::classifiedTask($date, $karyawan_id)."'  title='Progress ".number_format(self::calculateTask($date, $karyawan_id),2,",",".")."%' style='cursor:pointer; ' onclick=findDate('$date') rel=' $date'><b class='badge badge-light' title='hari ini'>$currentDay</b></td>";
				} else {
					$calendar .= "<td  data-toggle='tooltip' data-placement='bottom' class='day ".self::classifiedTask($date, $karyawan_id)."' title='Progress ".self::calculateTask($date, $karyawan_id)."%' style='cursor:pointer' onclick=findDate('$date') rel='$date'>$currentDay</td>";
				}

				$currentDay++;
				$dayOfWeek++;
			}
			if($dayOfWeek != 7){
				$remainingDays = 7 - $dayOfWeek;
				$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
			}
			$calendar .= "</tr>";
			$calendar .= "</table>";
			return $calendar;
		}
		public static function absenGenerate($month,$year,$kry_id)
		{
			$daysOfWeek = array('Min','Sen','Sel','Rab','Kam','Jum','Sab');
			$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
			$numberDays = date('t',$firstDayOfMonth);
			$dateComponents = getdate($firstDayOfMonth);
			$monthName = $dateComponents['month'];
			$dayOfWeek = $dateComponents['wday'];
			$calendar = "<table class='calendar table   table-bordered'>";
			$calendar .= "<caption><b>".self::indonesiaMonth($monthName,true)." $year</b></caption>";
			$calendar .= "<tr>";
			foreach($daysOfWeek as $day) {
				$calendar .= "<th class='header' align='center'>$day</th>";
			}
			$currentDay = 1;
			$calendar .= "</tr><tr>";
			if ($dayOfWeek > 0) {
				$calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
			}
			$month = str_pad($month, 2, "0", STR_PAD_LEFT);
			while($currentDay <= $numberDays){
				if($dayOfWeek == 7){
					$dayOfWeek = 0;
					$calendar .= "</tr><tr>";
				}
				$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
				$date = "$year-$month-$currentDayRel";

				// Is this today?
				if(date('Y-m-d') == $date) {
					$calendar .= "<td  data-toggle='tooltip' data-placement='bottom'  class='day ".self::classifiedCuti($date, $kry_id)."' title='Hari ini  ".self::classifiedStatusCuti($date, $kry_id)."'><b class='badge badge-success' title='Hari ini ".self::classifiedStatusCuti($date, $kry_id)."'>$currentDay</b></td>";
				} 
				else if(HariLibur::date($date)->isDayOff())
				{
					$calendar .= "<td   data-toggle='tooltip' data-placement='bottom' class='day bg-lightblue' title='".(empty(HariLibur::date($date)->getInfo())?'Libur Akhir Pekan':HariLibur::date($date)->getInfo())."'>$currentDay</td>";
				}
				else {
					$calendar .= "<td   data-toggle='tooltip' data-placement='bottom' class='day ".self::classifiedAbsen($date, $kry_id)."' title='".self::classifiedStatusAbsen($date, $kry_id)."'>$currentDay</td>";
				}




				$currentDay++;
				$dayOfWeek++;
			}
			if($dayOfWeek != 7){
				$remainingDays = 7 - $dayOfWeek;
				$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
			}
			$calendar .= "</tr>";
			$calendar .= "</table>";
			return $calendar;
		}
		private static function calculateTask($date,$karyawan_id = null)
		{
			if(!empty($karyawan_id))
			{
				$kry_id = $karyawan_id;
			} else{
				$kry_id = auth()->user()->karyawan_id;
			}

			$task_avg = Task::where(['karyawan_id' => $kry_id,'tanggal' => $date])->avg('process');

			return empty($task_avg)?0:$task_avg;
		}

		private static function classifiedTask($date,$karyawan_id = null)
		{
			if(!empty($karyawan_id))
			{
				$kry_id = $karyawan_id;
			} else{
				$kry_id = auth()->user()->karyawan_id;
			}

			$calc = self::calculateTask($date, $kry_id);

			if($calc <= 0){
				return null;
			}elseif($calc <= 25)
			{
				return "bg-danger";
			} elseif($calc < 75)
			{
				return "bg-warning";
			} elseif($calc <= 75)
			{
				return "bg-info";
			} elseif($calc <= 100){
				return "";
			}
		}
		static function taskMTGenerate($month, $year) {
			$daysOfWeek = array('Min','Sen','Sel','Rab','Kam','Jum','Sab');
			$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
			$numberDays = date('t',$firstDayOfMonth);
			$dateComponents = getdate($firstDayOfMonth);
			$monthName = $dateComponents['month'];
			$dayOfWeek = $dateComponents['wday'];
			$calendar = "<table class='calendar table   table-bordered'>";
			$calendar .= "<caption><b>".self::indonesiaMonth($monthName,true)."$year</b></caption>";
			$calendar .= "<tr>";
			foreach($daysOfWeek as $day) {
				$calendar .= "<th class='header' align='center'>$day</th>";
			}
			$currentDay = 1;
			$calendar .= "</tr><tr>";
			if ($dayOfWeek > 0) {
				$calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
			}
			$month = str_pad($month, 2, "0", STR_PAD_LEFT);
			while($currentDay <= $numberDays){
				if($dayOfWeek == 7){
					$dayOfWeek = 0;
					$calendar .= "</tr><tr>";
				}
				$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
				$date = "$year-$month-$currentDayRel";

				// Is this today?
				if(date('Y-m-d') == $date) {
					$calendar .= "<td data-toggle='tooltip' data-placement='bottom' class='day  ".self::classifiedTaskMT($date)."'  title='Progress ".number_format(self::calculateTaskMT($date),2,",",".")."%' style='cursor:pointer; ' onclick=findDate('$date') rel=' $date'><b class='badge badge-light' title='hari ini'>$currentDay</b></td>";
				} else {
					$calendar .= "<td  data-toggle='tooltip' data-placement='bottom' class='day ".self::classifiedTaskMT($date)."' title='Progress ".self::calculateTaskMT($date)."%' style='cursor:pointer' onclick=findDate('$date') rel='$date'>$currentDay</td>";
				}

				$currentDay++;
				$dayOfWeek++;
			}
			if($dayOfWeek != 7){
				$remainingDays = 7 - $dayOfWeek;
				$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
			}
			$calendar .= "</tr>";
			$calendar .= "</table>";
			return $calendar;
		}

		private static function calculateTaskMT($date)
		{


			$task_avg = TaskMaintenance::where('tanggal','like',$date.'%')->avg('process');

			return empty($task_avg)?0:$task_avg;
		}

		private static function classifiedTaskMT($date)
		{


			$calc = self::calculateTaskMT($date);

			if($calc <= 0){
				return null;
			}elseif($calc <= 25)
			{
				return "bg-danger";
			} elseif($calc < 75)
			{
				return "bg-warning";
			} elseif($calc <= 75)
			{
				return "bg-info";
			} elseif($calc <= 100){
				return "";
			}
		}

		private static function classifiedAbsen($date,$karyawan_id)
		{
			if(UserHelper::cekCuti($karyawan_id,$date))
			{
				return "bg-navy bg-gradient";
			} elseif(UserHelper::cekIzinSakit($karyawan_id,$date))
			{
				if(UserHelper::reasonIzinSakitType($karyawan_id,$date) == "S")
				{
					return "bg-indigo";
				} elseif(UserHelper::reasonIzinSakitType($karyawan_id,$date) == "I")
				{
					return "bg-orange";
				} else{
					return "bg-light" ;
				}
			}

			$abs = Absensi::where('tanggal','like',$date.'%')->where('karyawan_id',$karyawan_id)->first();
			if(!empty($abs->jam_masuk) AND !empty($abs->jam_keluar))
			{
				return 'bg-success';
			} elseif(!empty($abs->jam_masuk) AND empty($abs->jam_keluar)){
				return 'bg-warning';
			} elseif(empty($abs->jam_masuk) AND !empty($abs->jam_keluar)){
				return 'bg-warning';
			} else{
				return 'bg-light';
			}
		}

		private static function classifiedCuti($date,$karyawan_id)
		{
			if(UserHelper::cekCuti($karyawan_id,$date))
			{
				return "bg-navy bg-gradient";
			}

			
		}
		private static function classifiedStatusAbsen($date,$karyawan_id)
		{

			if(UserHelper::cekCuti($karyawan_id,$date))
			{
				return "Cuti : ".UserHelper::reasonCuti($karyawan_id,$date);
			} elseif(UserHelper::cekIzinSakit($karyawan_id,$date))
			{
				if(UserHelper::reasonIzinSakitType($karyawan_id,$date) == "S")
				{
					return "Sakit : ".UserHelper::reasonIzinSakit($karyawan_id,$date);
				} elseif(UserHelper::reasonIzinSakitType($karyawan_id,$date) == "I")
				{
					return "Izin : ".UserHelper::reasonIzinSakit($karyawan_id,$date);
				} else{
					return "-";
				}
			}

			$abs = Absensi::where('tanggal','like',$date.'%')->where('karyawan_id',$karyawan_id)->first();

			if(!empty($abs->jam_masuk) AND !empty($abs->jam_keluar))
			{
				return 'Telah melakukan absen masuk dan absen keluar';
			} elseif(!empty($abs->jam_masuk) AND empty($abs->jam_keluar)){
				return 'Tidak melakukan absensi keluar';
			} elseif(empty($abs->jam_masuk) AND !empty($abs->jam_keluar)){
				return 'Tidak melakukan absensi masuk';
			} else{
				return 'Tidak melakukan absensi ';
			}
		}
		private static function classifiedStatusCuti($date,$karyawan_id)
		{
			if(UserHelper::cekCuti($karyawan_id,$date))
			{
				return "(Cuti : ".UserHelper::reasonCuti($karyawan_id,$date).")";
			}

			
		}
		public static function indonesiaMonth($str,$full_name=false)
		{
			$search  = ['01', '02', '03', '04', '05','06','07','08','09','10','11','12'];
			if($full_name){
				$replace = ['Januari', 'Februari', 'Maret', 'April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
			} else{
				$replace = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei','Jun','Jul','Agt','Sept','Okt','Nov','Des'];
			}
			$subject = $str;
			return str_replace($search, $replace, $subject);
		}

		public static function  getHour($startTime,$endTime)
		{

			$date1 = new \DateTime($startTime);
			$date2 = new \DateTime($endTime);

			$diff = $date2->diff($date1);

			$hi = $diff->format('%h:%i');
			$time    = explode(':', $hi);
			$minutes = ($time[0] * 60.0 + $time[1] * 1.0);
			if($minutes > 0)
			{
				return $minutes/60;
			}

			return 0;

		}


		public static function createEvent(array $arr_conf)
		{
			$name 			= !empty($arr_conf['name']) ? $arr_conf['name']:"Monitoring Indihealth";			
			$description 	= !empty($arr_conf['description']) ? $arr_conf['description']:"Monitoring Indihealth";			
			$startDateTime 	= !empty($arr_conf['startDateTime']) ? $arr_conf['startDateTime']:\Carbon\Carbon::now();	
			$endDateTime 	= !empty($arr_conf['endDateTime']) ? $arr_conf['endDateTime']:\Carbon\Carbon::now()->addHour();	
			$email 			= !empty($arr_conf['email']) ? $arr_conf['email']:"";	
			$name_user 		= !empty($arr_conf['name_user']) ? $arr_conf['name_user']:"";	
			$comment 		= !empty($arr_conf['comment']) ? $arr_conf['comment']:"";	


			$event = new Event;

			$event->name = $name;
			$event->description = $description;
			$event->startDateTime = \Carbon\Carbon::now();
			$event->endDateTime = \Carbon\Carbon::now()->addHour();
			$event->addAttendee([
			    'email' => $email,
			    'name' => $name_user,
			    'comment' => $comment,
			]);
			// $event->addAttendee(['email' => 'anotherEmail@gmail.com']);

			$event->save();

			return true;
		}

}
