<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedProject extends Model
{
    use HasFactory;
    protected $fillable =['guest_id','project_id','shareable_link','is_shareable','updated_by','shareable_task_dev','shareable_task_mt','shareable_notulen'];
    protected $table = 'linked_project_guests';

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    } 

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getPercentProject()
    {
       return $this->project->tasks->avg('process');
    }


}
