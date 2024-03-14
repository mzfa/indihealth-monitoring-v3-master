<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationKaryawan extends Model
{
    use HasFactory;

    protected $table = "employee_locations";
    protected $fillable = [
        "karyawan_id","name","address",	'lat',	'lng',	'created_by',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

     public function user()
    {
        return $this->belongsTo(Karyawan::class, 'created_by');
    }
}
