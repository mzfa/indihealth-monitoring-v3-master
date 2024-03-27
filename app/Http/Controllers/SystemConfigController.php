<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JSon;
use App\Models\Absensi;
use App\Models\WebConfig;
use Illuminate\Support\Facades\Log;
use Image;
use Str;
use Cache;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class SystemConfigController extends Controller
{
    public function absensi()
    {
    	$data = (object) $this->jsonConfigParser('absensi');
    	// dd($data);
    	return view('config.absensi')->with(['data' => $data]);
    } 
    public function penggajian()
    {
    	$data = (object) $this->jsonConfigParser('penggajian');
    	// dd($data);
    	return view('config.penggajian')->with(['data' => $data]);
    } 
    public function pulang()
    {
    	$data = (object) $this->jsonConfigParser('jam_pulang');
    	// dd($data);
    	return view('config.jam_pulang')->with(['data' => $data]);
    } 

    public function getlatlng(Request $request)
    {
        
         $response = json_decode(\Curl::to('https://dev.virtualearth.net/REST/v1/Locations?q='.urlencode($request->address).'&key=AgCRMh3Aq-zhk5GKgMC9NX25AHTnH5RjDbJ5zJapwOVhaynZu-iQl4YK28aVzJig')
        ->get());
         // var_dump('https://dev.virtualearth.net/REST/v1/Locations?q='.$request->address.'&key=AgCRMh3Aq-zhk5GKgMC9NX25AHTnH5RjDbJ5zJapwOVhaynZu-iQl4YK28aVzJig'); exit();

         if(!empty($response))
         {
             $coordinates['status'] = true;
             $coordinates['address'] = @$response->resourceSets[0]->resources[0]->address->formattedAddress;
             $coordinates['lat'] = @$response->resourceSets[0]->resources[0]->point->coordinates[0];
             $coordinates['lng'] = @$response->resourceSets[0]->resources[0]->point->coordinates[1];
         } else{
            $coordinates['status'] = false;
            $coordinates['message'] = "Lokasi Tidak Ditemukan";
         }


        return response()->json($coordinates);
    } 

    public function system_setting()
    {
        $cfg['autolock'] = WebConfig::where('config_name', 'CFG-AUTOLOCK')->first()->config_value;
        $cfg['logo'] = WebConfig::where('config_name', 'CFG-LOGO')->first()->config_value;
        $cfg['front_bg'] = WebConfig::where('config_name', 'CFG-FRONTBG')->first()->config_value;
        $data = DB::table('web_config_absensi')->where('web_config_id',1)->first();

        return view('config.sys_cfg')->with(['config' => (object)$cfg, 'data' => $data]);
    }

    public function system_setting_save(Request $request)
    {
        // dd($request);
        if($request->geofence == 1){
          $validate = [
            'radius_kantor' => "required",
            'radius_rumah' => "required",
            'long' => "required",
            'lat' => "required",
          ];
          $this->validate($request, $validate);
          $geofence = $request->geofence;
        }else{
          $geofence = 0;
        }
        $data = [
          'updated_by' => auth()->user()->name." (".auth()->user()->email.")",
          'updated_at' => now(),
          'long' => $request->long,
          'lat' => $request->lat,
          'radius_kantor' => $request->radius_kantor,
          'radius_rumah' => $request->radius_rumah,
          'status' => $geofence,
          'status_absen_dirumah' => $request->status_absen_dirumah ?? 0,
        ];
        $status_dokumen_administrasi = "Aktif";
        DB::table('web_config_absensi')->where(['web_config_id' => 1])->update($data);

        // WebConfig::where('config_name', 'CFG-AUTOLOCK')->update(['config_value' => $autolock]);
        // $data['jam_pulang'] = $request->jam_pulang;
        // $data['notify_minutes'] = $request->minutes;
        $title = 'Config';
        $message['username'] = auth()->user()->name." (".auth()->user()->email.")";
        $message['messages'] = "Telah mengubah konfigurasi sistem menjadi ";
        $message['ip_address'] = $request->ip();
        $message['time'] = date('Y-m-d H:i:s');
        Log::notice($title.' '.json_encode($message));  
        return redirect()->route('config.sys')->with(['message_success' => "Berhasil menerapkan perubahan"]);
    }

    public function penggajianSave(Request $request)
    {
    	$validate = [
        'gaji_pokok' => "required",
        'tunjangan' => "required",
        'potongan_absen' => "required",
        'potongan_setengah_hari' => "required",
      ];
        $this->validate($request, $validate);

    	$data = $this->jsonConfigParser('absensi');
    	$data['gaji_pokok'] = $request->gaji_pokok;
    	$data['tunjangan'] = $request->tunjangan;
    	$data['potongan_absen'] = $request->potongan_absen;
    	$data['potongan_setengah_hari'] = $request->potongan_setengah_hari;
      $title = 'Config';
      $message['username'] = auth()->user()->name." (".auth()->user()->email.")";
      $message['messages'] = "Telah mengubah konfigurasi penggajian menjadi ".json_encode($data);
      $message['ip_address'] = $request->ip();
      $message['time'] = date('Y-m-d H:i:s');
      Log::notice($title.' '.json_encode($message));                       
    	$this->jsonConfigSave('penggajian', json_encode($data));

    	return JSon::response(200,'config',['message_success' => "Berhasil menyimpan pengaturan."],[]); 

    }
    public function absensiSave(Request $request)
    {
    	$validate = [
                            'masuk_start' => "date_format:H:i|required",
                            'masuk_end' => "date_format:H:i|required",
                            'keluar_start' => "date_format:H:i|required",
                            'keluar_end' => "date_format:H:i|required",
                            ];
        $this->validate($request, $validate);

    	$data = $this->jsonConfigParser('absensi');
    	$data['masuk_start'] = $request->masuk_start;
    	$data['masuk_end'] = $request->masuk_end;
    	$data['keluar_start'] = $request->keluar_start;
    	$data['keluar_end'] = $request->keluar_end;
      $title = 'Config';
      $message['username'] = auth()->user()->name." (".auth()->user()->email.")";
      $message['messages'] = "Telah mengubah konfigurasi absensi menjadi ".json_encode($data);
      $message['ip_address'] = $request->ip();
      $message['time'] = date('Y-m-d H:i:s');
      Log::notice($title.' '.json_encode($message));                       
    	$this->jsonConfigSave('absensi', json_encode($data));

    	return JSon::response(200,'config',['message_success' => "Berhasil menyimpan pengaturan."],[]); 

    }

    public function pulangSave(Request $request)
    {
    	$validate = [
                            'jam_pulang' => "date_format:H:i|required",
                            'minutes' => "integer|max:120|min:5|required",
                            ];
        $this->validate($request, $validate);

    	$data = $this->jsonConfigParser('jam_pulang');
    	$data['jam_pulang'] = $request->jam_pulang;
    	$data['notify_minutes'] = $request->minutes;
      $title = 'Config';
      $message['username'] = auth()->user()->name." (".auth()->user()->email.")";
      $message['messages'] = "Telah mengubah konfigurasi jam pulang menjadi ".json_encode($data);
      $message['ip_address'] = $request->ip();
      $message['time'] = date('Y-m-d H:i:s');

      Log::notice($title.' '.json_encode($message));                       
    	$this->jsonConfigSave('jam_pulang', json_encode($data));
      $data = $this->jsonConfigParser('jam_pulang');

    	return JSon::response(200,'config',['message_success' => "Berhasil menyimpan pengaturan.",'data' => $data ],[]); 

    }
    
    public function notifPulang()
    {
         $data = (object) $this->jsonConfigParser('jam_pulang');
         $jampulang = strtotime(date('Y-m-d ').$data->jam_pulang);
         $sekarang = strtotime(now()->addMinutes($data->notify_minutes));
         $absen_pulang_cek =  Absensi::where(['karyawan_id' =>  auth()->user()->karyawan_id,'tanggal' => date("Y-m-d")])->where('jam_keluar', null)->count();

         if(Cache::has('notify_pulang-'.auth()->user()->id))
         {
           	return JSon::response(200,'notif',['status' => false],[]); 
         }
         if($sekarang >= $jampulang && !empty($absen_pulang_cek))
         {
            Cache::put('notify_pulang-'.auth()->user()->id, true, (60*$data->notify_minutes)/2);
             $res['status'] = true;
             $res['messages'] = "Apakah pekerjaan anda sudah selesai? ".$data->notify_minutes." menit lagi waktunya pulang, kami mengingatkan jangan lupa melakukan absensi pulang.";
             return JSon::response(200,'notif',$res,[]); 
         } else{
           return JSon::response(200,'notif',['status' => false],[]); 
         }


    }

    private function jsonConfigParser($name)
    {
    	$jsonString = file_get_contents(storage_path('app/config/'.$name.'.json'));
      $data = json_decode($jsonString, true);
      return $data;
    }

    private function jsonConfigSave($name, $data)
    {
    	$jsonString = file_put_contents(storage_path('app/config/'.$name.'.json'), $data);

		return true;
    }

    private function imageProcessingBackground($file)
    {
         $uuid = Uuid::uuid4();
         $file = $file;
         $ext =  $file->getClientOriginalExtension();
         $rand = Str::random(8);
         $imgname = 'bg-monitoring-'.date('Ymd')."_".$uuid->toString().'.'.$ext;

         $dest_path = storage_path('app/bg/');
          if(!is_dir($dest_path)){
             mkdir($dest_path,770);
          }

          Image::make($file->getRealPath())
                          ->resize(1000,null,function($constraint)
                            {
                              $constraint->aspectRatio();
                              $constraint->upsize();
                             })
                          ->save($dest_path."/".$imgname,75);
          return $imgname;
    }
}
