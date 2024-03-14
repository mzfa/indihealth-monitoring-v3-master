<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestResetPwd extends Model
{
    protected $table="password_reset_guests";
    use HasFactory;
    protected $fillable = ['guest_id','reset_code','expired'];
}
