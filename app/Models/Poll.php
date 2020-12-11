<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $with = ['candidates'];
    protected $dates = ['deleted_at'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class)->orderBy('name', 'asc');;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
