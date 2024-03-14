<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskMaintenanceLevel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','description','minutes','updated_by'];
    protected $table = 'task_maintenance_levels';

    public function taskMaintenance()
    {
    	return $this->hasMany(TaskMaintenance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
}
