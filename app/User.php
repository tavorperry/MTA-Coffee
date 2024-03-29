<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Wallet;

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
        'first_name', 'last_name', 'email', 'password', 'points','secret_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'secret_token',
    ];

    public function reports()
    {
        return $this->hasMany('App\Report', 'opening_user_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function shifts()
    {
        return $this->belongsToMany('App\Shift');
    }

    public function socialUser()
    {
        return $this->hasMany('App\SocialUser');
    }

/*    public function devicePushUser()
    {
        return $this->hasMany('App\DevicePushUser');
    }*/

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

        if($currentPoints < self::LEVEL_ONE){
            return 0;
        } elseif ($currentPoints < self::LEVEL_TWO){
            return 1;
        } elseif ($currentPoints < self::LEVEL_THREE) {
            return 2;
        } elseif ($currentPoints < self::LEVEL_FOUR){
            return 3;
        } elseif ($currentPoints < self::LEVEL_FIVE) {
            return 4;
        } elseif ($currentPoints < self::LEVEL_SIX) {
            return 5;
        } elseif ($currentPoints < self::LEVEL_SEVEN) {
            return 6;
        } elseif ($currentPoints < self::LEVEL_EIGHT) {
            return 7;
        } elseif ($currentPoints < self::LEVEL_NINE) {
            return 8;
        }elseif ($currentPoints < self::LEVEL_TEN) {
            return 9;
        }
        else{
            return 10; //Once user have 1000+ points he will stay in the last Level
        }
    }

    public function isLevelUp($prevLevel)
    {
        $currentLevel = $this->getLevel();
        $isLevelUp = $currentLevel > $prevLevel;
        $this->notifyOnceUserAtHighestLevel($isLevelUp,$currentLevel);
        return  $isLevelUp;
    }

    public function notifyOnceUserAtHighestLevel($isLevelUp,$currentLevel){
        if($isLevelUp == 1 && $currentLevel == 11){
            $user = Auth::user();
                    Mail::send('emails.userAtHighestLevel', ['user' => $user], function ($m) use ($user) {
                            $m->from(env('EMAIL_FROM'), 'קפה אמון');
                        $m->to('mtacoffe@gmail.com', $user->first_name)->subject("מייל למנהלת המשרד - משתמש הגיע לרמה הכי גבוהה!");
                    });
        }
    }
    private function initWallet($wallet)
    {
        $wallet->create([
            'user_id' => $this->id,
            'balance' => 0,
        ]);
    }

    public function wallet()
    {
        $wallet = $this->hasOne(Wallet::class, "user_id", "id");
        if ($wallet->count() == 0) {
            $this->initWallet($wallet);
            $wallet = $this->hasOne(Wallet::class , "user_id", "id");
        }
        return $wallet;
    }

    public static function getUserByEmail($email){
        return User::where('email',$email) -> first();
    }
}
