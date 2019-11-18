<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NayaxTransactions extends Model
{
    public static function isTransactionIdAlreadyUsed($transactionId){
        $result = null;
        $nayaxTransaction = DB::table('nayax_transactions')->where('transactionId', $transactionId)->first();
        if(!empty ($nayaxTransaction)){
            $result = $nayaxTransaction->used == true;
        }
        return $result;
    }

    protected $fillable = ['transactionId', 'userId','used', 'amount', 'refunded'];
    public static function generateTransactionId(){
        $transactionId = str_random(40);
        $isTransactionExist = self::isTransactionIdExists($transactionId);

        if ($isTransactionExist){
            Log::error("Transaction Id exist: " . $transactionId);
            return "0";
        }

        $nayaxTransaction = new NayaxTransactions();
        $nayaxTransaction->transactionId = $transactionId;
        $nayaxTransaction->userId = $user = auth()->id();
        $nayaxTransaction->used = false;

        $isSaved = false;
        try {
            $isSaved = $nayaxTransaction->save();
        }catch (Exception $e){
            Log::error("generateTransactionId Failed! Exception: ".$e->getMessage());
        }
        if ($isSaved) {
            Log::info("NayaxTransaction successfully saved!");
            return $nayaxTransaction->transactionId;
        }
        else{
            Log::error("NayaxTransaction Failed to save!");
            return "0";
        }
    }

    public static function isTransactionIdExists($transactionId){
        $result = null;
        $nayaxTransaction = DB::table('nayax_transactions')->where('transactionId', $transactionId)->first();
        if(!empty ($nayaxTransaction)){
            $result = $nayaxTransaction;
        }
        return $result;
    }

    public static function markTransactionAsUsedOnDB($transactionId){
        $isMarkedAsUsed = null;
        $isMarkedAsUsed = DB::table('nayax_transactions')->where('transactionId', $transactionId)->update(['used' => true]);
        if ($isMarkedAsUsed){
            Log::info("Nayax Transaction: '" . $transactionId . "'' Successfully marked as used on DB");
        }else{
            Log::error("Nayax Transaction: '" . $transactionId . "'' Could NOT be marked as used on DB !!!!!!!!!!!");
        }
        return $isMarkedAsUsed;
    }

    public static function isTransactionTimestampValid($transactionId){
        $result = null;
        $DBTimestamp = "";
        $nowTimestamp = "";
        try {
            $nayaxTransaction = DB::table('nayax_transactions')->where('transactionId', $transactionId)->first();
            if (!empty ($nayaxTransaction)) {
                $DBTimestamp = $nayaxTransaction->created_at;
                $nowTimestamp = now();
                $result = $nowTimestamp->diffInSeconds($DBTimestamp) <= env('NAYAX_SECONDS_TIMEOUT_FOR_TRANSACTION');
            }
        }catch (\Exception $e){
            Log::error("isTransactionTimestampValid() Falied. Exception msg: " . $e->getMessage());
        }
        Log::debug("DBTimestamp: " . strval($DBTimestamp) . ". nowTimestamp: " . strval($nowTimestamp) . ". For TransactionID: " . $transactionId);
        return $result;
    }

    public static function updateAmountOnRecord($transactionId, $amount){
        $result = null;
        try {
            $isAmountUpdated = DB::table('nayax_transactions')->where('transactionId', $transactionId)->update(['amount' => $amount]);
        }catch (\Exception $e){
            Log::error("isTransactionTimestampValid() Falied. Exception msg: " . $e->getMessage());
        }
        Log::debug("The amount: " . $amount. "was updated? (" . $isAmountUpdated . ") to TransactionId: " . $transactionId);
        return $isAmountUpdated;
    }

    public static function markTransactionAsRefundedOnDB($transactionId){
        $isMarkedAsUsed = null;
        $isMarkedAsUsed = DB::table('nayax_transactions')->where('transactionId', $transactionId)->update(['refunded' => true]);
        if ($isMarkedAsUsed){
            Log::info("Nayax Transaction: '" . $transactionId . "'' Successfully marked as refunded on DB");
        }else{
            Log::error("Nayax Transaction: '" . $transactionId . "'' Could NOT be marked as refunded on DB !!!!!!!!!!!");
        }
        return $isMarkedAsUsed;
    }
}
