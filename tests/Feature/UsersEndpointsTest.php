<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersEndpointsTest extends TestCase{
    public function testGetUsers(){
        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Success']);
    }
    public function testGetUser(){
        
    }
}