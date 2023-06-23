<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersEndpointsTest extends TestCase{

    // teste de de get rota bem vindo
    public function testBemVindoEndpoint(){
        $response = $this->get('/api/bem-vindo');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson(['message' => 'seja bem vindo! meu nome é Lucas e meu github é LucasFrts']);
    }
    // teste de de get user especifico
    public function testGetEndpoint(){
        $response = $this->get('/api/user/1');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson(['message' => 'Requisição concluida com sucesso!'])
            ->assertJsonStructure([
                'success',
                'message',
                'data' =>[
                    'id',
                    'name',
                    'email'
                ]
            ]);
    }
    // teste de de get sem resultado
    public function testGetNotFoundEndpoint(){
        $response = $this->get('/api/user/99999');
        $response->assertStatus(204);
    }
    // teste de get all usuarios
    public function testGetAllEndpoint(){
        $response = $this->get('/api/user/get-all');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson(['message' => 'Requisição concluida com sucesso!'])
            ->assertJsonStructure([
                'success',
                'message',
                'data' =>[
                    ['id',
                    'name',
                    'email']
                ]
            ]);

    }
    // teste de get usuarios ativos
    public function testGetActiveEndpoint(){
        $response = $this->get('/api/user/get-active');
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJson(['message' => 'Requisição concluida com sucesso!'])
            ->assertJsonStructure([
                'success',
                'message',
                'data' =>[
                    ['id',
                    'name',
                    'email']
                ]
            ]);
    }
    // teste middleware rota de update
    public function testUpdateMiddlewareEndpoint(){
        $payload = [
            'teste' => 'desenvolvimento'
        ];
        $response = $this->put('/api/user/1', $payload);
        $response->assertStatus(400);
    }
    // teste rota de update
    public function testUpdateEndpoint(){
        $payload = [
            'name' => 'Rafaela Monteiro Pontes'
        ];
        $response = $this->put('/api/user/1', $payload);
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'message',
                'data' =>[
                    'id',
                    'name',
                    'email'
                ]
            ]);
    }
    // teste rota de update invalido
    public function testUpdateEndpointFail(){
        $payload = [
            'name' => 'Rafaela Monteiro Pontes',
            'email' => 'juliana_carvalho@panfletosecia.com'
        ];
        $response = $this->put('/api/user/1', $payload);
        $response->assertStatus(400)
            ->assertJson(['success' => false])
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }
    // teste middleware rota de create
    public function testCreateMiddlewareEndpoint(){
        $payload = [
            'teste' => 'desenvolvimento'
        ];
        $response = $this->post('/api/user', $payload);
        $response->assertStatus(400);
    }
    // teste do endpoint de create
    public function testCreateEndpoint(){
        $create_payload = [
            'name' => 'Lucas Matheus Ramos de Freitas',
            'email' => 'lucasmatheus.profissional@gmail.com',
            'password' => 'passwordSeguro123',
            'celular' => '(96) 98109-2620',
            'sexo' => 'Masculino',
            'data_nascimento' => '18/09/2001'
        ];
        $response = $this->post('/api/user', $create_payload);
        $response->assertStatus(201)
                ->assertJson(['success' => true])
                    ->assertJsonStructure([
                        'success',
                        'message',
                        'data'
                    ]);
    }
    // teste do endpoint falho
    public function testCreateEndpointFail(){
        $create_payload = [
            'name' => 'Lucas Matheus Ramos de Freitas',
            'email' => 'lucasmatheus.profissional@gmail.com',
            'password' => 'passwordSeguro123',
            'celular' => '(96) 98109-2620',
            'sexo' => 'Masculino',
            'data_nascimento' => '18/09/2001'
        ];
        $response = $this->post('/api/user', $create_payload);
        $response->assertStatus(400)
                ->assertJson(['success' => false])
                ->assertJsonStructure([
                    'success',
                    'message',
                ]);
    }
    public function testDeleteEndpoint(){
        $response = $this->delete('/api/user/1');
        $response->assertStatus(200)
                ->assertJson(['success' => true])
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);
    }
    // teste de de get sem resultado
    public function testDeleteEndpointFail(){
        $response = $this->delete('/api/user/99999');
        $response->assertStatus(500);
    }
}