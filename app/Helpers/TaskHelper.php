<?php
namespace App\Helpers;

use App\Models\Task;
use App\Models\TaskMaintenance;
use App\Models\ProjectMember;
use App\Models\ProjectPlan;
use App\Models\ProjectPlanDetail;
use Auth;
use Session;
use Carbon\Carbon;

class TaskHelper
{
	public static function persenPlan($id)
	{
		$task = Task::whereHas('planDetail', function($query) use($id){
			$query->whereHas('projectPlan',function($query) use($id){
				$query->where('id',$id);
			});
		})->avg('process');

		return $task;
	}
	public static function persenPlanDetail($id)
	{
		$task = Task::whereHas('planDetail', function($query) use($id){
			$query->where('id',$id);
		})->avg('process');

		return $task;
	}
	public static function persenPlanProject($id)
	{
		$task = Task::where('project_id',$id)->avg('process');

		return $task;
	}
	public static function cekPlan($project_id,$user_id = null)
	{
			if(empty($user_id))
			{
				$user_id = auth()->user()->id;
			}
			$cek = ProjectPlan::where(['project_id' => $project_id])->count();

			if($cek > 0)
			{
				return true;
			} else{
				return false;
			}
	}
	public static function initials($str) {
			 $ret = '';
			 $i = 0;
			 foreach (explode(' ', $str) as $word)
			 {
				 $i++;
				 if($i<=3)
				 {
					 $ret .= strtoupper($word[0]);
				 }

			 }

			 return $ret;
	}
	public static function cekPM($user_id = null)
	{
			if(empty($user_id))
			{
				$user_id = auth()->user()->id;
			}
			$cek = ProjectMember::where(['user_id' => $user_id, 'is_pm' => true])->count();
			if($cek > 0)
			{
				return true;
			} else{
				return false;
			}
	}
	public static function cekPMProject($user_id = null,$project)
	{
			if(empty($user_id))
			{
				$user_id = auth()->user()->id;
			}
			$cek = ProjectMember::where(['user_id' => $user_id, 'is_pm' => true,'project_id' => $project])->count();
			if($cek > 0)
			{
				return true;
			} else{
				return false;
			}
	}
	public static function showMember($project_id,$limit)
	{

			$project = ProjectMember::where(['project_id' => $project_id])->orderBy('created_at','DESC')->limit(14)->get();

			return $project;
	}
	public static function get($id)
    {
        $task = Task::where('id',$id)->first();

        return $task;
    }

    public static function calculateTime($datetime, $minute)
    {
    	$addTime = Carbon::parse($datetime);

    	$datetime = $addTime->addMinutes($minute);

    	return $datetime;
    }
		public static function checkMember($user_id, $task_id)
		{
			$tm = TaskMaintenance::whereHas('members',function($query)use($user_id){
									$query->where('user_id',$user_id);
							})
							->where('id',$task_id)->count();
			return !empty($tm) ? true:false;
		}
    public static function notifDL($user_id, $task_id,$minutes)
    {
        $TMT = TaskMaintenance::whereHas('members',function($query)use($user_id){
                    $query->where('user_id',$user_id);
                })
                ->where('id',$task_id)->first();
        if(empty($TMT))
        {
            return false;
        }
        $now_add = strtotime(Carbon::parse(now())->addMinutes($minutes));
        $selesai = strtotime($TMT->end);
        if($now_add >= $selesai)
        {
            return true;
        } else{
            return false;
        }
    }


}
