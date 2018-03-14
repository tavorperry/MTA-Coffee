<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id', 'station_id', 'type', 'status', 'desc'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function station()
    {
        return $this->belongsTo('App\Station');
    }
}
