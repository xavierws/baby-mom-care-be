<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Forum extends JsonResource
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
            'name' => $this->user->user_name,
            'role' => $this->user->user_role,
            'title' => $this->title,
            'question' => $this->question,
            'comments' => Comment::collection($this->comments),
            'id'=>$this->id
        ];
    }
}
