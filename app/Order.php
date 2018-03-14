<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'station_id', 'user_id', 'amount'
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
