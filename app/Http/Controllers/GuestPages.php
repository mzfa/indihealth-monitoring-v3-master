<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\LinkedProject;
use App\Models\Notulensi;
use App\Models\Task;
use App\Models\TaskMaintenance;
use App\Models\Project;
use AuthGuest;
use Hash;
use Carbon\Carbon;
use App\Http\Requests\UserActivatePwdRequest;

class GuestPages extends Controller
{
    public function dashboard()
    {
    	$linked = LinkedProject::where('guest_id', AuthGuest::guest()->id)->get();
    	return view('guest.pages.projek')->with(['linked' => $linked]);
    } 

    public function notulensi($project_id,Request $request)
    {
        if(!$this->protectPages($project_id,'notulensi'))
        {
            return abort(404);
        }
        
        $notulensi = Notulensi::where('project_id',$project_id);
        if(!empty($request->search))
        {
           $notulensi->where('judul_agenda','like','%'.$request->search.'%');
        }
        if(!empty($request->date))
        {
           $notulensi->where('waktu_meeting','like',$request->date.'%');
        }
        $notulensi =  $notulensi->orderBy('created_at','Desc')->paginate(4);
        $project = Project::where('id',$project_id)->first();
        // dd($project);

        return view('guest.pages.notulensi')->with(['notes' => $notulensi,'project' => $project]);
    }
    public function setnewpassword()
    {
       $user = Guest::where('id',AuthGuest::guest()->id);
        if(empty($user->first()->activated_at))
        {
           return view("account.guest.setnewpassword");
        } else{
           return redirect()->route('home')->with(['message_warning' => "Tidak perlu, Anda telah mengaktifkan akun ini."]);
        }
    }

    public function activateAccount(UserActivatePwdRequest $request)
    {
        $user = Guest::where('id',AuthGuest::guest()->id);
        if(!empty($user->first()->activated_at))
        {
          return redirect()->route('guest.dashboard')->with(['message_warning' => "Tidak perlu, Anda telah mengaktifkan akun ini."]);
        }
          $params['password'] = Hash::make($request->password);
          $params['activated_at'] = now();
          $user->update($params);
          return redirect()->route('guest.dashboard')->with(['message_success' => "Selamat Datang, Akun anda telah aktif."]);

    }

    public function shareable_link($shareable_link)
    {
    	$linked = LinkedProject::where('shareable_link', $shareable_link)->first();
    	if(empty($linked))
    	{
    		return abort(404);
    	}

    	if(md5($shareable_link) != md5($linked->shareable_link))
    	{
    		return abort(404);
    	}

    	return view('project.share_link',['project_id' => $linked->project_id,'project' => $linked]);

    }
    public function taskDev($id)
    {
        if(!$this->protectPages($id,'taskdev'))
        {
            return abort(404);
        }
    	$linked = LinkedProject::where(['project_id' => $id,'guest_id' => AuthGuest::guest()->id]);
    	if($linked->count() <= 0)
    	{
    		return abort(404);
    	}
    	return view('guest.pages.task_dev')->with(['id' => $id,'linked' => $linked->first()]);
    }
    public function taskMT($id)
    {
        // if(!$this->protectPages($id,'taskmt'))
        // {
        //     return abort(404);
        // }
    	$linked = LinkedProject::where(['project_id' => $id,'guest_id' => AuthGuest::guest()->id]);
    	if($linked->count() <= 0)
    	{
    		return abort(404);
    	}
    	return view('guest.pages.task_mt')->with(['id' => $id,'linked' => $linked->first()]);
    }

     public function getDataTaskDev($id, Request $request)
    {
       
        if(!empty($request->end_date) || !empty($request->start_date || !empty($request->process)))
        {
            $tsk = Task::where('project_id',$id);
            if(!empty($request->end_date) || !empty($request->start_date))
            {
                $tsk->whereBetween('tanggal',[$request->start_date,$request->end_date]);
            }
            $tsk->where('process','>=',empty($request->progress)?0:$request->progress);
            $data = $tsk->orderBy('created_at','DESC')->get();
        } else{
            $data = Task::where('project_id',$id)->orderBy('created_at','DESC')->get();
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
            ->editColumn('progress_task', function ($data) {
               return view('task.partials.progress')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','status','progress_task'])
            ->make(true);
    }

    public function getDataTaskMT($project_id,Request $request)
    {
      // \DB::enableQueryLog(); // Enable query log
        if(!empty($request->end_date) || !empty($request->start_date || !empty($request->process)))
        {
            $tsk = TaskMaintenance::where('project_id',$project_id)->where('process','>=',empty($request->progress)?0:$request->progress);
            if(!empty($request->end_date) || !empty($request->start_date))
            {
              $tsk->whereBetween('tanggal',[$request->start_date,$request->end_date]);

            }


            $data = $tsk->orderBy('created_at','DESC')->get();
            // dd(\DB::getQueryLog());
        } else{

            $data = TaskMaintenance::where('project_id',$project_id)->orderBy('created_at','DESC')->get();
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
            ->editColumn('progress_task', function ($data) {
               return view('task_maintenance.partials.progress')->with(['data' => $data])->render();
            })
            ->rawColumns(['ticket','status','progress_task','timing','member'])
            ->make(true);
    }

    private function protectPages($project_id,$module)
    {
        $linked = LinkedProject::where('project_id', $project_id)->where('guest_id', AuthGuest::guest()->id)->first();
        if(empty($linked))
        {
            return false;
        }
        if($module == 'notulensi')
        {
            if($linked->shareable_notulen)
            {
                return true;
            } 
            return false;
        } elseif($module == 'taskdev')
        {
            if($linked->shareable_task_dev)
            {
                return true;
            } 
            return false;
        } elseif($module == 'tasakmt')
        {
            if($linked->shareable_task_mt)
            {
                return true;
            } 
            return false;
        }
    }
}
