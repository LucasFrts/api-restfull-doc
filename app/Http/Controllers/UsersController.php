<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Connectors\Database\UsersDatabase;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UsersController extends Controller{

    public function index(){
        $msg = 'seja bem vindo! meu nome é Lucas e meu github é LucasFrts';
        return ResponseHelper::success([], $msg);
    }
    public function getAll(){
        try{
            $data = (new UsersDatabase)->getAll();
            if(count($data > 0)){
                return ResponseHelper::success($data);
            }
            return ResponseHelper::noContent();
        }
        catch(Exception $e){
            Log::info("erro: " . $e->getMessage());
            return ResponseHelper::serverError('Um erro inesperado ocorreu!');
        }
    }
    public function getActive(){
        try{
            $data = (new UsersDatabase)->getActive();
            if(count($data > 0)){
                return ResponseHelper::success($data);
            }
            return ResponseHelper::noContent();
        }
        catch(Exception $e){
            Log::info("erro: " . $e->getMessage());
            return ResponseHelper::serverError('Um erro inesperado ocorreu!');
        }
    }
    public function get(Request $request){
        $id = $request->id;
        if(isset($id)){
            try{
                $data = (new UsersDatabase)->get($id);
                return ResponseHelper::success($data);
            }catch(Exception $e){
                Log::info("erro: " . $e->getMessage());
                return ResponseHelper::noContent('Usuário não encontrado!');
            }

        }else{
            return ResponseHelper::badRequest('O parametro ID é obrigatório!');
        }
    }

}