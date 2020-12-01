<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Attendee extends JsonResource
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
            // 'id' => $this->id,
            'uid' => $this->uid,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'onlineSessionKey' => $this->votesession->key,
        ];
    }
}
