<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingAttedance extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['user_id','meeting_room_id','menit','updated_by'];
    protected $table = 'kehadiran_meeting';

    public function meeting()
    {
        return $this->belongsTo(Meeting::class,'meeting_room_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
