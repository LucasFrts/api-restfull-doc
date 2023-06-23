<?php
namespace App\Helpers;
use App\Connectors\Database\UsersDatabase;
class PayloadHelper{

    const updatePayload = ['name', 'email', 'celular', 'sexo', 'active', 'avatar'];
    public static function update($payload){
        $keys = array_keys($payload);
        $valid_payload = false;
        // procura entre os campos de update e os campos do payload se existe algum correspondente
        foreach($keys as $key){
            if(in_array($key, self::updatePayload)){
                $valid_payload = true;
            }
        }
        // payload possui pelo menos um dos campos para alteração
        if($valid_payload){
            if(isset($payload['email'])){
                // verifica se existe outro ussuario com o mesmo email
                $same_email = (new UsersDatabase)->getByEmail($payload['email']);
                return isset($same_email->id) ? 422 : 200;
            }
            return 200;
        }
        return 400;
        
    }
}