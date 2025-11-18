<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = validator()->make($request->all(), [
            "username" => "required",
            "password" => "required",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        if(!Auth::attempt($validator->validated())){
            return $this->Unauthorized("Invalid credentials!");
        };

        $user = auth()->user();

        $user->token = $user->createToken("api-token")->accessToken;

        return $this->Success($user, "Logged in!");
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return $this->Success([], "Logged out successfully!");
    }
}
