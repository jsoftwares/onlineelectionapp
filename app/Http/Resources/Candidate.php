<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Candidate extends JsonResource
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
            'uid' => $this->uid,
            'name' => $this->name,
            'status' => $this->status,
            'photo' => $this->photo,
            'poll_id' => $this->poll_id,
            'won' => $this->won,
            'via' => $this->via,
            'votes' => $this->votes()->count()
        ];
    }
}
