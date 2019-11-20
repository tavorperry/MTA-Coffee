<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TranzilaTransaction extends Model
{

    protected $fillable = [
        'sum', 'user', 'thtk', 'currency', 'ccno', 'used'
    ];

    public static function saveObjectToDB($tranzila_transaction){
        $isSaved = false;
        try {
            $isSaved = $tranzila_transaction->save();
        }catch (Exception $e){
            Log::error("saveObjectToDB Failed! Exception: ".$e->getMessage());
        }
        if ($isSaved) {
            Log::info("TranzilaTransactionObject successfully saved! Transaction ID: " . $tranzila_transaction->id);
            return $tranzila_transaction->id;
        }
        else
            Log::error("TranzilaTransactionObject Failed to save!");
        return 0;

    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function getTranzilaTransactionByThtk($thtk){
        return TranzilaTransaction::where('thtk',$thtk) -> first();
    }

    public static function isTranzilaTransactionTimestampValid($thtk){
        $METHOD_NAME = "isTranzilaTransactionTimestampValid";
        Log::info("Starting " . $METHOD_NAME . " For THTK: " . $thtk);
        $result = null;
        $DBTimestamp = "";
        $nowTimestamp = "";
        try {
            $tranzilaTransaction = DB::table('tranzila_transactions')->where('thtk', $thtk)->first();
            if (!empty ($tranzilaTransaction)) {
                $DBTimestamp = $tranzilaTransaction->created_at;
                $nowTimestamp = now();
                $result = $nowTimestamp->diffInSeconds($DBTimestamp) <= env('TRANZILA_SECONDS_TIMEOUT_FOR_TRANSACTION');
            }
        }catch (\Exception $e){
            Log::error("isTranzilaTransactionTimestampValid() Falied. Exception msg: " . $e->getMessage());
        }
        Log::debug("DBTimestamp: " . strval($DBTimestamp) . ". nowTimestamp: " . strval($nowTimestamp) . ". For thtk: " . $thtk);
        if (isset($result) && $result){
            Log::info("THTK: " . $thtk . " Timestamp is valid!");
        }else{
            Log::warning("THTK: " . $thtk . " Timestamp is NOT valid!");
        }
        Log::info("Exit " . $METHOD_NAME);
        return $result;
    }

}
