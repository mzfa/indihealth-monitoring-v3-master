<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectMemberTaskLogDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      // dd($this->user_id);
            $jabatan = empty($this->member->karyawan) ? "Tidak terhubung ke karyawan":$this->member->karyawan->jabatan->nama;
            return [
                    'task_id' => $this->task_id,
                    'name' => $this->member->name." (".$jabatan.")",
                    'process' => $this->process,
                    'rincian' => $this->detail_report,
                    'kesulitan' => $this->kesulitan,
                    'solusi' => $this->solusi,
                    'report_date' => $this->report_date
            ];
    }
}
