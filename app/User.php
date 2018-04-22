<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const LEVEL_ONE = 100;
    const LEVEL_TWO = 200;
    const LEVEL_THREE = 300;
    const LEVEL_FOUR = 400;
    const LEVEL_FIVE = 500;
    const LEVEL_SIX = 600;
    const LEVEL_SEVEN = 700;
    const LEVEL_EIGHT = 800;
    const LEVEL_NINE = 900;
    const LEVEL_TEN = 1000;

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

    public function addPoints($points)
    {
        $this->points = $this->points + $points;
        if ($this->save()) {
            return $this->$points;
        };
        return 0;
    }

    public function getLevel()
    {
        $currentPoints = $this->points;

        if($currentPoints <= self::LEVEL_ONE){
            return 1;
        } elseif ($currentPoints <= self::LEVEL_TWO){
            return 2;
        } elseif ($currentPoints <= self::LEVEL_THREE) {
            return 3;
        } elseif ($currentPoints <= self::LEVEL_FOUR){
            return 4;
        } elseif ($currentPoints <= self::LEVEL_FIVE) {
            return 5;
        } elseif ($currentPoints <= self::LEVEL_SIX) {
            return 6;
        } elseif ($currentPoints <= self::LEVEL_SEVEN) {
            return 7;
        } elseif ($currentPoints <= self::LEVEL_EIGHT) {
            return 8;
        } elseif ($currentPoints <= self::LEVEL_NINE) {
            return 9;
        }elseif ($currentPoints <= self::LEVEL_TEN) {
            return 10;
        }
        else{
            return 11;
        }
        return 0;
    }

    public function isLevelUp($prevLevel)
    {
        return $this->getLevel() > $prevLevel;
    }


}
