<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Poll extends JsonResource
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
            'winner' => $this->candidate_id,
            'event_id' => $this->event_id,
            'candidates' => Candidate::collection($this->candidates),
            'votes' => Vote::collection($this->votes),
            'votes_count' => $this->votes

        ];
    }
}
