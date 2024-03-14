<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaskMember extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','task_id','is_read_toast','is_read_notif','is_read','keterangan','updated_by'];
    protected $table = 'task_members';

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
