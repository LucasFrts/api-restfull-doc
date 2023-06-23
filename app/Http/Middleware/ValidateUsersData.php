<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Connectors\Validators\CreateUserValidator;
use App\Connectors\Validators\UpdateUserValidator;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;

class ValidateUsersData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $payload = $request->all();
        if ($request->routeIs('user')) {
            $validator = Validator::make($payload, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'celular' => 'required',
                'sexo' => 'required',
                'data_nascimento' => 'required',
            ]);
            Log::info("is create");
        } elseif ($request->routeIs('user.update')) {
            $validator = Validator::make($payload,[
            'name' => 'sometimes',
            'email' => 'sometimes|email',
            'password' => 'sometimes',
            'celular' => 'sometimes',
            'sexo' => 'sometimes',
            'data_nascimento' => 'sometimes'
            ]);
            Log::info("is update");
        }
        // Se a validação falhar, retorna a resposta com os erros
        if ($validator->fails()) {
            return ResponseHelper::badRequest('Falha na requisição', $validator->errors());
        }
        return $next($request);
    }
}
