<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectPlan;
use App\Models\ProjectPlanDetail;
use App\Models\Task;
use App\Models\TaskPlan;
use App\Models\TaskPlanDetail;
use App\Helpers\JSon;
use App\Http\Resources\ProjectSelect;
use App\Http\Resources\ProjectPlanSelect;
use App\Http\Resources\ProjectPlanShow;
use App\Http\Resources\UserSelectProject;
use App\Rules\UniqueProjectPlan;
use App\Models\User;

class ProjectMonitoring extends Controller
{
    public function index(Request $request)
    {
      if(!empty($request->search))
      {
        $linked = ProjectMember::where('user_id', auth()->user()->id)->whereHas('project', function($query)use($request){
          $query->where('name', 'like', '%'.$request->search.'%');
        });
      }else {
        $linked = ProjectMember::where('user_id', auth()->user()->id)->where('is_pm',true);
      }

      $linked = $linked->orderBy('created_at', 'desc')->paginate(8);

    	return view('project_monitoring.index')->with(['linked' => $linked]);
    }

    public function detail_plan($id)
    {
      $project = Project::where('id', $id)->firstOrFail();

      //detail task plan
      $data = [];
      $indexMain = 0;
      $taskPlan = TaskPlan::where('project_id', $id)->get();
      foreach ($taskPlan as $key => $value) {
        $taskPlanDetail = TaskPlanDetail::where('task_plan_id', $value->id)->get();
        if(count($taskPlanDetail) > 0){
          foreach ($taskPlanDetail as $index => $row) {
            $data[$indexMain] = array(
              'desc' => $row->name,
              'values' => array(0 => array(
                'from' => str_replace("-","/",$row->start_date),
                'to' => str_replace("-","/",$row->end_date),
                'label' => $row->desc,
                'customClass' => "ganttRed"
              ))
            );

            if($index == 0){
              $data[$indexMain]['name'] = $value->name;
            }

            $indexMain++;
          }
        }
      }

      
    $taskPlanJson = json_encode($data);
    	return view('project_monitoring.detail_plan')->with(['project' => $project, 'task_plan' => $taskPlanJson]);
    }

    public function getDataPlan(Request $request)
    {

       $data = ProjectPlan::where('project_id', $request->id)->get();
        return \DataTables::of($data)
            ->editColumn("ditambahkan_pada", function ($data) {
                return date('Y-m-d',strtotime($data->created_at));
            })
            ->editColumn("timeline", function ($data) {
                return  "<span class='badge badge-info'>".date('Y-m-d',strtotime($data->start_date))."</span> <b>s/d</b> <span class='badge badge-info'>".date('Y-m-d',strtotime($data->end_date))."</span>";
            })
            ->addColumn('aksi', function ($data) {
               return view('project.partials.aksi_plan')->with(['data' => $data])->render();
            })

            ->rawColumns(['aksi','timeline'])
            ->make(true);
    }
    public function getDataPlanDetail(Request $request)
    {

       $data = ProjectPlanDetail::where('task_plan_id', $request->id)->get();
        return \DataTables::of($data)
            ->editColumn("ditambahkan_pada", function ($data) {
                return date('Y-m-d',strtotime($data->created_at));
            })
            ->editColumn("timeline", function ($data) {
                return  "<span class='badge badge-info'>".date('Y-m-d',strtotime($data->start_date))."</span> <b>s/d</b> <span class='badge badge-info'>".date('Y-m-d',strtotime($data->end_date))."</span>";
            })
            ->addColumn('aksi', function ($data) {
               return view('project.partials.aksi_plan_detail')->with(['data' => $data])->render();
            })

            ->rawColumns(['aksi','timeline'])
            ->make(true);
    }

    public function getDataSelect(Request $request)
    {
        $project = ProjectPlan::where('name','like','%'.$request->search.'%')->where('project_id',$request->project_id)
        ->whereHas('projectPlanDetail',function($query){
          $query->whereHas('tasks',function($query){
            $query->whereHas('members', function($query){
              $query->where('user_id', auth()->user()->id);
            });
          });
        })
        ->orderBy('name','ASC')->limit(10)->get();
        $data = ProjectPlanSelect::collection($project);

        return response()->json($data);
    }

    public function show(Request $request)
    {
          $data['data'] = new ProjectPlanShow(ProjectPlan::where('id',$request->id)->first());
          // $data['messages'] = "Berhasil menambahkan project plan";


          return JSon::response(200,'project_plan',$data,[]);
    }

    public function showDetailPlan(Request $request)
    {
          $data['data'] = new ProjectPlanShow(ProjectPlanDetail::where('id',$request->id)->first());
          // $data['messages'] = "Berhasil menambahkan project plan";


          return JSon::response(200,'project_plan',$data,[]);
    }
    public function edit_plan(Request $request)
    {
      $validate = [
                          'id' => "required|exists:\App\Models\ProjectPlan,id|integer",
                          'start_date' => "required|date|lte:end_date",
                          'end_date' => "required|date|gte:start_date",
                          'project_id' => ["required","exists:\App\Models\Project,id"],
                          'name' => ["required","string","max:60"],
                  ];
      $this->validate($request, $validate);

      $params = [ 'name' => $request->name,
                  'project_id' => $request->project_id,
                  'start_date' => $request->start_date,
                  'end_date' => $request->end_date,
                  'updated_by' => auth()->user()->id
                ];
      $data['data'] = ProjectPlan::where('id',$request->id)->update($params);
      $data['messages'] = "Berhasil mengubah data project plan";


      return JSon::response(200,'project_plan',$data,[]);

    }
    public function edit_plan_detail(Request $request)
    {
      $validate = [
                          'id' => "required|exists:\App\Models\ProjectPlanDetail,id|integer",
                          'start_date' => "required|date|lte:end_date",
                          'end_date' => "required|date|gte:start_date",
                          'project_id' => ["required","exists:\App\Models\Project,id"],
                          'name' => ["required","string","max:60"],
                  ];
      $this->validate($request, $validate);

      $params = [ 'name' => $request->name,
                  // 'project_id' => $request->project_id,
                  'start_date' => $request->start_date,
                  'end_date' => $request->end_date,
                  'updated_by' => auth()->user()->id
                ];
      $data['data'] = ProjectPlanDetail::where('id',$request->id)->update($params);
      $data['messages'] = "Berhasil mengubah data project plan detail";


      return JSon::response(200,'project_plan',$data,[]);

    }
    public function delete_plan(Request $request)
    {
      $validate = [
                          'id' => "required|exists:\App\Models\ProjectPlan,id|integer",
                  ];
      $this->validate($request, $validate);
      $project = ProjectPlan::where('id',$request->id);
      $cek = $project->first();
      if(count($cek->tasks) > 0)
      {
        $data['project_manager']="Tidak dapat menghapus plan ini, karena ada tugas yang terkait.";
        return JSon::validateError(422,'errors',$data);
      }
      $project->delete();
      $data['messages'] = "Berhasil menghapus data project plan";


      return JSon::response(200,'project_plan',$data,[]);

    }
    public function selectUser(Request $request)
    {
      $user = ProjectMember::where('project_id', $request->project_id)->limit(10)->get();
      // dd($user);
        return response()->json(UserSelectProject::collection($user));
    }
    public function delete_plan_detail(Request $request)
    {
      $validate = [
                          'id' => "required|exists:\App\Models\ProjectPlanDetail,id|integer",
                  ];
      $this->validate($request, $validate);
      $project = ProjectPlanDetail::where('id',$request->id);
      $cek = $project->first();
      if(empty($cek))
      {
         $data['project_plan']="Tidak dapat menghapus, Projek plan detail tidak ditemukan.";
        return JSon::validateError(422,'errors',$data);
      }
      if(count($cek->tasks) > 0)
      {
        $data['project_plan']="Tidak dapat menghapus, Projek plan detail tidak ditemukan.";
        return JSon::validateError(422,'errors',$data);
      }
      $project->delete();
      $data['messages'] = "Berhasil menghapus data project plan";


      return JSon::response(200,'project_plan',$data,[]);

    }
    public function add_plan(Request $request)
    {

            $validate = [
                                'start_date' => "required|date|lte:end_date",
                                'end_date' => "required|date|gte:start_date",
                                'project_id' => ["required","exists:\App\Models\Project,id"],
                                'name' => ["required","string","max:60",new UniqueProjectPlan($request->project_id)],
                        ];
            $this->validate($request, $validate);

            $params = [ 'name' => $request->name,
                        'user_id' => auth()->user()->id,
                        'project_id' => $request->project_id,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'updated_by' => auth()->user()->id
                      ];

            $data['data'] = ProjectPlan::create($params);
            $data['messages'] = "Berhasil menambahkan project plan";


            return JSon::response(200,'project_plan',$data,[]);
    }
    public function add_plan_detail(Request $request)
    {

            $validate = [
                                'start_date' => "required|date|lte:end_date",
                                'end_date' => "required|date|gte:start_date",
                                'project_id' => ["required","exists:\App\Models\Project,id"],
                                'name' => ["required","string","max:60",new UniqueProjectPlan($request->project_id)],
                        ];
            $this->validate($request, $validate);

            $params = [ 'name' => $request->name,
                        // 'user_id' => auth()->user()->id,
                        // 'project_id' => $request->project_id,
                        'task_plan_id' => $request->project_plan_id,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'updated_by' => auth()->user()->id
                      ];

            $data['data'] = ProjectPlanDetail::create($params);
            $data['messages'] = "Berhasil menambahkan project plan";


            return JSon::response(200,'project_plan',$data,[]);
    }
    public function taskDev($id, $task_plan)
    {

      $project = Project::where(['id' => $id]);
      $plan_detail = ProjectPlanDetail::where(['id' => $task_plan])->first();
      return view('project_monitoring.task.index')->with(['id' => $id,'plan' => $plan_detail,'project' => $project->first()]);
    }

    public function detail_plan_view($id, $task_plan)
    {

      $project = ProjectPlan::where(['id' => $task_plan]);
      return view('project_monitoring.plan_detail_view')->with(['id' => $id,'project' => $project->first()]);
    }
    public function planShow(Request $request)
    {

      $project = ProjectPlan::where(['id' => $request->id])->first();
      if(empty($project))
      {
        $data['project_manager']="Project plan tidak ditemukan.";
        return JSon::validateError(422,'errors',$data);
      }
      $data['data'] = $project;
      return JSon::response(200,'project_plan',$data,[]);
    }

    public function getDataTaskDev($id,$task_plan,Request $request)
   {
     // dd(['a' => $id, 'b' => $task_plan])
       if(!empty($request->end_date) || !empty($request->start_date || !empty($request->process)))
       {
           $tsk = Task::where('project_id',$id)->where('task_plan_id',$task_plan) ;
           if(!empty($request->end_date) || !empty($request->start_date))
           {
               $tsk->whereBetween('tanggal',[$request->start_date,$request->end_date]);
           }
           $tsk->where('process','>=',empty($request->progress)?0:$request->progress);
           $data = $tsk->orderBy('created_at','DESC')->get();
       } else{
           $data = Task::where('project_id',$id)->where('task_plan_id',$task_plan) ->orderBy('created_at','DESC')->get();
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
              return $data->tanggal." s/d ".$data->deadline;
           })
           ->addColumn('aksi', function ($data) {
                return view('project_monitoring.task.partials.aksi')->with(['data' => $data])->render();
           })
           ->addColumn('member', function ($data) {
              return empty($data->members)?"0 orang":count($data->members)." orang";
           })
           ->editColumn('progress_task', function ($data) {
              return view('task.partials.progress')->with(['data' => $data])->render();
           })
           ->rawColumns(['aksi','status','progress_task'])
           ->make(true);
   }
}
