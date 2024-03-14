<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\Project;
use App\Rules\UniqueTaskMember;
use Illuminate\Support\Facades\Auth;
use App\Helpers\JSon;
use App\Mail\TaskMaintenanceMail;
use Mail;

class TaskProjectMember extends Controller
{
    public function project(Request $request)
    {
      
      if(!empty($request->search))
      {
        $linked = ProjectMember::where('user_id', auth()->user()->id)->whereHas('project', function($query)use($request){
          $query->where('name', 'like', '%'.$request->search.'%');
        });
      }else {
        $linked = ProjectMember::where('user_id', auth()->user()->id);
      }

      $linked =  $linked->orderBy('created_at','Desc')->paginate(8);
    	return view('task.project_detail')->with(['linked' => $linked]);
    }
    private function params($request)
    {
    	$params =[
    				'user_id' => $request->user_id,
    				'task_id' => $request->task_id,
            'keterangan' => $request->task_user,
    				'updated_by' => auth()->user()->id,
    		];

    	return $params;
    }
}
