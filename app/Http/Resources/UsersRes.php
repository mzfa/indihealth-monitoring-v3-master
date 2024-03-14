<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersRes extends JsonResource
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
                    'active_users' => $this->active_users,
                    'not_active_users' => $this->not_active_users,
                    'disabled_users' => $this->disabled_users,
                    'enabled_user' => $this->enabled_user,

            ];
    }
}
