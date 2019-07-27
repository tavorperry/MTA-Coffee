<?php

namespace App\Http\Controllers;

use App\NayaxSaleObject;
use App\NayaxTransactions;
use App\StatusObject;
use App\User;
use App\Wallet;
use GuzzleHttp\Client;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function MongoDB\BSON\toJSON;
use Nexmo\Response;

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

            //log::debug("Validator pass. Starting collect form params.");
            $user_id = auth()->id();
            $machineNumber = $request->get('$machineNumber');
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
            $response = $client->post(env('NAYAX_NOTIFY_URL'), [
                'json' => [
                    'AppUserId' => '123123123123123123123',
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
        $json = $request->json()->all();
        $sale = json_decode(json_encode($json));
        $nayaxTransaction = NayaxTransactions::isTransactionIdExists($sale->TransactionId);
        if ($nayaxTransaction == null){
            Log::warning("Transaction ID unknown. " . $sale->TransactionId);
            $status = new StatusObject("Declined", 2, "Transaction ID unknown","TransactionId is missing");
        }else {
            NayaxTransactions::deleteTransactionFromDB($sale->TransactionId);
            $user = User::getUserById($nayaxTransaction->userId);
            $paymentSucceed = $user->wallet->pay($sale->Amount,"nayaxTransaction: ".$nayaxTransaction->transactionId);
            if ($paymentSucceed){
                $status = new StatusObject("Approved",null,null,"Transaction is Approved");
            }else{
                $status = new StatusObject("Declined", 1, "Insufficient funds", "Insufficient funds");
            }
        }
        $response = [
            "TransactionId" => $sale->TransactionId,
            "Status" => (object) array_filter((array) $status),
        ];
        return json_encode($response);
    }
}
