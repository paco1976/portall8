<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Token verification
        $token = 'cfpereswpwebhook';
        $hubChallenge = $request->input('hub_challenge');
        $hubVerifyToken = $request->input('hub_verify_token');
        if ($token === $hubVerifyToken) {
            echo $hubChallenge;
            exit;
        }
    }
    public function handleResponse()
    {
        $response = file_get_contents("php://input");
        if($response==null){
          exit;
        }
        
        echo $response;

        // $response = json_decode($response, true);
        // $surveyResponse="Cellphone:".$response['entry'][0]['changes'][0]['value']['messages'][0]['from']."\n";
        // $surveyResponse.="Message:".$response['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
    }
}