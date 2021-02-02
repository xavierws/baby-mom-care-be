<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLog extends JsonResource
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
            'id'=>$this->id,
            'log' => $this->log,
            'name' => $this->user->profile_name,
            'created_at' => $this->created_at,
            'role' => $this->user->user_role,
            'hospital' => $this->user->userable->hospital->name,
        ];
    }
}
