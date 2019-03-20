<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ["wallet_id","transaction_type","amount", 'new_balance', 'comment', 'credit_card_transaction'];
    public function __construct(array $attributes = [])
    {
        $this->table = 'wallet_transactions';
        parent::__construct($attributes);
    }
}
