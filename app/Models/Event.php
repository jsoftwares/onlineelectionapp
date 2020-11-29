<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['vote_online'];
    protected $dates = ['deleted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function candidates()
    {
        return $this->hasManyThrough(Candidate::class, Poll::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function($event){
            $event->update(['vote_online' => route('vote_online', $event->id)]);
        });
    }
}
