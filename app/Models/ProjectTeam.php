<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    use HasFactory;
    protected $fillable=["name","user_id",'project_id','description','updated_by';
    protected $table = 'project_teams';

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
