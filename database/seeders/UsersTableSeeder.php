<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = resource_path('users_data.json');
        $json = file_get_contents($path);
        $users = json_decode($json, false);
        $users_array = array();
        foreach($users as $user){
            $user_record = [
                'name' => $user->nome,
                'email' => $user->email,
                'password' => Hash::make($user->senha),
                'avatar' => 'upload/avatar.jpg',
                'celular' => $user->celular,
                'sexo' => $user->sexo,
                'data_nascimento' => $user->data_nasc,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $users_array[] = $user_record;
        }
        DB::table('users')->insert($users_array);
    }
}
