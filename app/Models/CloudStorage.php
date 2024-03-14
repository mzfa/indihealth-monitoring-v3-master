<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CloudStorage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "cloud_storage";
    protected $fillable = ['user_id','project_id','name','is_private','extension','cloud_category_id','password','url_name','file_name','mimes','size','updated_by'];

    public function category()
    {
        return $this->belongsTo(CloudCategory::class,'cloud_category_id','id');
    }
}
