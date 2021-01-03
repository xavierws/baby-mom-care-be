<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientProfile extends JsonResource
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
            'baby_name' => $this->baby_name,
            'baby_birthday' => $this->baby_birthday,
            'born_weight' => $this->born_weight,
            'born_length' => $this->born_length,
            'current_weight' => $this->current_weight,
            'current_length' => $this->current_length,
            'baby_gender' => $this->baby_gender,
            'mother_name' => $this->mother_name,
            'mother_birthday' => $this->mother_birthday,
            'mother_religion' => $this->mother_religion,
            'mother_education' => $this->mother_education,
            'mother_job' => $this->mother_job,
            'paritas' => $this->paritas,
            'father_name' => $this->father_name,
            'father_birthday' => $this->father_birthday,
            'father_religion' => $this->father_religion,
            'father_education' => $this->father_education,
            'father_job' => $this->father_job,
            'status' => $this->status,
            'materi' => $this->materis,
            'username' => $this->user->username,
            'email' => $this->user->email,
        ];
    }
}
