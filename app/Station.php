<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Station extends Model
{
    use Notifiable;

    protected $guarded = []; //all

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function shifts()
    {
        return $this->hasMany('App\Shift');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }


}
