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
    public function __construct(){
        $this->middleware('auth');
    }

    public function makeInvoice(Request $request){
        $Invoice = new Invoice();
        $Invoice->user = auth()->id();
        $Invoice->email = $request->get('email');
        $Invoice->first_name = $request->get('first_name');
        $Invoice->last_name = $request->get('last_name');
        $Invoice->total_payment = $request->get('total_payment');
        $Invoice->coffee_or_card = $request->get('coffee_or_card');
        $Invoice->havecard = $request->get('havecard');
        $isSucceed = $Invoice->save();

        if ($isSucceed)
        {
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(20* ($Invoice->total_payment/2)); //The user get 20 Points for each cup
            Alert::success('הרווחת נקודות', 'התשלום בוצע!')->persistent("Close");

            if($user->isLevelUp($prevLevel))
            {
                Alert::success('מזל טוב עלית רמה!','התשלום בוצע! הרווחת נקודות!')->persistent("Close");
            }
            $this->sendEmailWithPaymentApproval($Invoice);
        }
        return response()->json($Invoice->id);
    }

    public function sendEmailWithPaymentApproval($Invoice){
        $user = Auth::user();

        //Start - Sending Email to Customer
        Mail::send('emails.customer_payment_approval', ['user' => $user, 'Invoice' => $Invoice], function ($m) use ($user) {
            $m->from('mta-coffee@mta.ac.il', 'אגודת הסטודנטים והסטודנטיות');
            $m->to($user->email, $user->first_name)->subject('מייל ליוזר - תודה שקנית בקפה אמון!');
        });
        //End - Sending Email to Customer

        //Start - Sending Email to MTA-Coffee Manager
        Mail::send('emails.internal_payment_approval', ['user' => $user, 'Invoice' => $Invoice], function ($m) use ($user) {
            $m->from('mta-coffee@mta.ac.il', 'קפה אמון');
            $m->to($user->email, $user->first_name)->subject('מייל למנהל קפה אמון - רכישה חדשה בקפה אמון!');
        });
        //End - Sending Email to MTA-Coffee Manager

        //This email is for the Front-Desk manager in the Aguda:
        //Start - Sending Email to Aguda to charge Card
        if($Invoice->coffee_or_card == "Card") {
            Mail::send('emails.internal_payment_approval', ['user' => $user, 'Invoice' => $Invoice], function ($m) use ($user) {
                $m->from('mta-coffee@mta.ac.il', 'קפה אמון');
                $m->to($user->email, $user->first_name)->subject('מייל למנהלת המשרד באגודה - הטענת כרטיס!');
            });
            //End - Sending Email to Aguda
        }
    }
}
