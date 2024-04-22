<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Helpers\JSon;
use Agent;
use Calendar;
use Ramsey\Uuid\Uuid;
use App\Exports\AbsensiExport;
use App\Http\Resources\AbsensiShow;
use App\Http\Requests\AbsensiExportRequest;
use App\Mail\MailAccAbsen;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Support\Str;
use Log;
use UserHelper;

class AbsensiController extends Controller
{
    public function export(AbsensiExportRequest $request)
    {

        $ds = date('Y-m-d',strtotime($request->start_date));
        $de = date('Y-m-d',strtotime($request->end_date));
        $karyawan_id = $request->karyawan_id;
        // dd($karyawan_id);
        if($karyawan_id != 'Semua')
        {
             $kry = Karyawan::select('nama_lengkap')->where('id', $karyawan_id)->first();
             $fname = 'ABSENSI-'.Str::kebab(strip_tags($kry->nama_lengkap)).'-'.$ds.'-'.$de.'.xlsx';
        } else{
             $fname = 'ABSENSI-'.$ds.'-'.$de.'.xlsx';
        }
       
       return  \Excel::download(new AbsensiExport($ds,$de,$karyawan_id), $fname);
    }
    public function create(Request $request)
    {
        $validate = [
                            'tanggal' => "date|required",
                            'karyawan_id' => "required|exists:\App\Models\Karyawan,id",
                            'masuk' => "date_format:H:i|required",
                            'keluar' => "date_format:H:i|required",
                            'lat' => "required|numeric",
                            'lng' => "required|numeric",
                    ];
        $this->validate($request, $validate);
         $abs = Absensi::where(['karyawan_id' =>  $request->karyawan_id,'tanggal' => $request->tanggal]);
         if($abs->count() > 0)
         {
            $data['absensi']="Absensi "."  pada tanggal ".$request->tanggal." atas nama ".$abs->first()->karyawan->nama_lengkap." sudah diinputkan.";
            return JSon::validateError(422,'errors',$data);
             // return JSon::response(422,'absensi',['message_fail' => "Berhasil menyimpan Absensi."],[]); 
         }
        Absensi::create([
                    'karyawan_id'   => $request->karyawan_id,
                    'tanggal'       => $request->tanggal,
                    'ip_address'    => $request->ip(),
                    'browser'       => $this->browserGetter(),
                    'platform'      => $this->platformGetter(),
                    'is_req_acc' => true,
                    'foto_pulang' => 'absen-manual.jpg',
                    'foto' => 'absen-manual.jpg',
                    'lat_pulang' => $request->lat,
                    'lng_pulang' => $request->lng,
                    'jam_keluar' => $request->keluar,
                    'jam_masuk' => $request->masuk,
                    'jam_kerja' => Calendar::getHour($request->masuk,$request->keluar),
                    'updated_by'    => auth()->user()->id,
                ]);
        return JSon::response(200,'absensi',['message_success' => "Berhasil menyimpan Absensi."],[]); 
    }
    public function absenStat(Request $request)
    {
      $data['absensi_masuk'] = Absensi::where('tanggal',date('Y-m-d'))->whereNotNull('jam_masuk')->count();
      $data['absensi_keluar'] = Absensi::where('tanggal',date('Y-m-d'))->whereNotNull('jam_keluar')->count();
      $data['total_karyawan'] = Karyawan::whereNull('resign_date')->whereHas('jabatan',function($query)
      {
        $query->whereNotIn('nama',['Owner']);
      })->count();

        return JSon::response(200,'absensi',$data,[]);
    }
    function getDistanceBetweenPointsNew($lat1, $lon1, $lat2, $lon2, $unit = 'miles') {
        $radius = 6371; // Earth's radius in kilometers

        // Calculate the differences in latitude and longitude
        $delta_lat = $lat2 - $lat1;
        $delta_lon = $lon2 - $lon1;

        // Calculate the central angles between the two points
        $alpha = $delta_lat / 2;
        $beta = $delta_lon / 2;
        // Use the Haversine formula to calculate the distance
        $a = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($beta)) * sin(deg2rad($beta));
        $c = asin(min(1, sqrt($a)));
        $distance = 2 * $radius * $c;
        // Round the distance to four decimal places
        $distance = round($distance, 4);
        $meters = $distance * 1000;

        return $meters; 
    }
    public function cek_lokasi(Request $request)
    {
        // dd(auth()->user());
        if(isset($request->jenis)){
            $alasan = $request->data;
            $data = [
                'created_at' => date('Y-m-d'),
                'karyawan_id' => auth()->user()->karyawan_id,
                'isi_pesan' => $alasan,
            ];
            DB::table('alasan_absen')->insert($data);
            return 'berhasil';
        }else{
            if(auth()->user()->karyawan_id == null){
                return 'belum_terhubung_karyawan';
            }
            $absen = DB::table('alasan_absen')->where('karyawan_id',auth()->user()->karyawan_id)->where('created_at',date('Y-m-d'))->first();
            if(!empty($absen)){
                if($absen->acc_by !== null && $absen->status == 'terima'){
                    return 'berhasil';
                }elseif($absen->acc_by !== null && $absen->status == 'tolak'){
                    return 'ditolak';
                }else{
                    return 'belum_acc';
                }
            }else{
                $data = DB::table('web_config_absensi')->where('web_config_id',1)->first();
                $beda = $this->getDistanceBetweenPointsNew($data->long,$data->lat,$request->lat,$request->lng);
                // dd($beda);
                if($beda > $data->radius_kantor){
                    return 'false';
                }else{
                    return 'berhasil';
                }
            }
        }
    }
    public function doAbsen(Request $request)
    {
        $data = DB::table('web_config_absensi')->where('web_config_id',1)->first();
        if($data->status == 1){
            $beda = $this->getDistanceBetweenPointsNew($data->long,$data->lat,$request->lat,$request->lng);
            $absen = DB::table('alasan_absen')->where('karyawan_id',auth()->user()->karyawan_id)->where('created_at',date('Y-m-d'))->first();
            if(!empty($absen)){
                if($absen->acc_by !== null && $absen->status == 'terima'){
                    
                }else{
                    if($beda > $data->radius_kantor){
                        $data="Anda tidak dapat melakukan absen, karena jarak anda ke kantor masih ". $beda." Meter lagi";
                        return JSon::response(400,'absensi',[],$data);
                    }
                }
            }else{
                if($beda > $data->radius_kantor){
                    $data="Anda tidak dapat melakukan absen, karena jarak anda ke kantor masih ". $beda." Meter lagi";
                    return JSon::response(400,'absensi',[],$data);
                }
            }
        }
        if($data->status_absen_dirumah == 1){
            if($beda > $data->radius_rumah){
                $data="Anda tidak dapat melakukan absen, karena jarak anda ke rumah masih ". $beda." Meter lagi";
                return JSon::response(400,'absensi',[],$data);
            }
        }
        if(empty(auth()->user()->karyawan_id))
        {
             $this->loggingAbsen('ABSENSI-FAIL (NO-BIND-KRY)',$request,'warning');
             $data="Anda tidak dapat melakukan absen, karena akun anda belum terkait dengan karyawan";
             return JSon::response(400,'absensi',[],$data);
        }
         if(UserHelper::cekCuti(auth()->user()->karyawan_id,date('Y-m-d')))
         {
            $this->loggingAbsen('ABSENSI-FAIL (CUTI)',$request,'warning');
             return JSon::response(400,'absensi',[],"Tidak dapat melakukan absensi, karena hari ini anda sedang cuti.");
         }
        if($request->lat == "NaN" || $request->lng == "NaN")
        {
             $this->loggingAbsen('ABSENSI-FAIL (LOCATION)',$request,'warning');
             return JSon::response(400,'absensi',[],"Tidak dapat mengambil lokasi anda, mohon cek koneksi internet anda, jika sudah lakukan muat ulang halaman dengan menekan tombol 'CTRL+F5'.");
        }
        $data= null;
        try {
            if(md5(session('absen_token')) != md5($request->token_absen))
            {
                return JSon::response(400,'absensi',[],"Anda sudah melakukan absensi.");
            }

            if(Karyawan::where('id',auth()->user()->karyawan_id)->count() == 0)
            {   
                $this->loggingAbsen('ABSENSI-FAIL (NO-BIND-KRY)',$request);
                return JSon::response(400,'absensi',[],"Akun anda belum terkait dengan karyawan, silahkan hubungi administrator.");
            }
            $conf = \Config::load('absensi');
            if(time() >= strtotime($conf->masuk_start) AND time() <= strtotime($conf->masuk_end))
            {
                $abs = Absensi::where(['karyawan_id' =>  auth()->user()->karyawan_id,'tanggal' => date("Y-m-d")]);
                if($abs->count() == 0)
                {
                    $data = Absensi::create($this->paramsSelfAbsen($request));
                    $this->loggingAbsen('ABSENSI-MASUK',$request);
                } else{
                     return JSon::response(400,'absensi',[],"Anda sudah melakukan absensi, anda dapat kembali absen pulang ketika pukul ". $conf->keluar_start);
                }
            } elseif(time() >= strtotime($conf->keluar_start) AND time() <= strtotime($conf->keluar_end))
            {

                $abs = Absensi::where(['karyawan_id' =>  auth()->user()->karyawan_id,'tanggal' => date("Y-m-d")]);
                if($abs->count() == 0)
                {
                  $this->loggingAbsen('ABSENSI-MASUK',$request);
                  $data = Absensi::create($this->paramsSelfAbsen($request));
                } else{
                    $absen = $abs->first();
                    $this->loggingAbsen('ABSENSI-KELUAR',$request);
                    $data = $abs->update($this->paramsSelfAbsen($request,true,  $absen->tanggal." ".$absen->jam_masuk));
                }

            }else{
                return JSon::response(400,'absensi',[],"Periksa kembali jadwal kerja anda ");
            }
            $request->session()->forget('absen_token');
            return JSon::response(200,'absensi',$data,[]);
        } catch (Exception $e) {
               $this->loggingAbsen('ABSENSI-ERROR',$request,'alert');
               return JSon::response(400,'absensi',[],"internal server error");
            }
    }
    private function loggingAbsen($status,$request,$servere = "notice")
    {
      $title = $status;
      $message['nama'] = !empty(auth()->user()->karyawan) ? auth()->user()->karyawan->nama_lengkap:"-";
      $message['reqMethod'] = strtoupper($request->method());
      $message['path_request'] = $request->path();
      $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
      $message['ip_address'] = $request->ip();
      $message['lat_lng'] = $request->lat.', '.$request->lng;
      $message['time'] = date('Y-m-d H:i:s');
      if($servere == 'notice')
      {
        Log::notice($title." ".json_encode($message));
      } elseif($servere == 'warning')
      {
        Log::warning($title." ".json_encode($message));
      } elseif($servere == 'danger')
      {
        Log::alert($title." ".json_encode($message));
      }
    }
    public function index(Request $request)
    {
        if(!empty($request->absen_id))
        {
          Absensi::where('id',$request->absen_id)
          ->update([
            'is_read' => true,
          ]);
        }

        return view('absensi.index');
    }

    public function indexSelf()
    {
        return view('absensi.index_self');
    }

     public function indexKaryawan($kry_id)
    {
        $karyawan = Karyawan::where('id',$kry_id)->firstOrFail();
        return view('absensi.index_karyawan')->with(['karyawan'=>$karyawan]);
    }
    public function request_absen(Request $request)
    {
        $validate = [
            'id' => "required|exists:\App\Models\Absensi,id",
            'jam' => "required|date_format:H:i",
        ];
        $this->validate($request, $validate);
      $absen = Absensi::where('id',$request->id)->where('karyawan_id', auth()->user()->karyawan->id);
      if($absen->count() == 0)
      {
        $data['messages'] ="Absensi tidak ditemukan.";
        return JSon::validateError(422,'errors',$data);
      }
      $abs = $absen->first();
      $jam_masuk = strtotime($abs->tanggal.", ".$abs->jam_masuk);
      $jam_request = strtotime($abs->tanggal.", ".$request->jam.":00");
      if($jam_request < $jam_masuk)
      {
        $data['messages'] ="Jam yang direquest harus lebih dari jam masuk.";
        return JSon::validateError(422,'errors',$data);
      }


      Absensi::where('id',$request->id)
      ->where('karyawan_id', auth()->user()->karyawan->id)
      ->update(['request_absen_keluar' => $request->jam.":00",'requested_absen_at' => now()]);
      $data['message'] = "Berhasil Request absen pulang, mohon tunggu persetujuan dari admin.";
      return JSon::response(200,'absensi',$data,[]);

    }
    public function acc_absen_keluar(Request $request)
    {
      $validate = [
                    'id' => "required|exists:\App\Models\Absensi,id",

                    ];
        $this->validate($request, $validate);
      $absen = Absensi::where('id',$request->id)->whereNotNull('request_absen_keluar');
      if($absen->count() == 0)
      {
        $data['messages'] ="Tidak Dapat Menyetujui absensi ini, karena tidak ada request absensi.";
        return JSon::validateError(422,'errors',$data);
      }
      $abs = $absen->first();
      Absensi::where('id',$request->id)
      ->update([
        'is_req_acc' => true,
        'foto_pulang' => $abs->foto,
        'lat_pulang' => $abs->lat,
        'lng_pulang' => $abs->lng,
        'jam_keluar' => $abs->request_absen_keluar,
        'jam_kerja' => Calendar::getHour($abs->jam_masuk,$abs->request_absen_keluar),
      ]);
      try{

        // dd($taskMT->member->email);
        Mail::to($abs->karyawan->user->email)->send(new MailAccAbsen($abs));

       } catch(\Exception $e){
         // dd($e->getMessage());
       }
      $data['message'] = "Anda telah menyetujui absensi ".$abs->karyawan->nama_lengkap;
      return JSon::response(200,'absensi',$data,[]);

    }
    public function showAbsen(Request $request)
    {
        $absen = Absensi::where('id',$request->id)->first();
        $data = new AbsensiShow($absen);
        $message['user'] = auth()->user()->name;
        // dd($data);
        $message['employee_target'] = "(".$data->karyawan_id.") ".$absen->karyawan->nama_lengkap;
        $message['ip_address'] = $request->ip();
        $message['reqMethod'] = strtoupper($request->method());
        $message['path_request'] = $request->path();
        $message['time'] = date('Y-m-d H:i:s');
        Log::notice("SHOW-ABSEN"." ".json_encode($message));
        return JSon::response(200,'absensi',$data,[]);
    }

    public function getDataAbsenStatSelf(Request $request)
    {
        if(!empty($request->bulan) AND !empty($request->tahun))
        {
            $bln=$request->tahun.'-'.$request->bulan;
        } else{
            $bln=date("Y-m");
        }
            $total_hadir_bulan_ini = Absensi::where('karyawan_id', auth()->user()->karyawan_id)->where('tanggal','like',$bln."%")->count();
            $total_jam_kerja = Absensi::where('karyawan_id', auth()->user()->karyawan_id)->sum('jam_kerja');
            $avg_jam_kerja_bln = Absensi::where('karyawan_id', auth()->user()->karyawan_id)->where('tanggal','like',$bln."%")->avg('jam_kerja');
            $avg_jam_kerja = Absensi::where('karyawan_id', auth()->user()->karyawan_id)->avg('jam_kerja');
            $data['kehadiran_bulan_ini'] = $total_hadir_bulan_ini;
            $data['avg_jam_kerja_bln'] =  doubleval(number_format($avg_jam_kerja_bln,2));
            $data['avg_jam_kerja'] =  doubleval(number_format($avg_jam_kerja,2));
            $data['total_jam_kerja'] =  doubleval(number_format($total_jam_kerja,2));

            return JSon::response(200,'absensi',$data,[]);
    } 

    public function getDataAbsenStatKaryawan(Request $request)
    {
        if(!empty($request->bulan) AND !empty($request->tahun))
        {
            $bln=$request->tahun.'-'.$request->bulan;
        } else{
            $bln=date("Y-m");
        }
            $total_hadir_bulan_ini = Absensi::where('karyawan_id', $request->karyawan_id)->where('tanggal','like',$bln."%")->count();
            $total_jam_kerja = Absensi::where('karyawan_id', $request->karyawan_id)->sum('jam_kerja');
            $avg_jam_kerja_bln = Absensi::where('karyawan_id', $request->karyawan_id)->where('tanggal','like',$bln."%")->avg('jam_kerja');
            $avg_jam_kerja = Absensi::where('karyawan_id', $request->karyawan_id)->avg('jam_kerja');
            $data['kehadiran_bulan_ini'] = $total_hadir_bulan_ini;
            $data['avg_jam_kerja_bln'] =  doubleval(number_format($avg_jam_kerja_bln,2));
            $data['avg_jam_kerja'] =  doubleval(number_format($avg_jam_kerja,2));
            $data['total_jam_kerja'] =  doubleval(number_format($total_jam_kerja,2));

            return JSon::response(200,'absensi',$data,[]);
    }

    public function showAbsenSelf(Request $request)
    {
        $dataAbsen = Absensi::where('id',$request->id)->where('karyawan_id', auth()->user()->karyawan_id)->first();
        if(empty($dataAbsen))
        {
             $data['absensi']="Absensi ini tidak ditemukan.";
             return JSon::validateError(422,'errors',$data);
        }
        $data = new AbsensiShow($dataAbsen);

        return JSon::response(200,'absensi',$data,[]);
    }

    public function showAbsenKaryawan(Request $request)
    {
        $dataAbsen = Absensi::where('id',$request->id)->first();
        if(empty($dataAbsen))
        {
             $data['absensi']="Absensi ini tidak ditemukan.";
             return JSon::validateError(422,'errors',$data);
        }
        $data = new AbsensiShow($dataAbsen);

        return JSon::response(200,'absensi',$data,[]);
    }
    ///APIS
    public function getDataAbsen(Request $request)
    {
        if(!empty($request->bulan) AND !empty($request->tahun))
        {
            $data = Absensi::where('tanggal','like',$request->tahun.'-'.$request->bulan.'%')->get();
        } elseif(!empty($request->absen_id)) {
            $data = Absensi::where('id',$request->absen_id)->get();
        }
        else{
            $data = Absensi::where('tanggal','like',date('Y-m').'%')->orderBy('created_at','DESC')->get();

        }
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('foto', function ($data) {
               return view('absensi.partials.foto')->with(['data' => $data])->render();
            })
            ->addColumn('aksi', function ($data) {
               return view('absensi.partials.aksi')->with(['data' => $data])->render();
            })
            ->editColumn('jam_kerja', function ($data) {
               return number_format($data->jam_kerja,2);
            })
            ->editColumn('jam_keluar', function ($data) {
                return view('absensi.partials.reqkeluar')->with(['data' => $data,])->render();
            })
            ->editColumn('jam_masuk', function ($data) {

               if(empty($data->jam_masuk))
               {
                  return "<span class='badge badge-warning'>Belum Absen</span>";
               }else
               {
                  return $data->jam_masuk;
               }
            })
            ->addColumn('nama_karyawan', function ($data) {
               return $data->karyawan->nama_lengkap;
            })
            ->addColumn('tipe', function ($data) {
               return empty($data->karyawan->tipe_karyawan)?"-":$data->karyawan->tipe_karyawan;
            })
            ->addColumn('nip', function ($data) {
               return $data->karyawan->nip;
            })
            ->rawColumns(['foto','aksi','jam_keluar','jam_masuk'])
            ->make(true);
    }
    public function getDataAbsenSelf(Request $request)
    {
       if(!empty($request->bulan) AND !empty($request->tahun))
        {
            $data = Absensi::where('tanggal','like',$request->tahun.'-'.$request->bulan.'%')->where('karyawan_id', auth()->user()->karyawan_id)->get();
        } else{
            $data = Absensi::where('tanggal','like',date('Y-m').'%')->where('karyawan_id', auth()->user()->karyawan_id)->orderBy('created_at','DESC')->get();

        }
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->editColumn('jam_kerja', function ($data) {
               return number_format($data->jam_kerja,2);
            })
            ->addColumn('foto', function ($data) {
               return view('absensi.partials.foto')->with(['data' => $data])->render();
            })
            ->editColumn('jam_keluar', function ($data) {
                $conf = \Config::load('jam_pulang');
                return view('absensi.partials.keluar')->with(['data' => $data,'conf' =>   $conf])->render();
            })
            ->editColumn('jam_masuk', function ($data) {
               if(empty($data->jam_masuk))
               {
                  return "<span class='badge badge-warning'>Belum Absen</span>";
               }else
               {
                  return $data->jam_masuk;
               }
            })
            ->addColumn('aksi', function ($data) {
               return view('absensi.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['foto','aksi','jam_keluar','jam_masuk'])
            ->make(true);
    }

    public function getKaryawanAbsensi(Request $request)
    {
       if(!empty($request->bulan) AND !empty($request->tahun))
        {
            $data = Absensi::where('tanggal','like',$request->tahun.'-'.$request->bulan.'%')->where('karyawan_id',$request->karyawan_id)->get();
        } else{
            $data = Absensi::where('tanggal','like',date('Y-m').'%')->where('karyawan_id',$request->karyawan_id)->orderBy('created_at','DESC')->get();

        }
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->editColumn('jam_kerja', function ($data) {
               return number_format($data->jam_kerja,2);
            })
            ->addColumn('foto', function ($data) {
               return view('absensi.partials.foto')->with(['data' => $data])->render();
            })
            ->editColumn('jam_keluar', function ($data) {
                $conf = \Config::load('jam_pulang');
                return view('absensi.partials.keluar_mode_read')->with(['data' => $data,'conf' =>   $conf])->render();
            })
            ->editColumn('jam_masuk', function ($data) {
               if(empty($data->jam_masuk))
               {
                  return "<span class='badge badge-warning'>Belum Absen</span>";
               }else
               {
                  return $data->jam_masuk;
               }
            })
            ->addColumn('aksi', function ($data) {
               return view('absensi.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['foto','aksi','jam_keluar','jam_masuk'])
            ->make(true);
    }



    private function browserGetter()
    {
        if(empty(Agent::device()))
        {
            if(Agent::isAndroidOS())
            {
                 return Agent::browser()." (Android Device)";
            } elseif(Agent::isSafari())
            {
                return Agent::browser()." (Iphone)";
            } elseif(Agent::isMobile())
            {
                return Agent::browser()." (Mobile Device)";
            } elseif(Agent::isDesktop())
            {
                return Agent::browser()." (Desktop/Laptop)";
            } elseif(Agent::isTablet())
            {
                return Agent::browser()." (Tablet)";
            }
        } else{
            return Agent::browser()." (".Agent::device().")";
        }
    }
    private function platformGetter()
    {
        $os = Agent::platform();
        $version = Agent::version($os);

        return $os." ".$version;
    }
    private function paramsSelfAbsen($request,$pulang=false,$jamMasuk = null)
    {
        $img = $this->imageProcessing($request);
        $params = [
                    'karyawan_id'   => auth()->user()->karyawan_id,
                    'tanggal'       => date('Y-m-d'),
                    'ip_address'    => $request->ip(),
                    'browser'       => $this->browserGetter(),
                    'platform'      => $this->platformGetter(),
                    'updated_by'    => auth()->user()->id,
        ];
        if($pulang)
        {
            $jamPulang = date('Y-m-d H:i:s');
            if(!empty($jamMasuk))
            {
                $jam_kerja = Calendar::getHour($jamMasuk,$jamPulang);
                $params['jam_kerja'] = $jam_kerja;
            }

            $params['jam_keluar'] = date('H:i:s',strtotime($jamPulang));
            $params['foto_pulang'] = $img;
            $params['lng_pulang'] = $request->lng;
            $params['lat_pulang'] = $request->lat;
        } else{
            $params['jam_masuk'] = date('H:i:s');
            $params['foto'] = $img;
            $params['lng'] = $request->lng;
            $params['lat'] = $request->lat;
        }

        return $params;
    }
    private function imageProcessing($request)
    {
        $image = $request->img;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $uuid = Uuid::uuid4();
        $dir = storage_path(). '/app/absensi_snapshots/';
        // dd(\App\Models\User::first()->karyawan);
         if(!file_exists($dir)){
                mkdir($dir,770);
            }
        $imageName = auth()->user()->karyawan->nip."_".date('Ymd')."_".$uuid->toString().'.'.'jpg';
        $path =$dir . $imageName;
        \File::put($path, base64_decode($image));

        return  $imageName;
    }
}
