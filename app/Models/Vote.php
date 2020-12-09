<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $dates = ['updated_at', 'created_at','deleted_at'];
    protected $fillable = ['candidate_id'];
    
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
}
