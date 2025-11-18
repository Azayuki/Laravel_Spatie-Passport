<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        // auth()->attempt() -> this will try to find the username and password in the database if it exists
        // auth()->attempt() will compare the plain text password to the hashed password
        // auth()->attempt() will "login" the user in the laravel cache
        if(!auth()->attempt($request->validated())){
            return $this->Error("Incorrect username and/or password");
        }

        // auth()->user() this gets the info needed to the user/system that is inside the laravel cache
        $user = auth()->user();
        // ->createToken() will create a token for the logged in user
        $token = $user->createToken('login')->accessToken;
        $user->token = $token;
        return $this->Ok($user, "Login Success!");

    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return $this->Ok([], "Logged out successfully!");
    }

    public function checkToken(Request $request){
        $user = $request->user();
        return $this->Ok($user, "User retrieved!");
    }

    public function revokeToken(Request $request){
        $request->user()->token()->revoke();
        return $this->Ok("Token has been revoked!");
    }
}
