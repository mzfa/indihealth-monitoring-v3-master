<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['room_name','external_meeting_room','share_code','external_link','room_code','password','description','room_open_at','room_close_at','updated_by'];
    protected $table = 'meeting_rooms';

    public function user()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

}
