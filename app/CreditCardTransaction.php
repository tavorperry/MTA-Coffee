<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreditCardTransaction extends Model
{
    protected $fillable = [
        'Code', 'CardNumber', 'PayDate','Terminal', 'DealID', 'DealType', 'DealTypeOut', 'DkNumber', 'DealDate', 'TotalSum', 'CardName', 'CardNameID', 'AuthNum', 'DealNumber', 'ErrorDesc', 'ManpikID', 'MutagID'
    ];

    public static function saveObjectToDB($creditCardTransactionObject){
        $isSaved = false;
        try {
            $isSaved = $creditCardTransactionObject->save();
        }catch (Exception $e){
            Log::error("saveObjectToDB Failed! Exception: ".$e->getMessage());
        }
        if ($isSaved) {
            Log::info("creditCardTransactionObject successfully saved!");
            return $creditCardTransactionObject->id;
        }
        else
            Log::error("creditCardTransactionObject Failed to save!");
        return 0;

    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
