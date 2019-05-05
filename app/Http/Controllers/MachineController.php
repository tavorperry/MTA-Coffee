<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

            log::debug("Validator pass. Starting collect form params.");
            $user_id = auth()->id();
            $machineNumber = $request->get('$machineNumber');
            log::debug("UserID: " . $user_id, "machineNumber: ". $machineNumber);

            //open Machine
            $isSuccees = $this->openMachine($user_id,$machineNumber);



         }catch (Exception $e){}

    }

    public function openMachine($user_id, $machineNumber){
        $client = new Client();
        $url = 'https://qa2-lynx.nayax.com/Payment/v1/Cortina/[PaymentMethodName]/start';
        $response = $client->post('https://qa2-lynx.nayax.com/Payment/v1/Cortina/[PaymentMethodName]/start', [
            'json' => [
                'AppUserId' => '123123123123123123123',
                'TransactionId' => '123456789',
                'SecretToken' => '1234567890123445o8o438y12472163782136128732168736123123wefjh',
                'TerminalId' => '12314567876543213456'
            ]
        ]);

        dd($response->getBody()->getContents());

        return $response;
    }

    protected function getJson($url)
    {
        $response = file_get_contents($url, false);
        return json_decode( $response );
    }



}
