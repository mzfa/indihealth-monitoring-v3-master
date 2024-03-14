<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudCategory extends Model
{
    use HasFactory;
    protected $table = "cloud_category";
    protected $fillable = ['category'];
}
