<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Usuário 1',
                'email' => 'usuario1@example.com',
                'password' => Hash::make('senha123'),
                'avatar' => 'caminho/do/avatar1.jpg',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Usuário 2',
                'email' => 'usuario2@example.com',
                'password' => Hash::make('senha123'),
                'avatar' => 'caminho/do/avatar2.jpg',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
