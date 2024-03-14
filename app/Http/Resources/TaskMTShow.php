<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskMTShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          $start_date = date('Y-m-d',strtotime($this->start));
          $start_time = date('H:i',strtotime($this->start));
          $end_date = date('Y-m-d',strtotime($this->end));
          $end_time = date('H:i',strtotime($this->end));
            return [
                    'id'  => $this->id,
                    'task_maintenance_level_id'  =>$this->task_maintenance_level_id,
                    'task_name'  =>$this->task_name,
                    'project_name'  =>$this->project->name,
                    'project_id'  =>$this->project->id,
                    'level_name'  =>$this->level->name,
                    'level_id'  =>$this->level->id,
                    'ticketing_id'  =>$this->ticketing->id,
                    'ticketing_name'  =>$this->ticketing->no_ticket. " ". $this->ticketing->project->name." (".$this->ticketing->project->client.")",
                    'process'  =>$this->process,
                    'kesulitan'  =>$this->kesulitan,
                    'solusi'  =>$this->solusi,
                    'is_done'  =>$this->is_done,
                    'updated_by'  =>$this->updated_by,
                    'timing'  =>$this->timing,
                    'start_date'  =>$start_date,
                    'start_time'  =>$start_time,
                    'end_date'  =>$end_date,
                    'end_time'  =>$end_time,
                    'project_id'  =>$this->project_id,
                    'is_done' =>$this->is_done
            ];
    }
}
