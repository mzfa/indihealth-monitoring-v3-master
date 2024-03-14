<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Jabatan;
use App\Http\Requests\KaryawanCreateRequest;
use App\Http\Requests\KaryawanUpdateRequest;
use App\Http\Requests\KaryawanDeleteRequest;
use App\Http\Resources\KaryawanSelect;
use DB;
use Image;
use Str;
use Ramsey\Uuid\Uuid;

class PenggajianController extends Controller
{
    public function index()
    {
      $data = Karyawan::orderBy('created_at','DESC')->get();
      $datanya = [];
      $tanggal_awal = date("Y-m-01");
      $periode = date('2023-12');
      $tanggal_akhir = date("Y-m-t", strtotime($periode));
      $gaji_pokok = 5000000;

      $tanggalan = '';
      $total_hari = 0;
      for ($i=1; $i <= 31; $i++) { 
        $tgl = $periode.'-'.sprintf('%02d', $i);
        $hari = date('l', strtotime($tgl));
        if($hari != "Sunday" && $hari != "Saturday"){
          $tanggalan .= "'$tgl',";
          $total_hari +=1;
        }

        if($tgl == $tanggal_akhir){
          break;
        }
        // echo "<br>";
      }
      // $tanggalan = "($tanggalan)";
      $tanggalan = substr($tanggalan,0,-1);
      // dump($tanggalan);
      foreach($data as $item){
        
        $absen = DB::select("SELECT * FROM absensi WHERE karyawan_id = '$item->id' and tanggal in ($tanggalan)");
        // echo "SELECT * FROM absensi WHERE karyawan_id = '$item->id' and tanggal in ($tanggalan)";
        // dump($absen);
        $total_absen = 0;
        foreach($absen as $item2){
          $total_absen +=1;
        }
        $potongan = ($total_hari - $total_absen) * 100000;
        $datanya[] = [
          'nip' => $item->nip,
          'nama_lengkap' => $item->nama_lengkap,
          'ttl' => $item->tempat_lahir.', '. date('d-m-Y', strtotime($item->tanggal_lahir)),
          'jabatan' => $item->jabatan->nama,
          'potongan' => $potongan,
          'gaji_pokok' => $gaji_pokok,
        ];
      }
      // die();
      // dd('ok');
      // $data = DB::select("SELECT * FROM karyawan JOIN jabatan ON karyawan.jabatan_id = jabatan.id ORDER BY created_at DESC")->get();
    	return view('penggajian.index', compact('datanya'));
    }

    public function create()
    {
      $jabatan = Jabatan::orderBy('nama','ASC')->get();
      return view('penggajian.create')->with(['jabatan' => $jabatan]);
    }

    public function delete(KaryawanDeleteRequest $request)
    {
      Karyawan::where('id', $request->id)->delete();
      return redirect()->back()->with(['message_success' => "Berhasil menghapus Karyawan"]);
    }
    public function edit($id)
    {

      $jabatan = Jabatan::orderBy('nama','ASC')->get();
      $kry = Karyawan::where('id',$id)->first();
      if(empty($kry))
      {
        return abort(404);
      }
      return view('penggajian.edit')->with(['jabatan' => $jabatan,'data' => $kry]);
    }

    public function save(KaryawanCreateRequest $request)
    {
       Karyawan::create($this->params($request));
       return redirect()->route('karyawan')->with(['message_success' => "Berhasil menambahkan karyawan"]);
    }

    public function update(KaryawanUpdateRequest $request)
    {
       Karyawan::where('id',$request->id)->update($this->params($request,true));
       $msg = "Berhasil Mengubah data karyawan";
       if($request->resign_date != null)
       {
         User::where('id',$request->id)->update(['is_disabled' => true]);
         $msg .= " dan akun karyawan telah dinonaktifkan.";
       }
       return redirect()->route('karyawan')->with(['message_success' => $msg]);
    }

  public function getKaryawanSelect(Request $request)
    {
        $data = KaryawanSelect::collection(Karyawan::where('nama_lengkap','like','%'.$request->search.'%')->whereNull('resign_date')->orderBy('nama_lengkap','ASC')->limit(10)->get());

        return response()->json($data);
    }

    public function getDataPenggajian(Request $request)
    {

       if(!empty($request->tipe))
       {
         $data = Karyawan::where('tipe_karyawan',$request->tipe)->get();
       } elseif(!empty($request->jabatan)){
          $jabatan = Jabatan::where('nama',$request->jabatan)->first();
          $data = Karyawan::where('jabatan_id',$jabatan->id)->get();
       } else{
         $data = Karyawan::orderBy('created_at','DESC')->get();
       }
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('tempat_tanggal_lahir', function ($data) {
               return $data->tempat_lahir.', '.$data->tanggal_lahir;
            })
            ->addColumn('jabatan', function ($data) {
               return empty($data->jabatan)?"-":$data->jabatan->nama;
            })
            ->addColumn('kelengkapan', function ($data) {
               return view('penggajian.partials.kelengkapan')->with(['data' => $data])->render();
            })
            ->addColumn('status_aktif', function ($data) {
               return (!empty($data->resign_date) ? "<span class='badge badge-danger'>Non-Aktif</span>":"<span class='badge badge-success'>Aktif</span>");
            })
            ->editColumn('join_date', function ($data) {
               return $data->join_date."<br><small>".\Carbon\Carbon::parse($data->join_date.' 00:00:00')->diffForHumans(['long' => false, 'parts' => 2])."<br> </small> ";
            })
            ->addColumn('tipe', function ($data) {
               return empty($data->tipe_karyawan)?"-":$data->tipe_karyawan;
            })
            ->addColumn('aksi', function ($data) {
               return view('penggajian.partials.aksi')->with(['data' => $data])->render();
            })
            ->editColumn('foto', function ($data) {
               return view('penggajian.partials.foto')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','foto','kelengkapan','join_date','status_aktif'])
            ->make(true);
    }
    public function downloadCV($cv)
    {
      $filename = $cv;
      $path = storage_path('app/cv/'.$cv);
      if(!file_exists($path)){
        return abort(404);
      }
      return \Response::make(file_get_contents($path), 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="'.$filename.'"'
      ]);
    }
    private function params($request,$updated = false)
    {
      if(!empty($request->file('img')))
      {
        $img = $this->imageProcessing($request->file('img'));
      } else{
        $img = 'default.jpg';
      }
      if(!empty($request->file('cv')))
      {
        $cv = $this->CVProcessing($request->file('cv'),$request->nama_lengkap);
      } else{
        $cv = null;
      }
      if($updated)
      {
        $params = [
                'nip'           => $request->nip,
                'nama_lengkap'  => $request->nama_lengkap,
                'no_ktp'  => $request->no_ktp,
                'no_npwp'  => $request->no_npwp,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_telp'       => $request->no_telp,
                'tipe_karyawan' => $request->tipe_karyawan,
                'github_link'   => $request->github_link,
                'bitbucket_link'=> $request->bitbucket_link,
                'gitlab_link'   => $request->gitlab_link,
                'join_date'     => $request->join_date,
                'resign_date'   => $request->resign_date,
                'jabatan_id'    => $request->jabatan,
                'updated_by'    => auth()->user()->id,
        ];
        if(!empty($request->file('img')))
        {
          $params['foto'] = $img;
        }
        if(!empty($request->file('cv')))
        {

          $params['cv'] = $cv;
        }
      } else{
        $params = [
                  'nip'           => $request->nip,
                  'nama_lengkap'  => $request->nama_lengkap,
                  'no_ktp'  => $request->no_ktp,
                  'no_npwp'  => $request->no_npwp,
                  'tempat_lahir'  => $request->tempat_lahir,
                  'tanggal_lahir' => $request->tanggal_lahir,
                  'no_telp'       => $request->no_telp,
                  'tipe_karyawan' => $request->tipe_karyawan,
                  'jabatan_id'    => $request->jabatan,
                  'github_link'   => $request->github_link,
                  'bitbucket_link'=> $request->bitbucket_link,
                  'gitlab_link'   => $request->gitlab_link,
                  'join_date'     => $request->join_date,
                  'resign_date'   => $request->resign_date,
                  'foto'          => $img,
                  'cv'          => $cv,
                  'updated_by'    => auth()->user()->id,
        ];

      }
        return $params;
    }

    private function imageProcessing($file)
    {
         $uuid = Uuid::uuid4();
         $file = $file;
         $ext =  $file->getClientOriginalExtension();
         $rand = Str::random(8);
         $imgname = 'profile-'.date('Ymd')."_".$uuid->toString().'.'.$ext;

         $dest_path = storage_path('app/karyawan/');
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
    private function CVProcessing($file,$name)
    {

         $file = $file;
         $ext =  $file->getClientOriginalExtension();
         $rand = Str::random(10);
         $cvname = 'CV-'.date("Y-m-d")."_".strtr($name,' ','-')."_".md5($rand).".".$ext;

         $dest_path = storage_path('app/cv');
          if(!is_dir($dest_path)){
             mkdir($dest_path,770);
          }
          $file->move($dest_path, $cvname);
          return $cvname;
    }
}
