<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevicePushUser extends Model
{
    protected $fillable = [
        'user_id', 'device_id'
        ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
