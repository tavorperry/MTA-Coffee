<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user','email', 'first_name', 'last_name', 'total_payment'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }

}
