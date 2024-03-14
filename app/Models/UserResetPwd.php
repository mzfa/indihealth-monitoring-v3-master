<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResetPwd extends Model
{
    protected $table="password_reset_internal";
    use HasFactory;
    protected $fillable = ['user_id','reset_code','expired'];
}
