<?php

namespace App\Models;

use App\Models\Votesession;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{

    protected $fillable = ['uid', 'name', 'token', 'email', 'attendance', 'mobile', 'event_id', 'misc', 'misc1', 'misc2', 'misc3', 'mis4', 'misc5'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function votesession()
    {
        return $this->hasOne(Votesession::class);
    }
}
