<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use http\Exception;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    private function chargeCreditCard($amount,$creditCardNumber,$month,$year,$cvv,$comment,$tz){
        log::info("Starting chargeCreditCard()");

        $wsdl = "https://secure.e-c.co.il/Service/Service.asmx?wsdl";
        $client = new \SoapClient($wsdl);

        $postArray = array('ClientID' => env('EasyCard_ClientID'), 'Password' => env('EasyCard_Password'), 'CardNumber' => $creditCardNumber, 'ActionMethod' => '00', 'ValMonth' => $month, 'ValYear' => $year, 'TotalSum' => $amount, 'CVV' => $cvv, 'PayNumber' => '1', 'TZ' => $tz, 'DealType' => '1', 'MType' => '1', 'Opt' => '01', 'Note' => $comment);

        $response = $client->DoDeal($postArray);

        $linesArray = explode("&",$response->DoDealResult);

        log::info("Exit chargeCreditCard()");
        return $linesArray;
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
        $validateData = $request->validate([
            'amount' => ['required', 'integer', 'min:' . env('MINIMUM_AMOUNT_TO_MANUALLY_CHARGE'), 'max:' . env("MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE")],
            'comment' => ['string', 'max:50','nullable'],
            'g-recaptcha-response' => ['required', 'captcha'],
            'creditCardNumber' => ['string','required','max:16','min:16'],
            'month' => ['string','required','max:2','min:2'],
            'year' => ['string','required','max:2','min:2'],
            'cvv' => ['string','required','max:3','min:3'],
            'tz' =>['string','required','max:9', 'min:9'],
        ]);

        try {
            $user = Auth::user();
            //Collect attributes from the form
            $amount = $request->get('amount');
            $creditCardNumber = $request->get('creditCardNumber');
            $month = $request->get('month');
            $year = $request->get('year');
            $cvv = $request->get('cvv');
            $comment = $request->get('comment');
            $tz = $request->get('tz');

            $email = $user->email;

            $response = $this->chargeCreditCard($amount, $creditCardNumber, $month, $year, $cvv, $comment, $tz);
            $newComment = $comment . ". " . $response[7] . ", " . $response[17] . ", " . $response[20];

            if ($response[0] == 'Code=000') {
                if (env('APP_ENV') == 'production' && $response[1] != "CardNumber=0000") //if this is PRODUCTION, do not allow test cards.
                    $user->wallet->deposit($amount, $newComment);
                else if (env('APP_ENV') != 'production' && $response[1] == "CardNumber=0000")
                    $user->wallet->deposit($amount, $newComment);
                else {
                    log::critical("Someone trying to use the test Card!!!! User: " . $email . ". " . $response[1]);
                    return back();
                }
                $newComment = $comment . ". " . substr($response[20], 10, strlen($response[20]));
            } else {
                log::warning("Failed to confirmCreditCardCharge(). newComment: " . $newComment);
            }
            log::info("Exit confirmCreditCardCharge(). Comment: " . $newComment);
            return back()->with(['message' => true, 'comment' => $newComment, 'amount' => $amount, 'email' => $email]);
        }catch (Exception $e){
            log::warning("Failed to confirmCreditCardCharge(). Exception: " .$e->getMessage());
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
