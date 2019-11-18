<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Transaction;
use App\User;

/**
 * @property mixed $transactions
 */
class Wallet extends Model
{

    protected $fillable = ["user_id","balance"];

    public function __construct(array $attributes = [])
    {
        $this->table = 'users_wallets';
        parent::__construct($attributes);
       // $this->balance = 0;
        //$this->user_id = auth()->id();
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

    public function deposit($amount, $comment = "No Comment!", $creditCardTransactionId = null){
        log::info("Starting deposit() for wallet: ".$this);
        DB::beginTransaction();
        try{
            $this->balance += $amount;
            $this->save();
            $transaction = new Transaction([
                'transaction_type' => 'deposit',
                'amount'           => $amount,
                'comment'          => $comment,
                'wallet_id'        => $this->id,
                'new_balance'      => $this->balance(),
                'credit_card_transaction' => $creditCardTransactionId,
            ]);
            $transaction->save();

            DB::commit();
            log::info("deposit succeed for: ".$amount." ILS");
            return true;
        }catch (Exception $e){
            DB::rollback();
            Log::error("Failed to deposit. user ".$this->user_id . " Exception: " .$e->getMessage());
            return false;
        }
    }

    public function logTransaction($actionType, $amount, $comment)
    {
        log::info("Starting logTransaction() for Wallet: " . $this->id);
        try {
            $transaction = new Transaction([
                'transaction_type' => $actionType,
                'amount' => $amount,
                'comment' => $comment,
                'wallet_id' => $this->id,
                'new_balance' => $this->balance,
            ]);

            $saved = $transaction->save();
            if ($saved) {
                log::info("Exit logTransaction().Transaction Saved for Wallet: " . $this->id);
                return true;
            }else{
                log::error("Transaction failed to save!!! for Wallet: " . $this->id);
                return false;
            }
        } catch (Exception $e) {
            Log::error("Failed to create Transaction. Wallet: " . $this->id . " Exception: " . $e->getMessage());
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
    public function pay($amount, $comment="No Comment!"){
        log::info("Starting pay()");
        if($this->isEnoughBalance($amount)){
            try{
                $this->balance -= $amount;
                $this->save();
                $this->logTransaction("pay", $amount,$comment);
                return true;
            }catch (Exception $e){
                DB::rollback();
                Log::error("Failed to pay. user ".$this->user_id .". Exception: " .$e->getMessage());
                return false;
            }
        }else{
            Log::warning("Insufficient funds! Deposit amount: " .$amount . ". Wallet: " . $this.$this->toJson());
        }
        log::info("Exit pay()");
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
                Log::error("Failed to transfer money to user " .$toUser ." Exception: " .$e->getMessage());
            }
        }
        return false;
    }

    /**
     * refund transaction.
     * similar to deposit
     *
     * @param  double  $amount
     * @return boolean
     */

    public function refund($amount, $comment = "No Comment!"){
        $METHOD_NAME = "refund";
        log::info("Starting " . $METHOD_NAME . " for wallet: ".$this);
        DB::beginTransaction();
        try{
            $this->balance += $amount;
            $this->save();
            $transaction = new Transaction([
                'transaction_type' => $METHOD_NAME,
                'amount'           => $amount,
                'comment'          => $comment,
                'wallet_id'        => $this->id,
                'new_balance'      => $this->balance(),
            ]);
            $transaction->save();

            DB::commit();
            log::info($METHOD_NAME . " succeed for: ".$amount." ILS");
            return true;
        }catch (Exception $e){
            DB::rollback();
            Log::error("Failed to " . $METHOD_NAME . ". user ".$this->user_id . " Exception: " .$e->getMessage());
            return false;
        }
    }
}