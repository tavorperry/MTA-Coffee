<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $fillable = ["user_id","balance"];

    public function __construct(array $attributes = [])
    {
        $this->table = 'users_wallets';
        parent::__construct($attributes);
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Validate amount in the wallet.
     *
     * @param  double  $amount
     * @return boolean
     */
    private function isEnoughBalance($amount){
        return $this->balance >= $amount;
    }

    /**
     * get wallet balance.
     *
     * @return double
     */
    public function balance(){
        return $this->balance;
    }

    /**
     * deposit transaction.
     *
     * @param  double  $amount
     * @return boolean
     */

    public function deposit($amount, $comment = "No Comment!"){
        DB::beginTransaction();
        try{
            $this->balance += $amount;
            $this->save();
            $this->transactions()->create([
                'transaction_type' => 'deposit',
                'amount'           => $amount,
                'comment'          => $comment,
            ]);
            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollback();
            Log::error("Failed to depoosit. user " + $this->user_id + " Exception: " + $e);
            return false;
        }
    }


    /**
     * transaction for transfer between users.
     *
     * @param  double  $amount
     * @return boolean
     */
    public function received($amount, $comment ="No Comment!"){
        $this->balance += $amount;
        $this->save();
        $this->transactions()->create([
            'wallet_id'        => $this->id,
            'transaction_type' => 'received',
            'amount'           => $amount,
            'comment'          => $comment,
        ]);
    }

    /**
     * build withdraw transaction.
     *
     * @param  double  $amount
     * @return boolean
     */
    public function pay($amount, $comment="No Comment!", $station){
        if($this->isEnoughBalance($amount)){
            DB::beginTransaction();
            try{
                $this->balance -= $amount;
                $this->save();
                $this->transactions()->create([
                    'transaction_type' => 'withdraw',
                    'amount'           => $amount,
                    'comment'          => $comment,
                    'station'          => $station,
                ]);
                DB::commit();
                return true;
            }catch (Exception $e){
                DB::rollback();
                Log::error("Failed to pay. user " + $this->user_id + " Exception: " + $e);
                return false;
            }
        }
        return false;
    }

    /**
     * build transfer transaction.
     *
     * @param  double $amount
     * @param  \App\User $toUser
     * @return boolean
     * @throws Exception
     */
    public function transfer($amount , $toUser, $comment="No Comment!"){
        if($this->isEnoughBalance($amount)) {
            DB::beginTransaction();
            try{
                if(!$toUser instanceof User){
                    throw new Exception("User to transfer not found!");
                }
                $this->balance -= $amount;
                $this->save();
                $this->transactions()->create([
                    'transaction_type' => 'transfer',
                    'amount'           => $amount,
                    'comment'          => $comment,
                ]);
                $toUser->wallet->received($amount);
                DB::commit();
                return true;
            }catch (Exception $e){
                DB::rollback();
                Log::error("Failed to transfer money to user " + $toUser + " Exception: " + $e);
            }
        }
        return false;
    }
}