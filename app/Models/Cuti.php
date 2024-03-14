<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = "cuti";
    protected $fillable = [
        "karyawan_id","start","end",	'jumlah',	'reason_cuti',	'status_by',	'status',	'reason_status',	'is_read	is_toast'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

     public function acc()
    {
        return $this->belongsTo(Karyawan::class, 'status_by');
    }
}
