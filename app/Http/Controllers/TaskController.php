<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskMember;
use App\Models\TaskReportLog;
use App\Models\ProjectPlanDetail;
use App\Models\Karyawan;
use App\Helpers\JSon;
use Carbon\Carbon;
use App\Rules\UniqueTask;


class TaskController extends Controller
{
    public function index($project_id)
    {
        $task = TaskMember::where('user_id',auth()->user()->id)->whereHas('task',function($query)use($project_id){
                $query->where('project_id',$project_id);
             })->update(['is_read_notif' => true]);
    	return view('task.index')->with(['project_id' => $project_id]);
    }
    public function checkPlan(Request $request)
    {
      $data['data'] = ProjectPlanDetail::select('start_date','end_date','description')->where('id', $request->id)->first();
       return JSon::response(200,'task',$data,[]);
    }
    public function getTaskKaryawan(Request $request)
    {
        $data = Karyawan::where('id', $request->id)->first();
        return view('task.indexSelectKaryawan')->with(['data'=>$data]);
    }
    public function save(Request $request)
    {
        if(empty(auth()->user()->karyawan_id))
        {
             $data['karyawan_id']="Anda tidak dapat membuat task, karena akun anda belum terkait dengan karyawan";
             return JSon::validateError(422,'errors',$data);
        }
        // dd($this->params($request));
        $validate = [
                            'tanggal' => "date|required",
                            'task_name' => ["required","string",new UniqueTask(null,$request->project_id,$request->tanggal)],
                            'process' => "min:0|max:100|numeric",
                            'project_id' => "required|exists:\App\Models\Project,id",
                    ];
        if($request->process >= 100)
        {
            $validate['solusi'] = "required";
            $validate['kesulitan'] = "required";
        }
        $this->validate($request, $validate);
        $data['data'] = Task::create($this->params($request));
        $data['messages'] = "Sukses menambahkan Tugas";


       return JSon::response(200,'task',$data,[]);
    }

    public function delete(Request $request)
    {
         $validate = [
                            'id' => "required|exists:\App\Models\Task,id",
                    ];
            $this->validate($request, $validate);
        $data['data'] = Task::where('id',$request->id)->delete();
        $data['messages'] = "Sukses menghapus Tugas";


       return JSon::response(200,'task',$data,[]);

    }

    public function update(Request $request)
    {
         $validate = [
                             'id' => "required|exists:\App\Models\Task,id",
                            // 'tanggal' => "date|required",
                            //  'task_name' => ["required","string",new UniqueTask($request->id,$request->project_id,$request->tanggal)],
                            'process' => "min:0|max:100|numeric",

                            // 'project_id' => "required|exists:\App\Models\Project,id",
                            ];

            $validate['solusi'] = "required";
            $validate['kesulitan'] = "required";
            $validate['detail'] = "required|min:10";
        $this->validate($request, $validate);

        if(Task::where('id',$request->id)->where('is_done',true)->count() == 1)
        {
             $data['task']="Tidak dapat melapor, karena tugas ini sudah ditandai selesai, silahkan hubungi PM anda.";
             return JSon::validateError(422,'errors',$data);
        }
        $taskCheck = TaskReportLog::where(['user_id' => auth()->user()->id,'report_date' => $request->report_date,'process' => $request->process,'task_id' => $request->id])->count();
        if(empty($taskCheck))
        {
          TaskReportLog::create($this->paramsLog($request));
        }

        $data['data'] = Task::where('id',$request->id)->update($this->params($request));
        $data['messages'] = "Sukses mengubah Tugas";


       return JSon::response(200,'task',$data,[]);

    }
    public function unlockTask(Request $request)
    {
         $validate = [
                             'id' => "required|exists:\App\Models\Task,id",
                            ];

        $this->validate($request, $validate);
        $data['data'] = Task::where('id',$request->id)->update(['is_done' => false]);
        $data['messages'] = "Sukses membuka Tugas";


       return JSon::response(200,'task',$data,[]);

    }

    public function show(Request $request)
    {
         $validate = [
                            'id' => "required|exists:\App\Models\Task,id",
                    ];
            $this->validate($request, $validate);
        $taskMember = TaskMember::select(\DB::raw("IF(keterangan='<self-signed>','Ditambahkan oleh sendiri',keterangan) as keterangan"))->where('task_id',$request->id)->where('user_id',auth()->user()->id);
        $data['data'] = Task::where('id',$request->id)->first();
        $data['data_member'] = $taskMember->first();
        $data['messages'] = "Sukses menampilkan Tugas";
        $taskMember->update(['is_read' => true]);


       return JSon::response(200,'task',$data,[]);
    }

    public function getDataTask(Request $request)
    {

        if(!empty($request->end_date) || !empty($request->start_date || !empty($request->process)))
        {
            $tsk = Task::whereHas('members',function($query){
              $query->where('karyawan_id',auth()->user()->karyawan_id);
            })->where('project_id',$request->project_id);
            if(!empty($request->end_date) || !empty($request->start_date))
            {
                $tsk->whereBetween('tanggal',[$request->start_date,$request->end_date]);
            }
            $tsk->where('process','>=',empty($request->progress)?0:$request->progress);
            $data = $tsk->orderBy('created_at','DESC')->get();
        } else{
                Carbon::setWeekStartsAt(Carbon::MONDAY);
                Carbon::setWeekEndsAt(Carbon::SUNDAY);
            $data = Task::whereHas('members',function($query){
              $query->where('user_id',auth()->user()->id);
            })->where('project_id',$request->project_id)->orderBy('created_at','DESC')->get();
            // })->where('project_id',$request->project_id)->whereBetween('tanggal',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('created_at','DESC')->get();
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
            ->addColumn('project_name', function ($data) {
               return empty($data->project)?"-":$data->project->name;
            })
            ->addColumn('aksi', function ($data) {
               return view('task.partials.aksi')->with(['data' => $data])->render();
            })
            ->editColumn('tanggal', function ($data) {
               return "<span class=\"badge badge-info\">".$data->tanggal."</span> - <span class=\"badge badge-warning\">".$data->deadline."</span>";
            })
            ->editColumn('progress_task', function ($data) {
               return view('task.partials.progress')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','status','tanggal','progress_task'])
            ->make(true);
    }
    public function getDataTaskByKaryawan($id,Request $request)
    {

        if(!empty($request->end_date) || !empty($request->start_date || !empty($request->process)))
        {
            $tsk = Task::where('karyawan_id',$id);
            if(!empty($request->end_date) || !empty($request->start_date))
            {
                $tsk->whereBetween('tanggal',[$request->start_date,$request->end_date]);
            }
            $tsk->where('process','>=',empty($request->progress)?0:$request->progress);
            $data = $tsk->orderBy('created_at','DESC')->get();
        } else{
                Carbon::setWeekStartsAt(Carbon::MONDAY);
                Carbon::setWeekEndsAt(Carbon::SUNDAY);
            $data = Task::where('karyawan_id',$id)->whereBetween('tanggal',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('created_at','DESC')->get();
        }
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('status', function ($data) {
                return $data->is_done ? "<span class='badge badge-success'>Done</span>":"<span class='badge badge-secondary'>Progress</span>";
            })
            ->addColumn('project_name', function ($data) {
               return empty($data->project)?"-":$data->project->name;
            })
             ->addColumn('aksi', function ($data) {
               return view('task.partials.unlock')->with(['data' => $data])->render();
            })
            ->editColumn('progress_task', function ($data) {
               return view('task.partials.progress')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','status','progress_task'])
            ->make(true);
    }

    private function params($request)
    {
        $params = [
                    // 'tanggal' => $request->tanggal,
                    // 'task_name' => $request->task_name,
                    // 'karyawan_id' => auth()->user()->karyawan_id,
                    // 'kesulitan' => $request->kesulitan,
                    // 'project_id' => $request->project_id,
                    // 'solusi' => $request->solusi,
                    'process' => intval($request->process),
                    // 'is_done' => $request->selesai=="on"?true:false,
                    // 'updated_by' => auth()->user()->id,
        ];

        return $params;
    }

    private function paramsLog($request)
    {
    $search  = ['<script>', '</script>', '<style>', '</style>','<meta','<link','<title>','</title>'];
    $replace = [' ', ' ', ' ', ' ',' ','','',''];
    $detail =  str_ireplace($search, $replace, $request->detail);


        $params = [
                    'user_id' => auth()->user()->id,
                    'task_id' => $request->id,
                    'process' => intval($request->process),
                    'detail_report' => $detail,
                    'kesulitan' => $request->kesulitan,
                    'solusi' => $request->solusi,
                    'report_date' => $request->report_date,
                    'updated_by' =>  auth()->user()->id,
        ];

        return $params;
    }


}
