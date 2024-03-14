<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReqAbsensiNotif extends JsonResource
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
                    'nama_lengkap' => $this->karyawan->nama_lengkap,
                    'tanggal' =>$this->tanggal,
                    'jam' =>$this->request_absen_keluar,
                    'link_absen' =>route('absen',['absen_id' => $this->id]),
                    'human_time' => Carbon::parse($this->requested_absen_at)->diffForHumans(),

            ];
    }
}
