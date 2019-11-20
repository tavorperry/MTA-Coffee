<?php

namespace App\Http\Controllers;

use App\NayaxTransactions;
use App\StatusObject;
use App\User;
use GuzzleHttp\Client;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Wallet;

class MachineController extends Controller
{
    public function view()
    {
        return view('machine.get_coffee');
    }

    public function buyCoffee(Request $request){
        $METHOD_NAME = "buyCoffee";
        log::info("Starting " . $METHOD_NAME . "()");

        try {
            //$this->validator($request->all())->validate();

            //TODO: Validate data??
            //log::debug("Validator pass. Starting collect form params.");
            $user_id = auth()->id();
            $machineNumber = $request->get('machineNumber');
            log::debug("UserID: " . $user_id . " machineNumber: ". $machineNumber);

            //open Machine
            $isSucceed = $this->notifyNayax($machineNumber);
            if ($isSucceed){
                Log::info($METHOD_NAME . " succeed");
            }else{
                Log::error($METHOD_NAME . " failed in post request");
            }
         }catch (Exception $e){
            LOG::error($METHOD_NAME . "Failed. Exception: " . $e->getMessage());
        }
    }

    public function notifyNayax($machineNumber){
        $METHOD_NAME = "notifyNayax";
        log::info("Starting " . $METHOD_NAME . "()");
        $response = null;
        $client = new Client();
        $transactionId = NayaxTransactions::generateTransactionId();
        $terminalId = "";
        if (!strcmp($transactionId, "0")){
            log::error("transactionId == 0");
            return false;
        }
        if ($machineNumber == '1'){
            $terminalId = env('NAYAX_MACHINE1');
        }elseif ($machineNumber == '2'){
            $terminalId = env('NAYAX_MACHINE2');
        }
        try {
            $user = Auth::user();
            $response = $client->post(env('NAYAX_NOTIFY_URL'), [
                'json' => [
                    'AppUserId' => $user->app_user_id,
                    'TransactionId' => $transactionId,
                    'SecretToken' => env('NAYAX_SECRET_TOKEN'),
                    'TerminalId' => $machineNumber
                ]
            ]);

        }catch (\Exception $exception){
            Log::error("notifyNayax() Failed in post request! Exception: " . $exception);
        }
        Log::info("Exit " . $METHOD_NAME);
        return ($response->getStatusCode() == 200);
    }

    protected function getJson($url)
    {
        $response = file_get_contents($url, false);
        return json_decode( $response );
    }

    public function authorization($json){
/*        $amount =
        $transactionId =
        $currencyCode =
        $countryCode =
        $descriptor = */
    }

    public function sale(Request $request){
        Log::info("sale Starting");
        $response = [
            "TransactionId" => "000",
            "Status" => "Error",
        ];
        try{
            Log::debug("sale() request: " . strval($request));
            $json = $request->json()->all();
            $sale = json_decode(json_encode($json));
            if (isset($sale->TransactionId)) {
                $nayaxTransaction = NayaxTransactions::isTransactionIdExists($sale->TransactionId);
                $isTransactionAlreadyUsed = NayaxTransactions::isTransactionIdAlreadyUsed($sale->TransactionId);
                $isTransactionTimestampValid = NayaxTransactions::isTransactionTimestampValid($sale->TransactionId);
            }
            if (empty ($nayaxTransaction)){
                if (isset($sale->TransactionId)) {
                    Log::warning("Transaction ID unknown. ID: " . $sale->TransactionId);
                    $status = new StatusObject("Declined", 2, "Transaction ID unknown", "TransactionId is missing");
                }else{
                    Log::warning("Transaction ID is missing in JSON request");
                    $status = new StatusObject("Declined", 10, "Missing mandatory parameters","Missing mandatory parameters" );
                    $sale->TransactionId = "Missing";
                }
            }else if (isset($isTransactionAlreadyUsed) && $isTransactionAlreadyUsed){
                $status = new StatusObject("Declined", 5, "Suspected Fraud", "Transaction Already Used! ID: " . $sale->TransactionId);
                Log::warning("Transaction Already Used! ID: " . $sale->TransactionId);
            }else if (!isset($isTransactionTimestampValid)){
                $status = new StatusObject("Declined", 6, "General system failure", "Timestamp cannot be reached");
            }else if (!$isTransactionTimestampValid){
                $status = new StatusObject("Declined", 5, "Suspected Fraud", "Timestamp is bigger than allowed timeout: " . $sale->TransactionId);
            }else{
                $isMarkedAsUsed = NayaxTransactions::markTransactionAsUsedOnDB($sale->TransactionId);
                if ($isMarkedAsUsed) {
                    $user = User::getUserById($nayaxTransaction->userId);
                    $isAmountUpdatedOnTransactionRecord = NayaxTransactions::updateAmountOnRecord($sale->TransactionId, $sale->Amount);
                    if (!$isAmountUpdatedOnTransactionRecord){
                        $status = new StatusObject("Declined", 6, "General system failure", "Cannot save amount on transaction");
                        Log::error("updateAmountOnRecord Failed => sale() is stopping now! Sale Request: " . strval($request));
                    }else {
                        $paymentSucceed = $user->wallet->pay($sale->Amount, "nayaxTransaction: " . $nayaxTransaction->transactionId);
                    }
                    if ($paymentSucceed) {
                        $status = new StatusObject("Approved", null, null, "Transaction is Approved");
                    } else {
                        $status = new StatusObject("Declined", 1, "Insufficient funds", "Insufficient funds");
                        Log::error("paymentSucceed Failed => sale() is stopping now! Sale Request: " . strval($request));
                    }
                }else{
                    $status = new StatusObject("Declined", 6, "General system failure", "General system failure");
                    Log::error("isMarkedAsUsed false => that means the record failed to save as used in DB so sale() is stopping now! Sale Request: " . strval($request));
                }
            }
            $response = [
                "TransactionId" => $sale->TransactionId,
                "Status" => (object) array_filter((array) $status),
            ];
        }catch (Exception $e){
            Log::error("sale() Failed! Exception: ".$e->getMessage());
        }
        return json_encode($response);
    }

    public function saleEndNotification(Request $request){
        Log::info("saleEndNotification Starting");
        $response = [
            "TransactionId" => "0",
            "Status" => "Declined",
        ];
        try{
            Log::debug("saleEndNotification request: " . strval($request));
            $json = $request->json()->all();
            $sale = json_decode(json_encode($json));
            if (isset($sale->TransactionId)) {
                $response = [
                    "TransactionId" => $sale->TransactionId,
                    "Status" => "Approved",
                ];
            }
        }catch (Exception $e){
            Log::error("saleEndNotification() Failed! Exception: ".$e->getMessage());
        }
        return($response);
    }

    public function refund(Request $request){
        $METHOD_NAME = "refund()";
        $response = null;
        Log::info($METHOD_NAME . " Starting");
        $status = new StatusObject("Declined", 6, "General system failure", "General system failure");
        $isRefundSucceed = false;
        $stopFunction = false;
        try{
            Log::debug($METHOD_NAME . " request: " . strval($request));
            $json = $request->json()->all();
            $refund = json_decode(json_encode($json));

            if (!isset($refund->TransactionId) || !isset($refund->ReasonCode) || !isset($refund->ReasonText)){
                $status = new StatusObject("Declined", 10, "Missing mandatory parameters", "Missing mandatory parameters");
                Log::error("operation Failed. Returning status with error code 10. Missing mandatory parameters!");
                $stopFunction = true;
            }
            if (!$stopFunction && isset($refund->TransactionId)){
                $transaction = NayaxTransactions::isTransactionIdExists($refund->TransactionId);
                if (!isset($transaction)) {
                    $status = new StatusObject("Declined", 2, "Transaction ID unknown", "Transaction ID unknown");
                    Log::error("operation Failed. Returning status with error code 2. transaction ID unknown");
                    $stopFunction = true;
                }else{
                    $user = User::getUserById($transaction->userId);
                }
            }
            if (!$stopFunction && isset($refund->RefundAmount)){
                if ($transaction->refunded){
                    $status = new StatusObject("Declined", 11, "Transaction is already refunded", "Transaction is already refunded");
                    Log::error("operation Failed. Returning status with error code 1. Transaction is already refunded");
                    $stopFunction = true;
                }else {
                    $isRefundSucceed = $user->wallet->refund($refund->RefundAmount, "TransactionId: " . $refund->TransactionId);
                }
            }else if (!$stopFunction) {
                if ($transaction->refunded) {
                    $status = new StatusObject("Declined", 11, "Transaction is already refunded", "Transaction is already refunded");
                    Log::error("operation Failed. Returning status with error code 1. Transaction is already refunded");
                    $stopFunction = true;
                } else {
                    $transactionAmount = $transaction->amount;
                    $isRefundSucceed = $user->wallet->refund($transactionAmount, "TransactionId: " . $refund->TransactionId);
                }
            }

            if (!$stopFunction && $isRefundSucceed){
                Log::info("refund succeed!");
                NayaxTransactions::markTransactionAsRefundedOnDB($refund->TransactionId);
                $status = new StatusObject("Approved", null, null, "Refund Approved");
            }

            $response = [
                "TransactionId" => $refund->TransactionId,
                "Status" => (object) array_filter((array) $status),
            ];
        }catch (Exception $e){
            Log::error($METHOD_NAME . " Failed! Exception: ".$e->getMessage());
        }
        return($response);
    }

}
