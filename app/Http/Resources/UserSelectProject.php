<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSelectProject extends JsonResource
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
                    'id' => $this->user->id,
                    'text' => !empty($this->user->karyawan) ? $this->user->karyawan->nama_lengkap." (".$this->user->karyawan->jabatan->nama.")":$this->user->name." (Tidak terhubung ke karyawan)",
            ];
    }
}
