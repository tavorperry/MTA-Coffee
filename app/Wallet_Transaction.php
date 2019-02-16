<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet_Transaction extends Model
{
    protected $fillable = ["wallet_id","transaction_type","amount"];
    public function __construct(array $attributes = [])
    {
        $this->table = 'wallet_transactions';
        parent::__construct($attributes);
    }
}
