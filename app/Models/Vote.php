<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $dates = ['deleted_at'];
    
    public function poll()
    {
        return $this->belongsTo(Event::class);
    }

    public function canditate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
