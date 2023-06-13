<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
    // Verifies web token
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

        $cellphone="Cellphone:";
        $message="Message:";

        return view('wpProvisorio', compact('cellphone', 'message')); 
    }
    // Saves client info
    public function save_client_info(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'client_name' => 'required',
            'client_cellphone' => 'required',
            'terms' => 'accepted',
        ]);
                
        $survey = new Survey;
        $survey->user_id = $data['user_id'];
        $survey->client_name = $data['client_name'];
        $survey->client_cellphone = $data['client_cellphone'];
    
        // Check if the second checkbox is checked
        if ($request->has('agree')) {
            // Save the client information
            $survey->save();
        }

        $user_id = $data['user_id'];

        return redirect()->route('homeprofesional', ['id' => $user_id, 'info' => true]);
    }
    // TODO: Gets responses
    public function handleResponse()
    {
        $response = file_get_contents("php://input");
        if ($response == null) {
            exit;
        }

        $response = json_decode($response, true);
        $cellphone="Cellphone:".$response['entry'][0]['changes'][0]['value']['messages'][0]['from']."\n";
        $message="Message:".$response['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];

        return view('wpProvisorio', compact('cellphone', 'message')); 
    }
}
