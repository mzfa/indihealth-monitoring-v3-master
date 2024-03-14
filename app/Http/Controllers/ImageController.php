<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\TicketingMaintenance;

class ImageController extends Controller
{
	public function showAbsen($file)
   {
   	if($file == "default"){
   		$img = file_get_contents(storage_path('app/absensi_snapshots/default.png'));
		return response($img)->header('Content-type','image/jpeg');
   	}
   		$pic= Absensi::where('foto', '=', $file)->first();
		
	 if($pic != null)
	 {
		$path = storage_path('app/absensi_snapshots/'.$pic->foto);
		if(file_exists($path))
		{ 
			$img = file_get_contents($path);
			return response($img)->header('Content-type','image/jpeg');
		} else {
			$img = file_get_contents(storage_path('app/absensi_snapshots/default.png'));
			return response($img)->header('Content-type','image/jpeg');
		}
	 } else {
		$img = file_get_contents(storage_path('app/absensi_snapshots/default.png'));
		return response($img)->header('Content-type','image/jpeg');
	}

	}
	public function showAbsenPulang($file)
   {
   	if($file == "default"){
   		$img = file_get_contents(storage_path('app/absensi_snapshots/default.png'));
		return response($img)->header('Content-type','image/jpeg');
   	}
   		$pic= Absensi::where('foto_pulang', '=', $file)->first();
		
	 if($pic != null)
	 {
		$path = storage_path('app/absensi_snapshots/'.$pic->foto_pulang);
		if(file_exists($path))
		{ 
			$img = file_get_contents($path);
			return response($img)->header('Content-type','image/jpeg');
		} else {
			$img = file_get_contents(storage_path('app/absensi_snapshots/default.png'));
			return response($img)->header('Content-type','image/jpeg');
		}
	 } else {
		$img = file_get_contents(storage_path('app/absensi_snapshots/default.png'));
		return response($img)->header('Content-type','image/jpeg');
	}

	}
	public function showMTT($file)
   {
   	if($file == "default.png"){
   		$img = file_get_contents(storage_path('app/ticketing/default.png'));
		return response($img)->header('Content-type','image/jpeg');
   	}
   		$pic= TicketingMaintenance::where('screenshot', '=', $file)->first();
		
	 if($pic != null)
	 {
		$path = storage_path('app/ticketing/'.$pic->screenshot);
		if(file_exists($path))
		{ 
			$img = file_get_contents($path);
			return response($img)->header('Content-type','image/jpeg');
		} else {
			$img = file_get_contents(storage_path('app/ticketing/default.jpg'));
			return response($img)->header('Content-type','image/jpeg');
		}
	 } else {
		$img = file_get_contents(storage_path('app/ticketing/default.jpg'));
		return response($img)->header('Content-type','image/jpeg');
	}

	}
   public function showKaryawan($file)
   {
   	if($file == "default"){
   		$img = file_get_contents(storage_path('app/karyawan/default.jpg'));
		return response($img)->header('Content-type','image/jpeg');
   	}
   		$pic= Karyawan::where('foto', '=', $file)->first();
		
	 if($pic != null)
	 {
		$path = storage_path('app/karyawan/'.$pic->foto);
		if(file_exists($path))
		{ 
			$img = file_get_contents($path);
			return response($img)->header('Content-type','image/jpeg');
		} else {
			$img = file_get_contents(storage_path('app/karyawan/default.jpg'));
			return response($img)->header('Content-type','image/jpeg');
		}
	 } else {
		$img = file_get_contents(storage_path('app/karyawan/default.jpg'));
		return response($img)->header('Content-type','image/jpeg');
	}

	}
}
