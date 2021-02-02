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
            'log' => $this->log,
            'name' => $this->user->profile_name,
            'time' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'role' => $this->user->user_role,
            'hospital' => $this->user->userable->hospital->name,
        ];
    }
}
