<?php

namespace App\Http\Resources;

use App\Actions\showAdvices;
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
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'tempat_kontrol' => $this->tempat_kontrol,
            'weight' => $this->weight,
            'length' => $this->length,
            'lingkar_kepala' => $this->lingkar_kepala,
            'temperature' => $this->temperature,
            'image' => asset($this->image->filename),
            'note' => $this->note,
            'nurse_note' => $this->nurse_note,
            'advices' => showAdvices::handle($this->advices),
        ];
    }
}
