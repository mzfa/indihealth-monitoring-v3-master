<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class ProjectPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    private  $paramsrcx = "";
    protected $fillable=["name","user_id","project_id","start_date","end_date",'description','updated_by'];
    protected $table = 'task_plans';


  
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function projectPlanDetail()
    {
       return $this->hasMany(ProjectPlanDetail::class, 'task_plan_id');
    }
    public function projectPlanDetailSrc()
    {
         return $this->hasMany(ProjectPlanDetail::class, 'task_plan_id')->where('name','like','%'.Request::get('search').'%')->get();
    }
  
    public function tasks()
    {
        return $this->hasMany(Task::class,'task_plan_id');
    }
}
