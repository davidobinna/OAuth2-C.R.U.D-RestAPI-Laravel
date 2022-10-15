<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiForgetPasswordRequest;
use App\Http\Requests\ApiResetRequest;
use App\Mail\ApiForgetpasswordMail;
use App\Mail\AttachmentMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApiForgetpasswordContrloller extends Controller
{
    //
    
    
    public function forgot(ApiForgetPasswordRequest $request)
    {
        $email = $request->get('email');
        $user_exist = User::where('email','=', $email)->exists();
        if (!$user_exist) {
            # code...
            return response([
                 'message'=>'User doesn\'t exists:',
            ], 404);
        } 
        
        $token = Str::random(10);


        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);
             // send an email
             $data = [
                'subject' => 'please reset your password',
                'email' => $email,
                'token' => $token
             ];

             Mail::to($email)->send(new ApiForgetpasswordMail($data));  

             return response([
                'meassage' => 'Password reset link has been sent to your email addresss'
             ]);

           //  Mail::to('michealat@gmail.com')->send(new AttachmentMail());
           //  return new AttachmentMail();

        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'meassge' => $th->getMessage(),
                
            ], 400);
        }
    }
    /** @var User $user */
    public function reset(ApiResetRequest $request)
    {
         $token = $request->get('token');
         
         if (!$passwordreset = DB::table('password_resets')->where('token',$token)->first()) {
            # code...
            return response([
                'messages' => 'invalid token',
            ], 400);
         }
         if (!$user = User::where('email',$passwordreset->email)->first()) {
            # code...
               return response([
                'message' => 'User does not exit',
            
               ], 404);
         }
       $user->password = Hash::make($request->get('password'));
       $user->save();

       return response([
        'message' => 'password updated successfully'
       ], 200);
   }
}
