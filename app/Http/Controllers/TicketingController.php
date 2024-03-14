<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketingMaintenance;
use App\Http\Resources\TicketingSelect;
use App\Http\Resources\TicketingShow;
use App\Helpers\JSon;

class TicketingController extends Controller
{
    public function getSelect(Request $request)
    {
    	  $data = TicketingSelect::collection(TicketingMaintenance::where('project_id', $request->project_id)->whereIn('status',['UNDER-INVESTIGATION','FIXING'])->where('no_ticket','like','%'.$request->search.'%')->orderBy('no_ticket','ASC')->limit(10)->get());

        return response()->json($data);
    }
    public function show(Request $request)
    {
         $validate = [
                            'id' => "required|exists:\App\Models\TicketingMaintenance,id",
                    ];
        $this->validate($request, $validate);
        $data['data'] = new TicketingShow(TicketingMaintenance::where('id',$request->id)->first());
        $data['messages'] = "Sukses menampilkan Ticket";
                    

       return JSon::response(200,'MTTicket',$data,[]);
    }
    public function update(Request $request)
    {
         $validate = [
                            'id' => "required|exists:\App\Models\TicketingMaintenance,id",
                            'status' => "required|in:UNDER-INVESTIGATION,DONE,FIXING"
                    ];
        $this->validate($request, $validate);
        TicketingMaintenance::where('id',$request->id)->update(['status' => $request->status]);
        $data['messages'] = "Sukses mengubah status Ticket";


       return JSon::response(200,'MTTicket',$data,[]);
    }

    public function index()
    {
    	return view('ticketing_mt.index_internal');
    }

     public function getDatatables(Request $request)
    {

        $data = TicketingMaintenance::get();
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return date('Y-m-d H:i:s',strtotime($data->created_at));
            })
            ->editColumn("target_user", function ($data) {
                return empty($data->user_target)?"-":$data->user_target->karyawan->name;
            })

            ->addColumn('aksi', function ($data) {
               return view('ticketing_mt.partials.aksi')->with(['data' => $data])->render();
            })

            ->editColumn('status',function($data){
               return view('ticketing_mt.partials.status')->with(['data' => $data])->render();
            })
            ->addColumn('no_telp', function ($data) {
               return empty($data->guest)?"-":"<a href=tel:".$data->guest->no_telp.">".$data->guest->no_telp."</a>";
            })
            ->addColumn('project', function ($data) {
               return empty($data->project)?"-":$data->project->name;
            })
            ->addColumn('yg_mengajukan', function ($data) {
               return empty($data->project)?"-":$data->project->client."<br> <b>".$data->guest->name."</b>";
            })

            ->rawColumns(['aksi','timing','progress','status','yg_mengajukan'])
            ->make(true);
    }
}
