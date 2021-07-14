<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class PassportAuthController extends BaseController
{
    public function register(UserRequest $request)
    {
        try {
            $user = User::create($request->all());
            $token = $user->createToken('UserPassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } catch(\Exception $e){
            return $this->systemErrors($e);
        }
    }
  
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
  
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('UserPassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
 
    public function userInfo() 
    {
     $user = auth()->user();
     return response()->json(['user' => $user], 200);
    }
}
