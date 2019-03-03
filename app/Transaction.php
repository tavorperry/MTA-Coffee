<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ["wallet_id","transaction_type","amount", 'new_balance', 'comment'];
    public function __construct(array $attributes = [])
    {
        $this->table = 'wallet_transactions';
       /* $this->transaction_type = $attributes['transaction_type'];
        $this->amount = $attributes['amount'];*/
        parent::__construct($attributes);
    }
}
