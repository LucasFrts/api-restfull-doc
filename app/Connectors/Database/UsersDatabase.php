<?php

namespace App\Connectors\Database;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class UsersDatabase
{
    // busca um unico registro pelo id e lança um erro caso não encontre
    public function get($id){
        $user = User::findOrFail($id);
        return $user;
    }
    // realiza a busca de todos os registros
    public function getAll(){
        $users = User::all();
        return $users;
    }
    // realiza a busca por todos os registros que estejam ativos
    public function getActive(){
        $users = User::where('active', 1)->get();
        return $users;
    }
    // realiza a criação de um novo user. campos requeridos estão sendo validados no ValidateUsersData
    public function create($payload){
        $user = new User();
        $user->name     = $payload['name'];
        $user->email    = $payload['email'];
        $user->password = Hash::make($payload['password']);
        $user->celular  = $payload['celular'];
        $user->sexo     = $payload['sexo'];
        $user->data_nascimento = $payload['data_nascimento'];
        $user->avatar   = $payload['avatar'] ?? 'upload/avatar.jpg';
        $user->save();
        return $user;
    }
    // realiza o update dos campos passados
    public function update($id, $payload){
        Log::info("nem cheguei aqui");
        $user = User::findOrFail($id);
        isset($payload['name'])     ? $user->name    = $payload['name']    : null;
        isset($payload['email'])    ? $user->email   = $payload['email']   : null;
        isset($payload['celular'])  ? $user->celular = $payload['celular'] : null;
        isset($payload['sexo'])     ? $user->sexo    = $payload['sexo']    : null;
        isset($payload['active'])   ? $user->active  = $payload['active']  : null;
        isset($payload['avatar'])   ? $user->avatar  = $payload['avatar']  : null;
        $user->save();
        return $user;
    }
    // realiza a exclusão de um registro
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
    // realiza a busca de um usario pelo seu email unico
    public function getByEmail($email){
        Log::info("email" . $email);
        $user = User::where('email',$email)->first();
        return $user;
    }

}