<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Support\ApiResponse;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __invoke(LoginRequest $request){

        $user = Auth::guard()->attempt(['email' => $request->email, 'password' => $request->password]);
        if(!$user){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard()->user();

        $token = $user->createToken('api-token')->plainTextToken;

        $user->token = $token;
        return ApiResponse::success($user);
    }

}