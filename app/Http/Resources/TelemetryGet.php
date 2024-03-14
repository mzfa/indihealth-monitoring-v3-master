<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TelemetryGet extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      if(!empty($this->user->role))
      {
        $role = $this->user->role->name;
      } else{
        $role = "-";
      }

            return [
                    'user_id' => $this->id,
                    'email' => empty($this->user) ? "-":$this->user->email,
                    'u_name' => empty($this->user) ? "-":$this->user->name,
                    'u_created_at' => empty($this->user) ? "-":$this->user->created_at,
                    'u_activated_at' => empty($this->user) ? "-":$this->user->activated_at,
                    'is_disabled' => empty($this->user) ? "-":$this->user->is_disabled,
                    'role' => $role,
                    'kategori' => $this->kategori,
                    'route_name' => $this->route_name,
                    'page' => $this->page,
                    'count' => $this->count,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
            ];
    }
}
