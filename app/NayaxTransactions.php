<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NayaxTransactions extends Model
{
    protected $fillable = ['transactionId', 'userId','used'];
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

    public static function isTransactionIdAlreadyUsed($transactionId){
        $result = null;
        $nayaxTransaction = DB::table('nayax_transactions')->where('transactionId', $transactionId)->first();
        if(!empty ($nayaxTransaction)){
            $result = $nayaxTransaction->used == true;
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
}
