<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "karyawan";
    protected $fillable = ['nip','github_link','cv','no_ktp','no_npwp','bitbucket_link','gitlab_link','join_date','resign_date','nama_lengkap','tipe_karyawan','tempat_lahir','tanggal_lahir','no_telp','jabatan_id','foto','updated_by'];

    public function jabatan()
	{
		return $this->belongsTo(Jabatan::class,'jabatan_id');
	}

    public function user()
    {
        return $this->belongsTo(User::class,'id','karyawan_id');
    }
    public function cuti()
    {
        return $this->belongsTo(Cuti::class,'id','karyawan_id');
    }


  	public function getCreatedAtAttribute($date)
    {
        return date('d-m-Y H:i:s',strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('d-m-Y H:i:s',strtotime($date));
    }


}
