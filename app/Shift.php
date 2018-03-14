<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
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
