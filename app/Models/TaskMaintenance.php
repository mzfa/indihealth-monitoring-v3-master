<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskMaintenance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['task_maintenance_level_id','created_by','tanggal','ticketing_id','task_name','process','kesulitan','solusi','is_done','updated_by','timing','start','end','project_id','is_done'];
    protected $table = 'task_maintenance';

    public function level()
    {
        return $this->belongsTo(TaskMaintenanceLevel::class,'task_maintenance_level_id');
    }
    public function ticketing()
    {
        return $this->belongsTo(TicketingMaintenance::class,'ticketing_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function members()
    {
    	return $this->hasMany(TaskMaintenanceMember::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    public function getPercentMT()
    {
       return $this->avg('process');
    }
}
