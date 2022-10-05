<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ApiForgetPasswordController extends Controller
{
    //
    use SendsPasswordResetEmails;
  
    protected function sendResetLinkResponse(Request $request, $response)
    {
        $response = ['message' => "password reset email sent"];
        return response($response, 200);
    }
   
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $response = "Email could not be sent to this email address";

        return response($response, 500);
    }

}
