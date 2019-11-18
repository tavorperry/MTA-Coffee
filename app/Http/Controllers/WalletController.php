<?php

namespace App\Http\Controllers;

use App\CreditCardTransaction;
use App\NayaxTransactions;
use App\TranzilaTransaction;
use App\User;
use App\Wallet;
use GuzzleHttp\Client;
use http\Env\Response;
use http\Exception;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function MongoDB\BSON\toJSON;
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
        $chargerUser = Auth::user();
        if(!Str::contains(env("MANAGMENT_USERS"),$chargerUser->email)) {
            log::warning("### Someone trying to enter the manual charge!!! ".$chargerUser->email);
            Alert::error('אינך מנהל! ')->persistent("Close");
            return redirect()->route('index');
        }
        return view('wallet.charge');
    }

    public function CreditCardCharge()
    {
        if (env("IS_CREDIT_CARD_CHARGE_ACTIVATE"))
            return view('wallet.credit_card_charge');
        else{
            log::warning("Someone trying to enter creditCardCharge view");
            Alert::error('השירות עדיין לא פעיל ויופעל בקרוב! :)')->persistent("Close");
            return redirect()->route('index');
        }
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
        log::info("Starting confirmCharge()");
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
        $newComment = "ENV: ".env('APP_ENV')." Manual Charger: ".$chargerUser->first_name." Comment: ".$comment;
try{
    $isDepositSucceed = $user->wallet->deposit($amount, $newComment);

    if ($isDepositSucceed) {
        log::info("Manual Deposit Succeed! To user: " . $email);
        EmailController::SendChargeConfirmationEmail($user, 'Manual Deposit', $newComment, 'Manual Deposit', $amount, $email, $user->wallet->balance());
    }
    else
        log::error("Deposit Failed! User: ".$email);

    $currentBalance = $user->wallet->balance();
    log::info("Exit confirmCharge()");
    return back()->with(['message' => true, 'Code' => "Manual Charge", 'isDepositSucceed' =>$isDepositSucceed, 'comment' => $comment, 'ErrorDesc' => 'Manual Deposit', 'amount' => $amount, 'email' => $email, 'currentBalance' => $currentBalance]);
}catch (Exception $e){
    log::error("Failed to confirmCharge() .Exception: " .$e->getMessage());
    return route('home');
}
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

    public function chargeWithTranzila(Request $request){
        $amount = $request->get('amount');
        $thtk = $this->getThtkToken($request);
        $tranzila_transaction = new TranzilaTransaction();
        $tranzila_transaction->sum = $amount;
        $tranzila_transaction->thtk = $thtk;
        $tranzila_transaction->user = auth()->id();
        $tranzila_transaction->used = false;
        TranzilaTransaction::saveObjectToDB($tranzila_transaction);

        if ($amount < 10 || $amount > 100){
            return view('wallet.credit_card_charge_iframe')->with(['error' => true]);
        }
        return view('wallet.credit_card_charge_iframe')->with(compact("tranzila_transaction"));
    }

    public function confirmChargeWithTranzila(){
        Log::info("Starting confirmChargeWithTranzila()");
        try {
            $thtk = $_POST['thtk'];
            $sum = $_POST['sum'];
            $ccno = $_POST['ccno'];
            $tranzila_transaction = TranzilaTransaction::getTranzilaTransactionByThtk($thtk);
            if ($this->validateThtkToken($sum, $thtk, $tranzila_transaction)) {
                Log::info("Thtk Token validated. thtk: ".$thtk);
            } else {
                Log::warning("Thtk Validation Failed!");
                return;
            }

            $tranzila_transaction->ccno = $ccno;
            TranzilaTransaction::saveObjectToDB($tranzila_transaction);
            $user = auth::user();

            $deposit_succeed = $user->wallet->deposit($sum, "thtk " . $thtk);
            if (!$deposit_succeed) {
                Log::error("Deposit Failed!!! We need to manually check that was charge from credit card and refund the user: " . $user . ".for Amount: ." . $sum);
                Log::error("tranzila_transaction: " . $tranzila_transaction);
                return view('wallet.deposit_failed', compact('deposit_succeed', 'sum'));
            }else{
                Log::debug("end of confirmChargeWithTranzila(). Forwarding user to view. User: ". $user->id);
                return view('wallet.deposit_succeed', compact('deposit_succeed', 'sum'));
            }

        }catch (\Exception $exception){
            Log::error("Failed to execute confirmChargeWithTranzila(). Exception: ". $exception);
        }
    }

    public function chargeFailedWithTranzila(){
        Log::info("Starting chargeFailedWithTranzila()");
        try{
        $thtk = $_POST['thtk'];
        $sum = $_POST['sum'];
        $ccno = $_POST['ccno'];
        $tranzila_transaction = TranzilaTransaction::getTranzilaTransactionByThtk($thtk);
        if ($this->validateThtkToken($sum, $thtk, $tranzila_transaction)) {
            Log::info("Thtk Token validated. thtk: ".$thtk);
        } else {
            Log::warning("Thtk Validation Failed!");
            return;
        }

        $tranzila_transaction->ccno = $ccno;
        TranzilaTransaction::saveObjectToDB($tranzila_transaction);
    }catch (\Exception $exception) {
            Log::error("Failed to execute confirmChargeWithTranzila(). Exception: " . $exception);
        }
        return view('wallet.deposit_failed_from_tranzila');
    }

    public function getThtkToken($request){
        $sum = $request->get('amount');
        $response = null;
        $client = new Client();
        $order_id = NayaxTransactions::generateTransactionId();

        if (!strcmp($order_id, "0")){
            log::error("order_id == 0");
            return false;
        }
        $form_params = [
            'sum' => "".$sum."",
            'supplier' => 'test',
            'op' => '1',
            'TranzilaPW' => env('TRANZILA_PW')
        ];

        try {
            $response = $client->post(env('TRANZILA_HANDSHAKE_URL'), [
                'form_params' => $form_params
            ]);

        }catch (\Exception $exception){
            Log::error("getThtkToken() Failed in post request! Exception: " . $exception);
        }
        return substr($response->getBody()->getContents(),5);
    }

    public function validateThtkToken($sum, $thtk, $tranzila_transaction){
        if (!empty($tranzila_transaction) && !empty($tranzila_transaction->sum) && !empty($tranzila_transaction->thtk) && !empty($thtk) && !empty($sum)) {
            if ($tranzila_transaction->sum == $sum && strcasecmp($tranzila_transaction->thtk, $thtk) == 0) {
                Log::debug("sum and thtk validated. Validating if used");
                if ($tranzila_transaction->used == false) {
                    $tranzila_transaction->used = true;
                    if (TranzilaTransaction::saveObjectToDB($tranzila_transaction)) {
                        Log::info("Tranzila Transaction saved as used!");
                        return true;
                    } else {
                        Log::error("Tranzila transaction cant be saved as used!");
                    }
                }else{
                    Log::emergency("Thtk already used! thtk: ". $thtk);
                }
            }
        }
        return false;
    }
}