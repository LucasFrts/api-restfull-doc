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
use Exception;

/*
Nesta classe utilizamos da classe ResponseHelper para padronizar e compactar as respostas da API
e utilizamos o error handler do php para poder retornar uma resposta mais amigavel de acordo com 
o ResponseHelper em caso de falhas. Utilizamos também uma classe de Connector da database para isolar 
mais a responsabilidade dos models e poder gerar código reaproveitavel e escalonavel. 
Através desta classe, chamamos o método que definimos nela previamente para realizar as ações desejadas.
*/
class UsersController extends Controller{

    /**
    * @OA\Get(
    *     tags={"/bem-vindo"},
    *     path="/api/bem-vindo",
    *     summary="Exibe uma mensagem de boas-vindas",
    *     security={{"jwt": {}}},        
    *     @OA\Response(
    *         response=200,
    *         description="Mensagem de boas vindas exibida com sucesso!",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Welcome message"),
    *         )
    *     )
    * )
    */
    public function index(){
        $msg = 'Seja bem vindo! meu nome é Lucas e meu github é LucasFrts';
        return ResponseHelper::success([], $msg);
    }
    /**
    * @OA\Get(
    *     tags={"/user"},
    *     path="/api/user/get-all",
    *     summary="Obtém todos os usuários",
    *     security={{"jwt": {}}},
    *     @OA\Response(
    *         response=200,
    *         description="Busca por todos os usuários realizada com sucesso!",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Success"),
    *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Não encontrou usuários"
    *     )
    * )
    */
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
    /**
    * @OA\Get(
    *     tags={"/user"},
    *     path="/api/user/get-active",
    *     summary="Obtém os usuários ativos",
    *     security={{"jwt": {}}},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de todos os usuários ativos realizada com sucesso",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Success"),
    *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Nenhum usuário ativo encontrado"
    *     )
    * )
    */
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
    /**
    * @OA\Get(
    *     tags={"/user"},
    *     path="/api/user/{id}",
    *     summary="Obtém um usuário pelo ID",
    *     security={{"jwt": {}}},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID do usuário",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Usuário obtido com sucesso!",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Success"),
    *             @OA\Property(property="data", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Usuário não encontrado"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Parâmetro ID é obrigatório"
    *     )
    * )
    */
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
    /**
    * @OA\Post(
    *     tags={"/user"},
    *     path="/api/user",
    *     summary="Cria um novo usuário",
    *     security={{"jwt": {}}},
    *     @OA\RequestBody(
    *         description="Dados do usuário",
    *         required=true,
    *         @OA\JsonContent(ref="#/components/schemas/UserCreatePayload")
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Usuário criado com sucesso",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Usuario criado com sucesso!"),
    *             @OA\Property(property="data", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="O email escolhido já possui cadastro"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Ocorreu um erro não identificado"
    *     )
    * )
    */
    public function create(Request $request){
        $payload = $request->all();
        // verifica se o parametro id foi passado
        try{
            $payload_helper = PayloadHelper::email($payload);
            if($payload_helper == 200){
                $data = (new UsersDatabase)->create($payload);
                return ResponseHelper::created($data, 'Usuario criado com sucesso!');
            }else{
                return ResponseHelper::badRequest('O email em questão já possui cadastro!');
            }
        }catch(Exception $e){
            Log::info("erro: " . $e->getMessage());
            return ResponseHelper::serverError('Ocorrreu um erro não indentificado!');
        }

    }
    /**
    * @OA\Put(
    *     tags={"/user"},
    *     path="/api/user/{id}",
    *     summary="Atualiza um usuário",
    *     security={{"jwt": {}}},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(ref="#/components/schemas/UserUpdatePayload")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Success"),
    *             @OA\Property(property="data", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Bad Request"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Internal Server Error"
    *     )
    * )
    */
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
    /**
    * @OA\Delete(
    *     tags={"/user"},
    *     path="/api/user/{id}",
    *     summary="Realiza softDelete em um usuário",
    *     security={{"jwt": {}}},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Usuario deletado com sucesso!"),
    *             @OA\Property(property="data", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Bad Request"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Internal Server Error"
    *     )
    * )
    */
    public function delete(Request $request){
        $id      = $request->id;
        // verifica se o parametro id foi passado
        if(isset($id)){
            try{
                $data = (new UsersDatabase)->delete($id);
                return ResponseHelper::success($data, 'Usuario deletado com sucesso!');
            }catch(Exception $e){
                Log::info("erro: " . $e->getMessage());
                return ResponseHelper::serverError('Ocorreu um erro!');
            }
        }else{
            return ResponseHelper::badRequest('O parametro ID é obrigatório!');
        }
    }

}