<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NurseProfile extends JsonResource
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
            'name' => $this->name,
            'working_exp' => $this->working_exp,
            'education' => $this->education,
            'phone' => $this->phone,
            'hospital' => $this->hospital_name,
            'link' => $this->hospital_link,
            'is_approved' => $this->is_approved,
            'user_id' => $this->user->id,
            'username' => $this->user->username,
        ];
    }
}
