<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

/**
 * Class to handle USSD service logic.
 */

class ussdService extends Controller
{

    const WELCOME_OPTION = '100';
    const CONTINUE_OPTION = '1';
    const EXIT_OPTION = '2';

    /**
     * Process USSD screens based on user input.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *  
     **/

    public function ussdScreens(Request $request): Response
    {

        // Params passed in the request

        $mobile = $request->input('MSISDN');
        $sessionId = $request->input('SESSIONID'); //the ussd session Id. Manage this in Redis because redis is best 😎
        $lastInput = $request->input('INPUT'); //I am using a shared USSD so yes the below is necessary

        // Explode splits based on * delimiter into an array. Necessary for a shared USSD
        $inputArray = explode("*", $lastInput);

        //Get the last input. You can use count() or end()

        $extensionInput = $inputArray[sizeof($inputArray) - 1];

        //Logging just for fun in this tutorial
        Log::channel('ussdLog')->info('USSD LOG', ['PARAMS' => ['mobile' => $mobile, 'sessionId' => $sessionId, 'userInput' => $extensionInput]]);


        //Initialize the return response. Yes you can just say $response, I suck at this
        $ussdScreen = '';

        /*conditional stataments are self explanatory. CON to maintain session and END to end the session
        Also, should I use switch?
        */
        if ($extensionInput === self::WELCOME_OPTION) {
            $ussdScreen = "CON Welcome to this USSD test by Harold" .
                "\n1.Continue" .
                "\n2.Exit";
        } else if ($extensionInput === self::CONTINUE_OPTION) {

            $ussdScreen = "END Hello There, test is a success";
        } else if ($extensionInput === self::EXIT_OPTION) {
            $ussdScreen = "END Sad to see you go, bye friend";
        } else {
            $ussdScreen = "This option has not been implemented friend";
        }

        //Again logging for fun. In actual sense, please log when necessary lol!
        Log::channel('ussdLog')->info('USSD RESPONSE', ['RESPONSE' => $ussdScreen]);

        //Finally return the response based on the conditions. Response in my case needs to be text/plain
        return response($ussdScreen)->header('Content-Type', 'text/plain');
    }
}
