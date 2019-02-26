<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Validator;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function manualCharge()
    {
        return view('wallet.charge');
    }

    public function charge(Request $request)
    {
        $this->validator($request->all())->validate();


    }

    public function confirmCharge(Request $request)
    {

        $this->validator($request->all())->validate();


        $email = $request->get('email');
        $amount = $request->get('amount');
        $comment = $request->get('comment');

        $user = Auth::user();
        if(true){
            $wallet = $user->wallet();
            $user->wallet->deposit(15000);
            //$wallet->deposit(100);
            dd($user->wallet());

        }


    }

    protected function validator($data)
    {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
                'amount' => ['required', 'integer', 'min:' . env('MINIMUM_AMOUNT_TO_MANUALLY_CHARGE'), 'max:' . env("MAXIMUM_AMOUNT_TO_MANUALLY_CHARGE")],
                'comment' => ['string', 'max:255', 'required'],
                'g-recaptcha-response' => ['required', 'captcha'],
            ]);
        }
}
