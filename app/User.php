<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'points'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function shifts()
    {
        return $this->belongsToMany('App\Shift');
    }

    public function socials_user()
    {
        return $this->hasMany('App\SocialUser');
    }
}
