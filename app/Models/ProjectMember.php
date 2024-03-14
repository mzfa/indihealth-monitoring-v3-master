<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;
    protected $fillable=["user_id","project_team_id","project_id",'keterangan','is_pm',"updated_by"];
    protected $table = 'project_team_members';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
