<?php

namespace App\Helpers;

class ResponseHelper{

    const OK = 200;
    const EMPTY = 204;
    const ERROR = 500;
    const BADREQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOTFOUND = 404;

    public static function success($data = [], $msg = 'Requisição concluida com sucesso!')
    {
        $response = [
            'success' => true,
            'message' => $msg,
            'data'    => $data
        ];
        return response()->json($response, self::OK);
    }
    public static function noContent($msg = 'A Requisição não retornou resultados')
    {
        $response = [
            'success' => true,
            'message' => $msg,
        ];
        return response()->json([], self::EMPTY);
    }
    public static function serverError(String $msg = 'Ocorreu um erro no servidor.'){
        $response = [
            'success' => false,
            'message' => $msg
        ];
        return response()->json($response, self::ERROR);
    }
    public static function badRequest(String $msg = 'Falha na requisição.'){
        $response = [
            'success' => false,
            'message' => $msg
        ];
        return response()->json($response, self::BADREQUEST);
    }
    public static function notFound(String $msg = 'Solicitação não encontrada.'){
        $response = [
            'success' => false,
            'message' => $msg
        ];
        return response()->json($response, self::NOTFOUND);
    }
    public static function unauthorized(String $msg = 'O usuario não possui permissão.'){
        $response = [
            'success' => false,
            'message' => $msg,
        ];
        return response()->json($response, self::UNAUTHORIZED);
    }



}