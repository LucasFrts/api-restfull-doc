<?php

namespace App\Connectors\Database;
use App\Models\User;
class UsersDatabase
{

    public function get($id){
        $user = User::findOrFail($id);
        return $user;
    }
    public function getAll(){
        $users = User::all();
        return $user;
    }
    public function getActive(){
        $users = User::where('active', '1')->get();
        return $users;
    }

}