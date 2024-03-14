<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulensi extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','judul_agenda','roadmap','notulensi','waktu_meeting','shareable_link','is_shareable','created_by','updated_by'];
    protected $table = 'notulensi';

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
