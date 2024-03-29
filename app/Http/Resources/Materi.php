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
            'id'=>$this->id,
            'title' => $this->title,
            'content' => $this->content,
            'content_url' => $this->content_url,
            'video_url' => $this->video_url,
            'doc_url' => $this->doc_url,
            'image' => $this->image? asset($this->image->filename):null,
            'quiz' => $this->related_quiz,
            'forum' => $this->related_forum,
            'date'=>$this->created_at
        ];
    }
}
