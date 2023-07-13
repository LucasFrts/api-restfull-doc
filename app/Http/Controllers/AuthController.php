<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Connectors\Database\UsersDatabase;
use App\Schemas\UserCreatePayload;
use App\Schemas\UserUpdatePayload;
use App\Helpers\ResponseHelper;
use App\Helpers\PayloadHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller{

    public function index(Request $request){
        $req        = $request->all();
        $email      = $req["email"];
        $password   = $req["password"];
        $data = array(
            "email" => $email,
            "password" => $password
        );
        $rules = [
          'email' => 'required|email',
          'password' => 'required'
        ];
        $user = User::where('email', $email)->first();
        if(!isset($user->id)){
            return ResponseHelper::badRequest('Email não existente na base de dados.');
        }
        if(Auth::validate($data, $rules)){
            return ResponseHelper::success($user, "Credenciais confirmadas.");
        }
        return ResponseHelper::badRequest('Credenciais incorretas!');

    } 

}