<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
       $user = User::all(); 
       return $this->Success($user);
    }


    public function show($id)
    {
       $user = User::find($id); 
       if(!$user){
           return $this->NotFound("User not found");
       }
       return $this->Success($user);
    }


    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            "username" => "required|alpha_dash|unique:users|min:4|max:64",
            "email" => "required|email|unique:users|max:128",
            "password" => "required|max:32",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }
        
        $user = User::create($validator->validated());
        return $this->Created($user);
    }
    
    public function update(Request $request, $id)
    {
       $user = User::find($id); 
       if(!$user){
           return $this->NotFound("User not found");
       }

       $validator = validator()->make($request->all(), [
            "username" => "sometimes|required|alpha_dash|unique:users,username,$id|min:4|max:64",
            "email" => "sometimes|required|email|unique:users,email,$id|max:128",
            "password" => "sometimes|required|max:32",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $user->update($validator->validated());
        return $this->Success($user, "User updated successfully");
    }

    public function destroy($id)
    {
       $user = User::find($id); 
       if(!$user){
           return $this->NotFound("User not found");
       }
       $user->delete();
       return $this->Success([], "User deleted successfully");
    }
}
