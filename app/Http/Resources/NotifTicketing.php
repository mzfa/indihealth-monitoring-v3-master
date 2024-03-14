<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotifTicketing extends JsonResource
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
                    'project' => $this->project->name." (".$this->project->client.")",
                    'title' =>$this->title,
                    'created_at' => date('Y-m-d H:i:s',strtotime($this->created_at)),
                    'is_read' => $this->is_read_notif,
                    'human_time' => Carbon::parse($this->created_at)->diffForHumans(),

            ];
    }
}
