<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaskReportLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','task_id','process','detail_report','kesulitan','solusi','report_date','is_acc_pm','updated_by'];
    protected $table = 'task_report_logs';

    public function task()
    {
        return $this->belongsTo(Task::class,'task_id');
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
