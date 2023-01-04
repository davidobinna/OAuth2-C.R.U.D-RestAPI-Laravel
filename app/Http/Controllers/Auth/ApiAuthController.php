<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    //
    public function register(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'integer'
        ]);
        if ($validator->fails()) {
            # code...
            return response(['errors'=> $validator->errors()->all()], 422);
        }
        $type = $request->get('type') ? $request->get('type') : 0;
        $pass['password'] = Hash::make($request->get('password'));
        //$request['remember_token'] = Str::random(10);
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $pass['password'],
            'type' => intval($type)
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response([
            'user' => $user,
            'user_token' => $token,
        ], 200);
    }

    public function login(Request $request)
    {
        # code...
         $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
         ]);
         if ($validator->fails()) {
            # code...
            return response(['errors'=> $validator->errors()->all()],422);
         }
         $user = User::where('email',$request->email)->first();
               if ($user) {
                # code...
                if (Hash::check($request->password, $user->password)) {
                    # code...
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return response([
                        'user' => $user,
                        'user_token' => $response,
                    ], 200);
                } else {
                    $response = ["message" => "password mismatch"];
                    return response($response, 422);

                }
           } else {

            $response = ["message" =>'User does not exist'];
            return response($response, 422);
           }
    }

    public function logout(Request $request)
    {
        # code...
        $token = $request->user()->token();
        $token->revoke();

        $response = ['message' => 'you have been sucessfully logged out'];
        return response($response,200);

    }

}
