<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaskMaintenanceMember extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','task_maintenance_id','updated_by','is_read_toast','is_read_notif','is_read_deadline_toast','is_read_deadline_notif','tugas_individu'];
    protected $table = 'task_maintenance_members';

    public function taskMaintenance()
    {
        return $this->belongsTo(TaskMaintenance::class,'task_maintenance_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function member()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
