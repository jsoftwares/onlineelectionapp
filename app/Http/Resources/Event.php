<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
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
            'title' => $this->title,
            'short_title' => $this->short_title,
            'status' => $this->status,
            'company' => $this->company,
            'polls' => $this->polls,
        ];
    }
}
