<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Chat extends JsonResource
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
            'sender_id' => $this->sender_id,
            'sender_name' => User::find($this->sender_id)->profile_name,
            'sender_username' => User::find($this->sender_id)->username,
            'receiver_id' => $this->receiver_id,
            'receiver_name' => User::find($this->receiver_id)->profile_name,
            'receiver_username' => User::find($this->receiver_id)->username,
            'text' => $this->text,
            'is_read' => $this->is_read,
        ];
    }
}
