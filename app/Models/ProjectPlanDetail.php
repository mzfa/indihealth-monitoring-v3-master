<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPlanDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=["name","task_plan_id","description","start_date","end_date",'updated_by'];
    protected $table = 'task_plan_details';
    public function getPercentProject($task_plan_id)
    {
       return $this->tasks->avg('process');
    }
    public function projectPlan()
    {
        return $this->belongsTo(ProjectPlan::class, 'task_plan_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class,'task_plan_id');
    }

}
