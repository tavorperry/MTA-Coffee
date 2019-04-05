<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

trait HasWallet
{
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

}
