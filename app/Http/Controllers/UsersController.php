<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller{

    public function index(Request $request){
        $teste = [
            "funcionando" => true,
            "message" => "Da"
        ];
        return response()->json($teste);
    }
}