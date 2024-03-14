<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiShow extends JsonResource
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
                    'karyawan_id' => $this->karyawan_id,
                    'nama_lengkap' => $this->karyawan->nama_lengkap." (".$this->karyawan->jabatan->nama.")",
                    'foto_pulang' => route('showFotoPulang',['file' => empty($this->foto_pulang)?'default.jpg':$this->foto_pulang]),
                    'lng_pulang' => $this->lng_pulang,
                    'lat_pulang' => $this->lat_pulang,
                    'lng' => $this->lng,
                    'lat' => $this->lat,
                    'foto' => route('showFoto',['file' => empty($this->foto)?'default.jpg':$this->foto]),
                    'tanggal' => $this->tanggal,
                    'jam_masuk' => $this->jam_masuk,
                    'jam_kerja' => empty($this->jam_kerja)?0:number_format($this->jam_kerja,2),
                    'jam_keluar' => $this->jam_keluar,
                    'ip_address' => $this->ip_address,
                    'browser' => $this->browser,
                    'platform' => $this->platform,
            ];
    }
}
