<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineHistory extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','tanggal','user_agent','ip_address'];
    protected $table = 'online_history';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
