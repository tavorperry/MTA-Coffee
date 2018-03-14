<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    protected $fillable = [
        'user_id', 'provider_id', 'provider_name'
    ];

    protected $hidden = [
        'provider_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
