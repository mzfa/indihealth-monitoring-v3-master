<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinSakit;
use App\Models\User;
use App\Models\Karyawan;
use Mail;
use App\Exports\CutiExport;
use App\Mail\CutiReqMail;
use App\Mail\CutiAccMail;
use App\Mail\CutiDisAccMail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DateTime;

class IzinSakitController extends Controller
{
    //
    public function index()
    {
        return view('izin/index');
    } 

    public function izin_all()
    {
        return view('izin/dataindex');
    } 
    public function request()
    {
        return view('izin/request');
    }  
    public function create()
    {
        return view('izin/create');
    }  

    public function edit($id)
    {
        $izin = IzinSakit::where('id',$id)->firstOrFail();
        return view('izin/edit')->with(['data' => $izin]);
    }  

    public function editSelf($id)
    {
        $izin = IzinSakit::where('id',$id)->firstOrFail();
        return view('izin/request_edit')->with(['izin' => $izin]);
    } 
    public function submit_request(Request $request)
    {
         $validate = [
                            'jenis' => ['required',"in:S,I,PC,PC"],
                            'start' => ['required','lte:end','date'],
                            'end' => ['required','gte:start','date'],
                            'file' => ['nullable','max:10100','mimes:jpg,jpeg,docx,doc,pdf'],
                            'keterangan' => ['required'],

                      ];
        $this->validate($request, $validate);

        IzinSakit::create($this->paramsReq($request));

        return redirect()->route("izin")->with(['message_success' => "Berhasil mengajukan izin"]);
    }
    public function save(Request $request)
    {
         $validate = [
                            'karyawan_id' => ['required',"exists:\App\Models\Karyawan,id"],
                            'jenis' => ['required',"in:S,I,PC,PC"],
                            'start' => ['required','lte:end','date'],
                            'end' => ['required','gte:start','date'],
                            'file' => ['nullable','max:10100','mimes:jpg,jpeg,docx,doc,pdf'],
                            'keterangan' => ['required'],
                            'status' => ['required','in:1,0'],

                      ];
        $this->validate($request, $validate);

        IzinSakit::create($this->paramsInput($request));

        return redirect()->route("izin.data")->with(['message_success' => "Berhasil menginputkan izin"]);
    }
    public function update_req(Request $request)
    {
         $validate = [
                            'id' => ['required',"exists:\App\Models\IzinSakit"],
                            'jenis' => ['required',"in:S,I,PC"],
                            'start' => ['required','lte:end','date'],
                            'end' => ['required','gte:start','date'],
                            'file' => ['nullable','max:10100','mimes:jpg,jpeg,docx,doc,pdf'],
                            'keterangan' => ['required'],

                      ];
        $this->validate($request, $validate);

        IzinSakit::where('id',$request->id)->update($this->paramsReq($request));

        return redirect()->route("izin")->with(['message_success' => "Berhasil mengubah izin"]);
    }

    public function update(Request $request)
    {
         $validate = [
                            
                            'id' => ['required',"exists:\App\Models\IzinSakit"],
                            'jenis' => ['required',"in:S,I,PC"],
                            'start' => ['required','lte:end','date'],
                            'end' => ['required','gte:start','date'],
                            'file' => ['nullable','max:10100','mimes:jpg,jpeg,docx,doc,pdf'],
                            'keterangan' => ['required'],

                      ];
        $this->validate($request, $validate);

        IzinSakit::where('id',$request->id)->update($this->paramsInput($request));

        return redirect()->route("izin.data")->with(['message_success' => "Berhasil mengubah izin"]);
    }
    public function download($file)
    {
        
        $path = storage_path('app/ket-izin-sakit/'.$file);
        // dd($path);
        if(is_file($path))
        {
            return response()->download($path, $file);
        }

        return abort(404);
    }
    public function cancel_req(Request $request)
    {
         $validate = [
                            'id' => ['required',"exists:\App\Models\IzinSakit"],

                      ];
        $this->validate($request, $validate);

        IzinSakit::where('id',$request->id)->delete();

        return redirect()->route("izin")->with(['message_success' => "Berhasil membatalkan pengajuan izin"]);
    }

    public function approve(Request $request)
    {
         $validate = [
                            'id' => ['required',"exists:\App\Models\IzinSakit"],

                      ];
        $this->validate($request, $validate);

        IzinSakit::where('id',$request->id)->update(['status'=>1,'approved_by'=>auth()->user()->id]);

        return redirect()->back()->with(['message_success' => "Berhasil menyetujui pengajuan izin"]);
    }
    private function paramsReq($request)
    {
        $params = ['karyawan_id' => auth()->user()->karyawan_id,
                    'jenis'=> $request->jenis,
                    'start' => $request->start,
                    'end' => $request->end,
                    'keterangan'=> $request->keterangan,
                    'created_by'=>auth()->user()->id
                ];
        if(!empty($request->file))
        {
            $path = 'ket-izin-sakit';
            if(!file_exists(storage_path($path))){
                mkdir(storage_path($path),770);
            }
            $name = 'IDH_RQ_'.$this->getWeek($request->start).'_'.strtoupper($request->jenis)."_".strtr(auth()->user()->karyawan->nip,'/','-').'_'.time();
            $guessExtension = $request->file('file')->guessExtension();
            $getmime = explode('/', $request->file->getMimeType())[0];
            $file = $request->file('file')->storeAs($path, $name.'.'.$guessExtension);
            $params['file'] = $name.'.'.$guessExtension;
            $params['mime'] = $getmime;
        }

        return $params;
    }
    private function paramsInput($request)
    {
        $params = [
                    'jenis'=> $request->jenis,
                    'start' => $request->start,
                    'end' => $request->end,
                    'keterangan'=> $request->keterangan,
                    'created_by'=>auth()->user()->id,
                    'status'=>$request->status
                ];
        if(!empty($request->karyawan_id))
        {
            $params['karyawan_id'] =$request->karyawan_id;
        }
        
        if(!empty($request->file))
        {
            $path = 'ket-izin-sakit';
            if(!file_exists(storage_path($path))){
                mkdir(storage_path($path),770);
            }
            $name = 'IDH_CR_'.$this->getWeek($request->start).'_'.strtoupper($request->jenis)."_".strtr(auth()->user()->karyawan->nip,'/','-').'_'.time();
            $guessExtension = $request->file('file')->guessExtension();
            $getmime = explode('/', $request->file->getMimeType())[0];
            $file = $request->file('file')->storeAs($path, $name.'.'.$guessExtension);
            $params['file'] = $name.'.'.$guessExtension;
            $params['mime'] = $getmime;
        }

        return $params;
    }

    private function getWeek($date)
    {
        $ddate = $date;
        $date = new DateTime($ddate);
        $week = $date->format("W");
       return $week.date('y');
    }
    public function getIzinSelf(Request $request)
    {
       $data = IzinSakit::where('karyawan_id',auth()->user()->karyawan_id)->get();
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->editColumn('jenis', function ($data) {
                if(strtoupper($data->jenis) == "S")
                {
                    $sts = "Sakit";
                } elseif(strtoupper($data->jenis) == "I")
                {
                    $sts = "Izin";
                }elseif(strtoupper($data->jenis) == "PC")
                {
                    $sts = "Izin Pulang Cepet";
                }
               return $sts;
            }) 

            ->editColumn('status', function ($data) {
                if($data->status == null)
                {
                    $sts = "<span class='badge badge-secondary'> Menunggu </span>";
                } elseif($data->status == 0)
                {
                    $sts = "<span class='badge badge-danger'> Ditolak </span>";
                } elseif($data->status == 1) {
                    $sts = "<span class='badge badge-success'> Disetujui </span>";
                } else{
                    $sts = "<span class='badge badge-light'> Unknown </span>";
                }
               return $sts;
            })
            ->addColumn('aksi', function ($data) {
               return view('izin.partials.aksi_self')->with(['data' => $data])->render();
            })->addColumn('img', function ($data) {
              return view('izin.partials.img')->with(['data' => $data])->render();
            })
             ->addColumn('aksi', function ($data) {
               return view('izin.partials.aksi_self')->with(['data' => $data])->render();
            })
            ->rawColumns(['jenis','aksi','status','img'])
            ->make(true);
    }
    public function getIzinAll(Request $request)
    {
       $data = IzinSakit::get();
       $sts = '';
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->editColumn('jenis', function ($data) {
                if(strtoupper($data->jenis) == "S")
                {
                    $sts = "Sakit";
                } elseif(strtoupper($data->jenis) == "I")
                {
                    $sts = "Izin";
                } elseif(strtoupper($data->jenis) == "PC")
                {
                    $sts = "Izin Pulang Cepet";
                }
               return $sts;
            }) 

            ->editColumn('status', function ($data) {
                if($data->status == null)
                {
                    $sts = "<span class='badge badge-secondary'> Menunggu </span>";
                } elseif($data->status == 0)
                {
                    $sts = "<span class='badge badge-danger'> Ditolak </span>";
                } elseif($data->status == 1) {
                    $sts = "<span class='badge badge-success'> Disetujui </span>";
                } else{
                    $sts = "<span class='badge badge-light'> Unknown </span>";
                }
               return $sts;
            })
            ->addColumn('aksi', function ($data) {
                if(strtoupper($data->jenis) == "S")
                {
                    $sts = "Sakit";
                } elseif(strtoupper($data->jenis) == "I")
                {
                    $sts = "Izin";
                } elseif(strtoupper($data->jenis) == "PC")
                {
                    $sts = "Izin Pulang Cepet";
                }
               return $sts;
            })
            ->addColumn('nama_lengkap', function ($data) {
               return !empty($data->karyawan)? $data->karyawan->nama_lengkap:"-";
            }) 
            ->addColumn('nip', function ($data) {
               return !empty($data->karyawan)? $data->karyawan->nip:"-";
            })
             ->addColumn('aksi', function ($data) {
               return view('izin.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['jenis','aksi','status'])
            ->make(true);
    }
}
