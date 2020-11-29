<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votesession extends Model
{
    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
}
