<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Kontrol extends JsonResource
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
            'title' => $this->title,
            'date' => $this->date,
            'tempat_kontrol' => $this->tempat_kontrol,
            'weight' => $this->weight,
            'length' => $this->length,
            'lingkar_kepala' => $this->lingkar_kepala,
            'temperature' => $this->temperature,
            'image' => asset($this->image->filename),
        ];
    }
}
