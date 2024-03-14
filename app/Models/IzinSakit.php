<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IzinSakit extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable =['karyawan_id','jenis','file','mime','start','end','keterangan','status','approved_by','is_read','is_toast','is_cuti','created_by'];
    protected $table = 'pengajuan_izin';

 

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function accesor()
    {
       return $this->belongsTo(User::class, 'approved_by');
    }


}
