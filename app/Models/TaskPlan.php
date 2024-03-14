<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPlan extends Model
{
    use HasFactory;
    protected $table = "task_plans";
    protected $fillable = ['name','user_id','project_id','start_date','end_date','description','created_at'];
}
