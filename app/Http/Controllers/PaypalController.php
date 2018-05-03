<?php

namespace App\Http\Controllers;
use Mailgun\Mailgun;
use App\Invoice;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Mail;

class PayPalController extends Controller
{
    public function makeInvoice(Request $request){
        $Invoice = new Invoice();
        $Invoice->user = auth()->id();
        $Invoice->email = $request->get('email');
        $Invoice->first_name = $request->get('first_name');
        $Invoice->last_name = $request->get('last_name');
        $Invoice->total_payment = $request->get('total_payment');
        $isSucceed = $Invoice->save();

        if ($isSucceed) {
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(20* ($Invoice->total_payment/2)); //The user get 20 Points for each cup
            Alert::success('הרווחת 20 נקודות', 'התשלום בוצע!')->persistent("Close");

            if($user->isLevelUp($prevLevel))
            {
                Alert::success('מזל טוב עלית רמה!','התשלום בוצע! הרווחת 20 נקודות!')->persistent("Close");
            }
            $this->sendEmailWithPaymentApproval($Invoice);
        }

        return response()->json($Invoice->id);
        //return response()->json(['response' => 'true']);
    }

    public function storeValue(Request $request)
    {
        echo $request->get(data);
        alert($request->get(data));
        Alert::success('צבור נקודות וזכה בפרסים! :)', 'המשמרות מעודכנות!')->persistent('Close');
    }

    public function sendEmailWithPaymentApproval($Invoice){
        $user = Auth::user();
        $content = ('Hello '.$user->first_name."! \n"."Thank you for purchasing in  MTA_Coffee! \n Toatl Paid =  ".$Invoice->total_payment. "ILS \n"."Total points: ".$user->points."\n". 'Invoice No.'.$Invoice->id."\n"."Created at: ".$Invoice->created_at);
        Mail::raw(($content), function($message) use ($Invoice) {
            $message->subject('Your Payment Approval to MTA Coffee!');
            $message->to(Auth::user()->email);
            $message->from('mta-coffee@mta.ac.il', $name = 'MTA-Coffee');
        });
    }
}
