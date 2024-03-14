<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTracking extends Model
{
    use HasFactory;

    protected $table = "tracking_page";
    protected $fillable = ['user_id','kategori','route_name','page','count'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
