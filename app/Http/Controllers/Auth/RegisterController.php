<?php
namespace App\Http\Controllers\Auth;

use App\Rules\ValidEmailMailgun;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Alert;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|ValidEmailMailgun',
            'email' =>  new ValidEmailMailgun,
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        Alert::success('ברוך הבא!', 'את/ה יכול/ה להתחבר כעת')->persistent("Close");

        // $this->registered($request, $user)


        if (env('NOTIFY_XENIA'))
            $this->SendEmailNotification($user, 'aguda@mta.ac.il');
        if(env('NOTIFY_TAVOR'))
            $this->SendEmailNotification($user,'tavorp12@gmail.com');

        return $this->guard()->login($user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'secret_token' => str_random(32),

        ]);
    }

    public function SendEmailNotification($user,$email){
        try {
            Mail::send('emails.notification_when_new_user_registered', ['user' => $user, $email], function ($m) use ($user,$email) {
                $m->from(env('EMAIL_FROM'), 'קפה אמון');
                $m->to($email)->subject("משתמש חדש נרשם למערכת!");
            });
        } catch (\Exception $exception) {
            return report($exception);
        }
    }
}





//End - Sending Email to all users in shift