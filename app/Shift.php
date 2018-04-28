<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shift extends Model
{
    use Notifiable;

    protected $guarded = []; //all

    public function station()
    {
        return $this->belongsTo('App\Station');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
