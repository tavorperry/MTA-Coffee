<?php

namespace App\Http\Controllers;

use App\CreditCardTransaction;
use App\User;
use App\Wallet;
use http\Exception;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Validator;

class WalletController extends Controller
{
    private function chargeCreditCard($amount,$creditCardNumber,$month,$year,$cvv,$comment,$tz){
        log::info("Starting chargeCreditCard()");
        $creditCardTransactionObject = new CreditCardTransaction();
    try {
        $wsdl = "https://secure.e-c.co.il/Service/Service.asmx?wsdl";
        $client = new \SoapClient($wsdl);

        $postArray = array('ClientID' => env('EasyCard_ClientID'), 'Password' => env('EasyCard_Password'), 'CardNumber' => $creditCardNumber, 'ActionMethod' => '00', 'ValMonth' => $month, 'ValYear' => $year, 'TotalSum' => $amount, 'CVV' => $cvv, 'PayNumber' => '1', 'TZ' => $tz, 'DealType' => '1', 'MType' => '1', 'Opt' => '01', 'Note' => $comment);

        $response = $client->DoDeal($postArray);
        $linesArray = explode("&", $response->DoDealResult);

        foreach($linesArray as $key => $val)
        {
            $keyValArray = explode("=", $val);

            if ($keyValArray [0] == "Code") { $creditCardTransactionObject->Code = $keyValArray[1]; }
            if ($keyValArray [0] == "ErrorDesc") { $creditCardTransactionObject->ErrorDesc = $keyValArray[1]; }
            if ($keyValArray [0] == "DealNumber") { $creditCardTransactionObject->DealNumber = $keyValArray[1]; }
            if ($keyValArray [0] == "AuthNum") { $creditCardTransactionObject->AuthNum = $keyValArray[1]; }
            if ($keyValArray [0] == "ManpikID") { $creditCardTransactionObject->ManpikID = $keyValArray[1]; }
            if ($keyValArray [0] == "CardNumber") { $creditCardTransactionObject->CardNumber = $keyValArray[1]; }
            if ($keyValArray [0] == "PayDate") { $creditCardTransactionObject->PayDate = $keyValArray[1]; }
            if ($keyValArray [0] == "Terminal") { $creditCardTransactionObject->Terminal = $keyValArray[1]; }
            if ($keyValArray [0] == "DealID") { $creditCardTransactionObject->DealID = $keyValArray[1]; }
            if ($keyValArray [0] == "DealType") { $creditCardTransactionObject->DealType = $keyValArray[1]; }
            if ($keyValArray [0] == "DealTypeOut") { $creditCardTransactionObject->DealTypeOut = $keyValArray[1]; }
            if ($keyValArray [0] == "OkNumber") { $creditCardTransactionObject->OkNumber = $keyValArray[1]; }
            if ($keyValArray [0] == "DealDate") { $creditCardTransactionObject->DealDate = $keyValArray[1]; }
            if ($keyValArray [0] == "TotalSum") { $creditCardTransactionObject->TotalSum = $keyValArray[1]; }
            if ($keyValArray [0] == "CardName") { $creditCardTransactionObject->CardName = $keyValArray[1]; }
            if ($keyValArray [0] == "CardNameID") { $creditCardTransactionObject->CardNameID = $keyValArray[1]; }
            if ($keyValArray [0] == "MutagID") { $creditCardTransactionObject->MutagID = $keyValArray[1]; }
        }

    }   catch (Exception $e){
        log::error("Failed to chargeCreditCard!!!"." Exception: ".$e->getMessage());
    }
        log::info("Exit chargeCreditCard()");

        return $creditCardTransactionObject;
    }

    public function manualCharge()
    {
        return view('wallet.charge');
    }

    public function CreditCardCharge()
    {
        return view('wallet.credit_card_charge');
    }

    public function confirmChargeView(){
        return view('wallet.confirm_charge');
    }
    public function charge(Request $request)
    {
        $this->validator($request->all())->validate();
    }

    public function confirmCharge(Request $request)
    {
        $chargerUser = Auth::user();
        if(!Str::contains(env("MANAGMENT_USERS"),$chargerUser->email)) {
            log::warning("### Someone trying to hack the manual charge!!! ".$chargerUser->email);
            Alert::error('אינך מנהל! טעינה נכשלה')->persistent("Close");
            return redirect()->route('index');
        }

        $this->validator($request->all())->validate();
        $amount = $request->get('amount');
        $email = $request->get('email');
        $comment = $request->get('comment');

        $user = User::getUserByEmail($email);
        if(/*$this->testSoap($request)*/true){
            $wallet = $user->wallet();

            $newComment = "Charger: ".$chargerUser->first_name." Comment: ".$comment;
            $user->wallet->deposit($amount, $newComment);
        }
        return view('wallet.confirm_charge', compact('comment','amount', 'email'));
    }

    public function confirmCreditCardCharge(Request $request){
        log::info("Starting confirmCreditCardCharge()");
        $isDepositSucceed = false;
        $validateData = $request->validate([
            'amount' => ['required', 'integer', 'min:' . env('MINIMUM_AMOUNT_TO_MANUALLY_CHARGE'), 'max:' . env("MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE")],
            'comment' => ['string', 'max:50','nullable'],
            'creditCardNumber' => ['string','required','max:16','min:16'],
            'month' => ['string','required','max:2','min:2'],
            'year' => ['string','required','max:2','min:2'],
            'cvv' => ['string','required','max:3','min:3'],
            'tz' =>['string','required','max:9', 'min:9'],
        ]);
        log::debug("Validator Pass. Starting to collect input from form");

        try {
            $user = Auth::user();
            $email = $user->email;
            //Collect attributes from the form
            $amount = $request->get('amount');
            $creditCardNumber = $request->get('creditCardNumber');
            $month = $request->get('month');
            $year = $request->get('year');
            $cvv = $request->get('cvv');
            $comment = $request->get('comment');
            $tz = $request->get('tz');

            //Charge the credit card
            $response = $this->chargeCreditCard($amount, $creditCardNumber, $month, $year, $cvv, $comment, $tz);
            //Save the credit card transaction
            $response->user = $user->id;
            $creditCardTransactionId = CreditCardTransaction::saveObjectToDB($response);

            $commentToSaveInDBAndLogs = "Code: ".$response->Code.". "."CardNumber: ".$response->CardNumber."ErrorDesc: ".$response->ErrorDesc."AuthNum: ".$response->AuthNum.". Comment: ".$comment . ". ";

            if ($response->Code == '000') {
                if (env('APP_ENV') == 'production' && $response->CardNumber != "0000") //if this is PRODUCTION, do not allow test cards.
                    $isDepositSucceed = $user->wallet->deposit($amount, $commentToSaveInDBAndLogs, $creditCardTransactionId);
                else if (env('APP_ENV') != 'production' && $response->CardNumber == "0000")
                    $isDepositSucceed = $user->wallet->deposit($amount, $commentToSaveInDBAndLogs, $creditCardTransactionId);
                else {
                    log::critical("Someone trying to use the test Card!!!! User: " . $email . ". " . $response[1]);
                    return back();
                }
                if ($isDepositSucceed) {
                    log::info("Deposit Succeed! User: " . $email);
                    EmailController::SendChargeConfirmationEmail($user, $response->Code, $comment, $response->ErrorDesc, $amount, $email, $user->wallet->balance());
                }
                else
                    log::error("Deposit Failed! User: ".$email);
            } else {
                log::warning("Failed to charge credit card. commentToSaveInDBAndLogs: " . $commentToSaveInDBAndLogs);
            }

            $currentBalance = $user->wallet->balance();
            log::info("Exit confirmCreditCardCharge(). commentToSaveInDBAndLogs: " . $commentToSaveInDBAndLogs);
            return back()->with(['message' => true, 'Code' => $response->Code, 'isDepositSucceed' =>$isDepositSucceed, 'comment' => $comment, 'ErrorDesc' => $response->ErrorDesc, 'amount' => $amount, 'email' => $email, 'currentBalance' => $currentBalance]);
        }catch (Exception $e){
            log::error("Failed to confirmCreditCardCharge() .Exception: " .$e->getMessage());
            return route('home');
        }
    }

    protected function validator($data)
    {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
                'amount' => ['required', 'integer', 'min:' . env('MINIMUM_AMOUNT_TO_MANUALLY_CHARGE'), 'max:' . env("MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE")],
                'comment' => ['string', 'max:100','nullable'],
                'g-recaptcha-response' => ['required', 'captcha'],
            ]);
    }

    public function getCoffeeView(){
        return view('get_coffee');
    }

    public function getCoffee(Request $request){
        //TODO
    }
}
