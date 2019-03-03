<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Str;
use soapclient;
use Validator;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    private function testSoap($cardnumber){

        //get request params
        $wsdl = "https://secure.e-c.co.il/Service/Service.asmx?wsdl";
        $client = new soapclient($wsdl);

        $postArray = array('ClientID' => '9667', 'Password' => 'test1234', 'Cardnumber' => '4580012312312312,','ActionMethod'=>'00', 'ValMonth' => '11', 'ValYear' => '24', 'TotalSum' => '1', 'PayNumber' => '1', 'TZ' => '302928222', 'DealType' => '1', 'MType' => '1', 'Opt' => '01', 'Note' => 'Tets Note - Tavor');

        $response = $client->DoDeal($postArray);

        $linesArray = explode("&",$response->DoDealResult);
        dd($linesArray);
$res = null;
        foreach($linesArray as $res => $val)
        {
            $keyValArray = explode("=", $val);

            if ($keyValArray [0] == "Code") { $code = $res[1]; }
            if ($keyValArray [0] == "ErrorDesc") { $error = $res[1]; }
            if ($keyValArray [0] == "DealNumber") { $deal = $res[1]; }
            if ($keyValArray [0] == "AuthNum") { $auth = $res[1]; }
        }

dd($res);


    }
    public function manualCharge()
    {
        return view('wallet.charge');
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
        if(!Str::contains(env("AUTHORIZED_USERS_TO_MANUALLY_CHARGE"),$chargerUser->email))
            return redirect()->route('index');

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
        return view('wallet.confirm_charge');


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

        //Helpers

}
