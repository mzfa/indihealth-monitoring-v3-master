<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskMember;
use App\Models\Karyawan;
use App\Helpers\JSon;
use Carbon\Carbon;
use App\Rules\UniqueTask;
use App\Rules\CheckDeadline;
use App\Rules\CheckTanggal;
use App\Models\ProjectPlan;
use App\Models\ProjectPlanDetail;
use App\Http\Resources\ProjectPlanDetailSelect;

class TaskAssignController extends Controller
{

    public function save(Request $request)
    {

        // dd($this->params($request));
        $validate = [

                            'task_name' => ["required","string",new UniqueTask(null,$request->project_id,$request->tanggal)],
                            'process' => "min:0|max:100|numeric",
                            'project_id' => "required|exists:\App\Models\Project,id",
                            'project_plan' => "required|exists:\App\Models\ProjectPlanDetail,id",
                            'tanggal' => ["date","required","before_or_equal:deadline",new CheckTanggal($request->project_plan)],
                            'deadline' => ["date","required","after_or_equal:tanggal",new CheckDeadline($request->project_plan)],
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

    public function taskPlanGetDate(Request $request)
    {
        $plan = ProjectPlanDetail::select('start_date','end_date')->where('id',$request->id)->first();

        return response()->json($plan);

    }
    public function taskRequest(Request $request)
    {

        // dd($this->params($request));
        $validate = [

                            'task_name' => ["required","string",new UniqueTask(null,$request->project_id,$request->tanggal)],
                            'project_id' => "required|exists:\App\Models\Project,id",
                            'project_plan' => "required|exists:\App\Models\ProjectPlanDetail,id",
                            'tanggal' => ["date","required","before_or_equal:deadline",new CheckTanggal($request->project_plan)],
                            'deadline' => ["date","required","after_or_equal:tanggal",new CheckDeadline($request->project_plan)],
                    ];
        $this->validate($request, $validate);
        $task = Task::create($this->params($request));
        $data['data'] = $task;
        TaskMember::create([
                            'user_id' => auth()->user()->id,
                            'task_id' => $task->id,
                            'keterangan' => "<self-signed>",
                            'updated_by' => auth()->user()->id,
                        ]);
        $data['messages'] = "Sukses menambahkan Tugas";


       return JSon::response(200,'task',$data,[]);
    }
    public function taskPlanCategory(Request $request)
    {
        // dd($request->search);
        $projectpl = new ProjectPlan();
        // $projectpl->search = $request->search;
        $res = $projectpl->where('project_id',$request->project_id)->whereHas('projectPlanDetail',function($query) use($request){
            $query->where('name','like','%'.$request->search.'%');
        })->get();
        $plan = ProjectPlanDetailSelect::collection($res);

        return response()->json($plan);
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
       $tsk = Task::where('id',$request->id)->firstOrFail();
         $validate = [
                             'id' => "required|exists:\App\Models\Task,id",
                             'tanggal' => ["date","required","before_or_equal:deadline",new CheckTanggal($tsk->task_plan_id)],
                             'deadline' => ["date","required","after_or_equal:tanggal",new CheckDeadline($tsk->task_plan_id)],
                             'task_name' => ["required","string",new UniqueTask($request->id,$tsk->project_id,$request->tanggal)],
                            // 'process' => "min:0|max:100|numeric",

                            // 'project_id' => "required|exists:\App\Models\Project,id",
                            ];

        $this->validate($request, $validate);
        if(Task::where('id',$request->id)->where('is_done',true)->count() == 1)
        {
             $data['task']="Anda tidak dapat mengubah data pada task yang sudah selesai.";
             return JSon::validateError(422,'errors',$data);
        }
        $data['data'] = Task::where('id',$request->id)->update($this->paramsUpdate($request));
        $data['messages'] = "Sukses mengubah Tugas";


       return JSon::response(200,'task',$data,[]);

    }

    private function params($request)
    {
        $params = [
                    'tanggal' => $request->tanggal,
                    'task_name' => $request->task_name,
                    'karyawan_id' => auth()->user()->karyawan_id,
                    'deadline' => $request->deadline,
                    'kesulitan' => $request->kesulitan,
                    'project_id' => $request->project_id,
                    'task_plan_id' => $request->project_plan,
                    'solusi' => $request->solusi,
                    'process' => intval($request->process),
                    'is_done' => $request->selesai=="on"?true:false,
                    'updated_by' => auth()->user()->id,
        ];

        return $params;
    }
    private function paramsUpdate($request)
    {
        $params = [
                    'tanggal' => $request->tanggal,
                    'task_name' => $request->task_name,
                    // 'karyawan_id' => auth()->user()->karyawan_id,
                    'deadline' => $request->deadline,
                    // 'kesulitan' => $request->kesulitan,
                    // 'project_id' => $request->project_id,
                    // 'task_plan_id' => $request->project_plan,
                    // 'solusi' => $request->solusi,
                    // 'process' => intval($request->process),
                    'is_done' => $request->selesai=="on"?true:false,
                    'updated_by' => auth()->user()->id,
        ];

        return $params;
    }
}
