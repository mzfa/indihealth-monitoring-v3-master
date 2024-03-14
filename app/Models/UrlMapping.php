<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlMapping extends Model
{
    use HasFactory;
    protected $table = "map_routes";
    protected $fillable = ['name','parent_id','icon','url','order_menus','created_by'];

     public function parent()
    {
        return $this->belongsTo(UrlMapping::class,'parent_id');
    }  

    public function childs()
    {
        return $this->hasMany(UrlMapping::class,'parent_id');
    }
}
