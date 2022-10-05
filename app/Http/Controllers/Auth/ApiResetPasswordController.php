<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiResetPasswordController extends Controller
{
    //
    use ResetsPasswords;

     protected function resetPassword($user, $password)
     {
        $user->passsword = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
     }
    
     protected function sendResetResponse(Request $request, $response)
     {
          $response = ['message' => "Password reset successful"];
         return response($response, 200);
     }

      protected function sendResetFailedResponse(Request $request, $response)
     {
       $response = " Token Invalid";
       return response($response, 401);
     }

}
