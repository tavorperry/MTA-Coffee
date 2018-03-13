<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
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
