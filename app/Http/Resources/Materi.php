<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Materi extends JsonResource
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
            'content' => $this->content,
            'content_url' => $this->content_url,
            'video_url' => $this->video_url,
            'doc_url' => $this->doc_url,
            'image' => asset($this->image->filename),
            'forum',
        ];
    }
}
