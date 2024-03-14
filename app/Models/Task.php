<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tasks";
    protected $fillable = ['tanggal','deadline','task_plan_id','task_name','karyawan_id','process','is_done','updated_by','solusi','kesulitan','project_id','resuming','resume_from'];
    protected $appends = ['project_name'];

    public function getProjectNameAttribute()
    {
      return $this->project()->getResults()->name." (".$this->project()->getResults()->client.")";
    }
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function planDetail()
    {
        return $this->belongsTo(ProjectPlanDetail::class, 'task_plan_id');
    }
    public function members()
    {
        return $this->hasMany(TaskMember::class, 'task_id');
    }
  	public function getCreatedAtAttribute($date)
    {
        return date('d-m-Y H:i:s',strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('d-m-Y H:i:s',strtotime($date));
    }


}
