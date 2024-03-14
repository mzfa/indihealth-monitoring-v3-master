<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notulensi;
use App\Models\Project;
use App\Helpers\JSon;
use Carbon\Carbon;
use PDF;

class NotulensiController extends Controller
{
    public function index(Request $request)
    {
        if(empty($request->id))
        {
            return abort(404);
        }
    	$notulensi = Notulensi::where('project_id',$request->id);
        if(!empty($request->search))
        {
           $notulensi->where('judul_agenda','like','%'.$request->search.'%');
        }
        if(!empty($request->tahun))
        {
           $notulensi->where('waktu_meeting','like',$request->tahun.'-'.$request->bulan.'%');
        }
        if(!empty($request->date) AND empty($request->tahun))
        {
           $notulensi->where('waktu_meeting','like',$request->date.'%');
        }
        $notulensi =  $notulensi->orderBy('created_at','Desc')->paginate(4);
        $project = Project::where('id',$request->id)->first();
    	return view('notulensi.index')->with(['notes' => $notulensi,'id_projek' => $request->id,'project' => $project]);
    }  
    public function exportPDF(Request $request)
    {
        $date = \Calendar::indonesiaMonth($request->bulan,true)." ".$request->tahun;
        $data = Notulensi::where('project_id',$request->project_id)->where('waktu_meeting','like',$request->tahun.'-'.$request->bulan.'%')->get();
        if(count($data) == 0)
        {
            return redirect()->back()->with(['message_fail' => 'Tidak ada data notulensi yang ditemukan pada '.$date.'.']);
        }
        $pdf = PDF::loadView('pdf.notulensi', ['data'=>$data,'date' => $date]);
        return $pdf->download('LAPORAN NOTULENSI '.$date.'.pdf');
    }
    public function copy(Request $request){
        $data = Notulensi::where('id',$request->id)->first();
        // dd($data);
        return view('copy')->with(['data' => $data]);
    }
    public function save(Request $request)
    {
    	
 		$validate = [
                            'project_id' => "exists:\App\Models\Project,id|required",
                            'judul_agenda' => ["required"],
                            'roadmap' => "required",
                            'notulensi' => "required",
                            'jam' => "date_format:H:i|required",
                            'tanggal' => "date|required",
                    ];
		$this->validate($request, $validate);
		
	 	$data['data'] = Notulensi::create($this->params($request));
        $data['messages'] = "Berhasil menyimpan projek";


       return JSon::response(200,'task',$data,[]);
    } 

    public function show(Request $request)
    {
    	
        $validate = [
                            'id' => "exists:\App\Models\Notulensi,id|required",
                    ];
        $this->validate($request, $validate);
        $q = Notulensi::where('id',$request->id)->first();
        $data['data'] = $q;
        $tgl = date('Y-m-d',strtotime($q->waktu_meeting));
        $jam = date('H:i',strtotime($q->waktu_meeting));

        $date = Carbon::parse($q->waktu_meeting);
        $diff = $date->diffForHumans($date);
        $data['messages'] = "Berhasil menampilkan data";
        $data['diff_date'] = $diff;
        $data['date'] = $tgl;
        $data['time'] = $jam;
        $data['notulensi_format'] = nl2br($q->notulensi);
        $data['roadmap_format'] = nl2br($q->roadmap);


       return JSon::response(200,'notulensi',$data,[]);
    }  

    public function update(Request $request)
    {
        // dd($request->notulensi);
         $validate = [
                            'id' => "exists:\App\Models\Notulensi,id|required",
                            'project_id' => "exists:\App\Models\Project,id|required",
                            'judul_agenda' => ["required"],
                            'roadmap' => "required",
                            'notulensi' => "required",
                            'jam' => "date_format:H:i|required",
                            'tanggal' => "date|required",
                    ];
        $this->validate($request, $validate);
        if($this->checkOwner($request))
        {
            $data['data'] = Notulensi::where('id',$request->id)->update($this->params($request));
            $data['messages'] = "Berhasil menyimpan Notulensi";


           return JSon::response(200,'notulensi',$data,[]);
        } else{
            $data['pemilik']="Pemilik notulensi tidak sesuai, anda hanya dapat menghapus notulensi yang dibuat oleh anda sendiri";
             return JSon::validateError(422,'errors',$data);
        }
    } 

    public function delete(Request $request)
    {
    	$validate = [
                            'id' => "exists:\App\Models\Notulensi,id|required",
                    ];
                    
        $this->validate($request, $validate);
        if($this->checkOwner($request))
        {
            $data['data'] = Notulensi::where('id',$request->id)->delete();
            $data['messages'] = "Berhasil menyimpan Notulensi.";


            return JSon::response(200,'task',$data,[]);
        } else{
            $data['pemilik']="Pemilik notulensi tidak sesuai, anda hanya dapat menghapus notulensi yang dibuat oleh anda sendiri.";
             return JSon::validateError(422,'errors',$data);
        }
    }
    
   
    private function checkOwner($request)
    {
        $nt = Notulensi::where('id',$request->id);
        $cek = $nt->first();
        if($cek->created_by == auth()->user()->id){
            return true;
        }
        return false;
    }
    private function params($request)
    {
        $tgl = date('Y-m-d',strtotime($request->tanggal));
        $jam = date('H:i',strtotime($request->jam));


    	$params = [
    				'project_id' =>$request->project_id,
    				'judul_agenda' =>$request->judul_agenda,
    				'roadmap' =>$request->roadmap,
    				'notulensi' =>$request->notulensi,
    				'waktu_meeting' => $tgl." ".$jam,
                    'created_by' => auth()->user()->id,
				];

		return $params;
    }



}
