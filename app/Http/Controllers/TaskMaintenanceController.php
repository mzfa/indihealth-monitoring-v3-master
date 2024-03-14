<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskMaintenance;
use App\Models\TicketingMaintenance;
use App\Helpers\JSon;
use TaskHelper;
use App\Http\Resources\TaskMTShow;

class TaskMaintenanceController extends Controller
{
    public function index()
    {
    	return view('task_maintenance.index');
    }

    public function mtRequestNotif(Request $request)
    {
        $data = [];
        $tsk = TicketingMaintenance::where('target_ticketing',auth()->user()->target_ticketing_division_id)->where('target_user',auth()->user()->id)->where('is_read_toast',false)->get();
        foreach($tsk as $tsk)
        {
           
              $data[] = ['title' => "Pemberitahuan Ticketing Maintenance", 'body' => "Request Maintenance baru telah masuk dari projek ".$tsk->project->name."(".$tsk->project->client.") dengan no tiket".$tsk->no_ticket];
          
        }
        TicketingMaintenance::where('target_ticketing',auth()->user()->target_ticketing_division_id)->update(['is_read_toast'=> true]);

        return JSon::response(200,'taskMT',$data,[]);

    }

    public function update(Request $request)
    {
        if(!TaskHelper::checkMember(auth()->user()->id, $request->id) AND \Permission::for(['employee'])){
           $data['member']="Tidak dapat melakukan aksi ini, karena anda bukan anggota team maintenance ini";
           return JSon::validateError(422,'errors',$data);
        }
        $validate = [
                            'id' => "required||exists:\App\Models\TaskMaintenance,id",
                            'task_name' => "required",
                            'project_id' => "required|exists:\App\Models\Project,id",
                            'task_maintenance_level_id' => "required|exists:\App\Models\TaskMaintenanceLevel,id",
                            'ticketing_id' => "required|exists:\App\Models\TicketingMaintenance,id",
                            'start_date' => "required|date",
                            'start_time' => "required|date_format:H:i",
                            'process' => "required|numeric|max:100|min:0",
                            'kesulitan' => "nullable|string",
                            'time' => "integer|required|exists:\App\Models\TaskMaintenanceLevel,minutes",
                            'solusi' => "nullable|string",
                            'selesai' => "nullable",
                    ];

        $this->validate($request, $validate);
        $data['data'] = TaskMaintenance::where('id',$request->id)->update($this->params($request));
        $data['messages'] = "Sukses menampilkan Guest";


       return JSon::response(200,'level',$data,[]);
    }
    public function show(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenance,id",
                        ];
        $this->validate($request, $validate);
        $data['data'] = new TaskMTShow(TaskMaintenance::where('id', $request->id)->first());
        $data['messages'] = "Sukses menampilkan Task";


       return JSon::response(200,'taskMT',$data,[]);
    }

    public function delete(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenance,id",
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenance::where('id', $request->id)->delete();
        $data['messages'] = "Sukses menampilkan Task";


       return JSon::response(200,'taskMT',$data,[]);
    }

    public function save(Request $request)
    {
        if(\Permission::for(['employee'])){
           $data['member']="Anda tidak dapat melakukan tindakan ini.";
           return JSon::validateError(422,'errors',$data);
        }
        $validate = [
                            'task_name' => "required",
                            'project_id' => "required|exists:\App\Models\Project,id",
                            'task_maintenance_level_id' => "required|exists:\App\Models\TaskMaintenanceLevel,id",
                            'ticketing_id' => "required|exists:\App\Models\TicketingMaintenance,id",
                            'start_date' => "required|date",
                            'start_time' => "required|date_format:H:i",
                            'process' => "required|numeric|max:100|min:0",
                            'kesulitan' => "nullable|string",
                            'time' => "integer|required|exists:\App\Models\TaskMaintenanceLevel,minutes",
                            'solusi' => "nullable|string",
                            'selesai' => "nullable",
                    ];

        $this->validate($request, $validate);
        $data['data'] = TaskMaintenance::create($this->params($request));
        $data['messages'] = "Sukses menyimpan Data";


       return JSon::response(200,'taskMT',$data,[]);
    }

    public function params($request)
    {
        if(\Permission::for(['superadmin']))
        {
          $dtStart = $request->start_date." ".$request->start_time;
          $end = TaskHelper::calculateTime($dtStart,$request->time);
          $params = ['task_maintenance_level_id' => $request->task_maintenance_level_id,
                      'ticketing_id' => $request->ticketing_id,
                      'task_name' => $request->task_name,
                      'process' => $request->process,
                      'project_id' => $request->project_id,
                      'kesulitan' => $request->kesulitan,
                      'solusi' => $request->solusi,
                      'tanggal' => $request->start_date,
                      'is_done' => !empty($request->selesai)?true:false,
                      'updated_by' => auth()->user()->id,
                      'created_by' => auth()->user()->id,
                      'timing' => $request->time,
                      'start' => $dtStart,
                      'end' => $end,
                  ];
        } else{
          $params = [
                      'process' => $request->process,
                      'kesulitan' => $request->kesulitan,
                      'solusi' => $request->solusi,

                      'is_done' => !empty($request->selesai)?true:false,
                      'updated_by' => auth()->user()->id,
                  ];
        }


        return $params;
    }

    public function calcEnd(Request $request)
    {
        $validate = [
                        'start_date' => "required|date",
                        'start_time' => "required|date_format:H:i",
                        'timing' => "required|integer",
                    ];

        $this->validate($request, $validate);
        $dtStart = $request->start_date." ".$request->start_time;
        $end = \TaskHelper::calculateTime($dtStart,$request->timing);

        $data['end_datetime'] = $end;
        $data['date'] = date('Y-m-d',strtotime($end));
        $data['time'] = date('H:i',strtotime($end));;

        return JSon::response(200,'taskMT',$data,[]);
    }

    public function getDataTask(Request $request)
    {
      // \DB::enableQueryLog(); // Enable query log
        if(!empty($request->end_date) || !empty($request->start_date || !empty($request->process)))
        {
            $tsk = TaskMaintenance::where('process','>=',empty($request->progress)?0:$request->progress);
            if(!empty($request->end_date) || !empty($request->start_date))
            {
              $tsk->whereBetween('tanggal',[$request->start_date,$request->end_date]);

            }


            $data = $tsk->orderBy('created_at','DESC')->get();
            // dd(\DB::getQueryLog());
        } else{

            $data = TaskMaintenance::orderBy('created_at','DESC')->get();
        }
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('status', function ($data) {
                return $data->is_done ? "<span class='badge badge-success'>Done</span>":"<span class='badge badge-secondary'>Progress</span>";
            })
            ->addColumn('jabatan', function ($data) {
               return empty($data->jabatan)?"-":$data->jabatan->nama;
            })
            ->addColumn('tanggal', function ($data) {
               return empty($data->ticketing)?"-":date('Y-m-d H:i:s',strtotime($data->ticketing->created_at));
            })
            ->addColumn('ticket', function ($data) {
              return view('task_maintenance.partials.ticket')->with(['data' => $data])->render();
            })
            ->addColumn('member', function($data){
            	return view('task_maintenance.partials.member')->with(['data' => $data])->render();
            })

            ->addColumn('timing', function ($data) {
               return view('task_maintenance.partials.timing')->with(['data' => $data])->render();
            })
            ->addColumn('aksi', function ($data) {
               return view('task_maintenance.partials.aksi')->with(['data' => $data])->render();
            })
            ->editColumn('progress_task', function ($data) {
               return view('task_maintenance.partials.progress')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','ticket','status','progress_task','timing','member'])
            ->make(true);
    }
}
