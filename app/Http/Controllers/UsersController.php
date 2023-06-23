<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Connectors\Database\UsersDatabase;
use App\Helpers\ResponseHelper;
use App\Helpers\PayloadHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

/*
Nesta classe utilizamos da classe ResponseHelper para padronizar e compactar as respostas da API
e utilizamos o error handler do php para poder retornar uma resposta mais amigavel de acordo com 
o ResponseHelper em caso de falhas. Utilizamos também uma classe de Connector da database para isolar 
mais a responsabilidade dos models e poder gerar código reaproveitavel e escalonavel. 
Através desta classe, chamamos o método que definimos nela previamente para realizar as ações desejadas.
*/
class UsersController extends Controller{

    public function index(){
        $msg = 'seja bem vindo! meu nome é Lucas e meu github é LucasFrts';
        return ResponseHelper::success([], $msg);
    }
    public function getAll(){
        try{
            $data = (new UsersDatabase)->getAll();
            // verifica se possui registros
            if(count($data) > 0){
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
            // verifica se possui registros
            $data = (new UsersDatabase)->getActive();
            if(count($data) > 0){
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
        // verifica se o parametro id foi passado
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
    public function update(Request $request){
        $id      = $request->id;
        $payload = $request->all();
        // verifica se o parametro id foi passado
        if(isset($id)){
            $payload_helper = PayloadHelper::update($payload);
            if($payload_helper == 200){
                try{
                    $data = (new UsersDatabase)->update($id, $payload);
                    return ResponseHelper::success($data);
                }catch(Exception $e){
                    Log::info("erro: " . $e->getMessage());
                    return ResponseHelper::noContent('Usuário não encontrado!');
                }
            }else if($payload_helper == 422){
                return ResponseHelper::badRequest('O email em questão não esta disponivel!');
            }else{
                return ResponseHelper::badRequest('Payload de alteração invalido!');
            }
        }else{
            return ResponseHelper::badRequest('O parametro ID é obrigatório!');
        }
    }
    public function create(Request $request){
        $id      = $request->id;
        $payload = $request->form;
        // verifica se o parametro id foi passado
        if(isset($id)){
            try{
                $data = (new UsersDatabase)->create($id);
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