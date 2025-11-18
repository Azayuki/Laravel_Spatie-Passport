<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    // functions that retrieve, create, update and delete data
    public function index()
    {
        // to get all data from a table
        // in Eloquent ORM
        // Model::all() | Model::get()
        $users = User::orderBy('id', 'DESC')->get();

        // return response
        return $this->Ok($users, "Users retrieved!");
    }

    public function show($id)
    {
       $user = User::find($id);
       if(!$user){
           return $this->NoDataFound();
       }
       return $this->Ok($user, "User retrieved!");
    }


    public function store(AddUserRequest $request){
        $user = User::create($request->validated());
        return $this->Created($user, "User created!");
    }

    public function update(UpdateUserRequest $request, $id)
    {
       $user = User::find($id);
       if(!$user){
           return $this->NoDataFound();
       }

        $user->update($request->validated());
        return $this->Ok($user, "User updated successfully");
    }

    public function destroy($id)
    {
       $user = User::find($id);
       if(!$user){
           return $this->NoDataFound();
       }
       $user->delete();
       return $this->Ok(null, "User deleted successfully");
    }
}
