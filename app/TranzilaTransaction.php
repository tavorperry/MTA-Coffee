<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TranzilaTransaction extends Model
{

    protected $fillable = [
        'sum', 'currency', 'pdesc','lang', 'company', 'contact', 'email','thtk'
    ];

    public static function saveObjectToDB($tranzila_transaction){
        $isSaved = false;
        try {
            $isSaved = $tranzila_transaction->save();
        }catch (Exception $e){
            Log::error("saveObjectToDB Failed! Exception: ".$e->getMessage());
        }
        if ($isSaved) {
            Log::info("TranzilaTransactionObject successfully saved!");
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

}
