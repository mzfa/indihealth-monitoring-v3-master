<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = "absensi";
    protected $fillable = ['karyawan_id','is_read_toast','is_read','requested_absen_at','request_absen_keluar','is_req_acc','foto_pulang','lng_pulang','jam_kerja','lat_pulang','foto','tanggal','jam_masuk','jam_keluar','lng','lat','ip_address','browser','platform','updated_by'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
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
