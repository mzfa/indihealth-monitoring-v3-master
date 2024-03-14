<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotifMember extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

            return [
                    'id' =>  $this->id,
                    'project' => !empty($this->task) ? $this->task->project->name." (".$this->task->project->client.")":'-',
                    'project_link' => route('task',['project_id' => $this->task->project_id]),
                    'task_id' =>$this->task_id,
                    'title' => !empty($this->task)?$this->task->task_name:'-',
                    'task' =>$this->keterangan,
                    'human_time' => Carbon::parse($this->created_at)->diffForHumans(),
                    'is_read' => $this->is_read_notif,
                    'created_at' => date('Y-m-d H:i:s',strtotime($this->created_at))

            ];
    }
}
