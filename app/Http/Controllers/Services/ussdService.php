<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ussdService extends Controller
{
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *  
     **/

    public function ussdScreens(Request $request): Response
    {

        $mobile = $request->input('MSISDN');
        $sessionId = $request->input('SESSIONID');
        $lastInput = $request->input('INPUT');

        $inputArray = explode("*", $lastInput);
        $extensionInput = $inputArray[sizeof($inputArray) - 1];

        Log::channel('ussdLog')->info('USSD LOG', ['PARAMS' => ['mobile' => $mobile, 'sessionId' => $sessionId, 'userInput' => $extensionInput]]);
       
        $ussdScreen = ''; 

        if ($extensionInput === '100') {

            $ussdScreen = "CON Welcome to this USSD test by Harold" .
                "\n1.Continue" .
                "\n2.Exit";
        } else if ($extensionInput === '1') {

            $ussdScreen = "END Hello There, test is a success";
        } else if ($extensionInput === '2') {
            $ussdScreen = "END Sad to see you go, bye friend";
        } else {
            $ussdScreen = "This option has not been implemented friend";
        }

        Log::channel('ussdLog')->info('USSD RESPONSE', ['RESPONSE' => $ussdScreen]);

        return response($ussdScreen)->header('Content-Type', 'text/plain');
    }
}
