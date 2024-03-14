<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSelect extends JsonResource
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
                    'text' => !empty($this->karyawan) ? $this->karyawan->nama_lengkap." (".$this->karyawan->jabatan->nama.")":$this->name." (Tidak terhubung ke karyawan)",
            ];
    }
}
