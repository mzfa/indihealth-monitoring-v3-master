<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = ['name','username','nama_perusahaan','no_telp','jabatan','email','activated_at','password','is_banned','updated_by'];
    protected $table = "guests";

 
}
