<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $fillable = [
        'opening_user_id','closing_user_id', 'station_id', 'type', 'status', 'desc'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'opening_user_id');
    }

    public function station()
    {
        return $this->belongsTo('App\Station');
    }
}
