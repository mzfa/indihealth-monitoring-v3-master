<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TicketingShow extends JsonResource
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
                    'id' => $this->id,
                    'client' => $this->guest->name." - ".$this->guest->nama_perusahaan,
                    'no_tiket' => $this->no_ticket,
                    'project' => $this->project->name,
                    'judul' => $this->title,
                    'kronologi' => nl2br($this->kronologi),
                    'alamat_situs' => $this->alamat_situs,
                    'orang' => $this->user_target->name,
                    'division' => $this->ticketing_target->name,
                    'email' => $this->guest->email,
                    'no_telp' => $this->guest->no_telp,
                    'status' => $this->status,
                    'img' => route('ticketing.maintenance.showFoto',['file' => empty($this->screenshot) ? "default.png":$this->screenshot]),
                    'created_at' => date('Y-m-d H:i:s',strtotime($this->created_at))."<br> <small>".Carbon::parse($this->created_at)->diffForHumans()."</small>",
            ];
    }
}
