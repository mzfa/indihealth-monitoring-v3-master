<?php

namespace App\Http\Controllers;

use App\DataTables\CutiDataTable;
use Illuminate\Http\Request;
use App\Models\Cuti;
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

class CutiController extends Controller
{
    //
    public function index(CutiDataTable $dataTable)
    {
        return $dataTable->render('cuti.index');
    }

    public function create()
    {
        return view("cuti.create");
    } 

    public function edit($id)
    {
        $cuti = Cuti::where('id', $id)->first();
        return view("cuti.edit")->with(['data' => $cuti]);
    } 

    public function delete(Request $request)
    {
         $validate = [
                            'cuti_id' => "required|exists:\App\Models\Cuti,id",

                      ];
        $this->validate($request, $validate);
        Cuti::where('id', $request->cuti_id)->delete();

         return redirect()->route("cuti")->with(['message_success' => "Berhasil menghapus cuti"]);
    } 

    public function update(Request $request)
    {
       $validate = [
                            'id' => "required|exists:\App\Models\Cuti,id",
                            'karyawan_id' => "required|exists:\App\Models\Karyawan,id",
                            'start_date' => ['required','gte:end_date','date'],
                            'end_date' => ['required','lte:start_date','date'],
                            'reason_cuti' => ['required'],

                      ];
        $this->validate($request, $validate);
        $cek_cuti = Cuti::select(\DB::raw('SUM(jumlah) AS tot_cuti'))->where(['karyawan_id' =>  $request->karyawan_id,'status' => 1])->first();
        $count = $this->dateDiffInDays($request->start_date, $request->end_date) + 1;
        if(($cek_cuti->tot_cuti+$count) > 12)
        {
             return redirect()->back()->with(['message_fail' => "Tidak dapat memasukan cuti, karena jatah cuti sudah mencapai 12 hari"]);
        }
        $req= Cuti::where('id',$request->id)->update(['karyawan_id' =>  $request->karyawan_id,'start' => $request->start_date,'end' => $request->end_date,'reason_cuti' => $request->reason_cuti,'status' => 0,'jumlah' => $this->dateDiffInDays($request->start_date, $request->end_date) + 1,]);

        return redirect()->route("cuti")->with(['message_success' => "Berhasil mengubah data cuti"]);

    } 
    public function export(Request $request)
    {
        


        $fname = 'LAPORAN-CUTI-'.strtoupper(Config::get('app.copyright'))."-".$request->year.'.xlsx';
      
        $title = 'LAPORAN-CUTI-DOWNLOADED';
        $message['username'] = auth()->user()->name." (".auth()->user()->email.")";
        $message['messages'] = "Telah mengunduh laporan cuti tahun ".$request->year.' pada '.date('Y-m-d H:i:s').'.';
        $message['ip_address'] = $request->ip();
        $message['time'] = date('Y-m-d H:i:s');
        Log::notice($title.' '.json_encode($message));  
        return   \Excel::download(new CutiExport($request->year), $fname);
    }
      
    public function input()
    {
        return view("cuti.input");
    }
    public function save(Request $request)
    {
         $validate = [
                            'karyawan_id' => "required|exists:\App\Models\Karyawan,id",
                            'start_date' => ['required','gte:end_date','date'],
                            'end_date' => ['required','lte:start_date','date'],
                            'status' => ['required','in:1,2'],
                            'reason_cuti' => ['required'],

                      ];
        $this->validate($request, $validate);
        $cek_cuti = Cuti::select(\DB::raw('SUM(jumlah) AS tot_cuti'))->where(['karyawan_id' =>  $request->karyawan_id,'status' => 1])->first();
        $count = $this->dateDiffInDays($request->start_date, $request->end_date) + 1;
        if(($cek_cuti->tot_cuti+$count) > 12)
        {
             return redirect()->route("cuti")->with(['message_fail' => "Tidak dapat memasukan cuti, karena jatah cuti sudah mencapai 12 hari"]);
        }
        $req= Cuti::create(['karyawan_id' =>  $request->karyawan_id,'start' => $request->start_date,'end' => $request->end_date,'reason_cuti' => $request->reason_cuti,'jumlah' => $this->dateDiffInDays($request->start_date, $request->end_date) + 1,'status' => $request->status,'status_by' => auth()->user()->id,]);
     
       

        return redirect()->route("cuti")->with(['message_success' => "Berhasil menambahkan cuti"]);
    }

    public function store(Request $request)
    {
        $validate = [
                            'start_date' => ['required','gte:end_date','date'],
                            'end_date' => ['required','lte:start_date','date'],
                            // 'status' => ['required','in:1,2'],
                            'reason_cuti' => ['required'],

                      ];
        $this->validate($request, $validate);
        $cek_cuti = Cuti::select(\DB::raw('SUM(jumlah) AS tot_cuti'))->where(['karyawan_id' =>  auth()->user()->karyawan_id,'status' => 1])->first();
        $count = $this->dateDiffInDays($request->start_date, $request->end_date) + 1;
        if(($cek_cuti->tot_cuti+$count) > 12)
        {
             return redirect()->route("cuti")->with(['message_fail' => "Tidak dapat memasukan cuti, karena jatah cuti sudah mencapai 12 hari"]);
        }
        $req= Cuti::create(['karyawan_id' =>  auth()->user()->karyawan_id,'start' => $request->start_date,'end' => $request->end_date,'reason_cuti' => $request->reason_cuti,'jumlah' => $this->dateDiffInDays($request->start_date, $request->end_date) + 1,]);
        try{
             $this->sendMailHrd($req);
        }catch(\Exception $e){
            \Log::warning("Failed Sending mail Cuti to HRD"." ".json_encode($e));
        }
       

       return redirect()->route("cuti")->with(['message_success' => "Berhasil mengirim permintaan cuti"]);
    }

    public function approve($id)
    {
        $req = Cuti::find($id);

        $req->status = 1;
        $req->status_by = Auth::id();

        $req->update();
        try{
             $this->sendMailAproveEmployee($id);
        }catch(\Exception $e){
            \Log::warning("Failed Sending mail Approve Cuti to Employee"." ".json_encode($e));
        }

        return back();
    }

    public function disapprove(Request $request, $id)
    {
        $req = Cuti::find($id);
        
        $req->status = 2;
        $req->status_by = Auth::id();
        $req->reason_status = $request->reason_status;

        $req->update();
        try{
             $this->sendMailDisaproveEmployee($id);
        }catch(\Exception $e){
            \Log::warning("Failed Sending mail disapprove Cuti to Employee"." ".json_encode($e));
        }
        return back();
    }

    private function sendMailHrd($cuti)
    {
        $user = User::select('name','email')->whereHas('role', function($query){
             $query->whereIn('name',['hrd']);
         })->where('is_disabled',false)->get();
        $i = 0;
        foreach ($user as $u) {
          $i++;
          // dd($u);
            Mail::to($u->email)->send(new CutiReqMail($u,$cuti));
        }
    }

    private function sendMailAproveEmployee($id_cuti)
    {
        $cuti = Cuti::where('id', $id_cuti)->first();
        // dd($cuti);
        Mail::to($cuti->karyawan->user->email)->send(new CutiAccMail($cuti));
    } 
    private function sendMailDisaproveEmployee($id_cuti)
    {
        $cuti = Cuti::where('id', $id_cuti)->first();

        Mail::to($cuti->karyawan->user->email)->send(new CutiDisAccMail($cuti));
    }
    private function dateDiffInDays($date1, $date2) 
    {
        // https://www.geeksforgeeks.org/program-to-find-the-number-of-days-between-two-dates-in-php/

        // Calculating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);
    
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }
}
