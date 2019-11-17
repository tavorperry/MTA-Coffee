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

class MachineController extends Controller
{
    public function view()
    {
        return view('machine.get_coffee');
    }

    public function buyCoffee(Request $request){
        log::info("Starting buyCoffee()");

        try {
            //$this->validator($request->all())->validate();

            //TODO: Validate data??
            //log::debug("Validator pass. Starting collect form params.");
            $user_id = auth()->id();
            $machineNumber = $request->get('machineNumber');
            log::debug("UserID: " . $user_id . " machineNumber: ". $machineNumber);

            //open Machine
            $isSucceed = $this->openMachine($machineNumber);
            if ($isSucceed){
                Log::info("buyCoffee succeed");
            }else{
                Log::error("buyCoffee failed in post request");
            }
         }catch (Exception $e){
            LOG::error("buyCoffee failed. Exception: " . $e->getMessage());
        }
    }

    public function openMachine($machineNumber){
        $response = null;
        $client = new Client();
        $transactionId = NayaxTransactions::generateTransactionId();
        if (!strcmp($transactionId, "0")){
            log::error("transactionId == 0");
            return false;
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
            Log::error("openMachine() Failed in post request! Exception: " . $exception);
        }
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
            }
            if (isset($isTransactionAlreadyUsed) && $isTransactionAlreadyUsed){
                $status = new StatusObject("Declined", 5, "Suspected Fraud", "Transaction Already Used! ID: " . $sale->TransactionId);
                Log::warning("Transaction Already Used! ID: " . $sale->TransactionId);
                }
            else if (empty ($nayaxTransaction)){
                if (isset($sale->TransactionId)) {
                    Log::warning("Transaction ID unknown. ID: " . $sale->TransactionId);
                    $status = new StatusObject("Declined", 2, "Transaction ID unknown", "TransactionId is missing");
                }else{
                    Log::warning("Transaction ID is missing in JSON request");
                    $status = new StatusObject("Declined", 10, "Missing mandatory parameters","Missing mandatory parameters" );
                    $sale->TransactionId = "Missing";
                }
            }else {
                $isMarkedAsUsed = NayaxTransactions::markTransactionAsUsedOnDB($sale->TransactionId);
                if ($isMarkedAsUsed) {
                    $user = User::getUserById($nayaxTransaction->userId);
                    $paymentSucceed = $user->wallet->pay($sale->Amount, "nayaxTransaction: " . $nayaxTransaction->transactionId);
                    if ($paymentSucceed) {
                        $status = new StatusObject("Approved", null, null, "Transaction is Approved");
                    } else {
                        $status = new StatusObject("Declined", 1, "Insufficient funds", "Insufficient funds");
                        Log::error("isMarkedAsUsed is FALSE so sale() is stopping now! Sale Request: " . strval($request));
                    }
                }else{
                    $status = new StatusObject("Declined", 6, "General system failure", "General system failure");
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
}
