<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{


    //test users registration
    //path: users/register method: POST data: {name: 'Gilles KPANOU', email:'okpanou2@gmail.com', password: 'test'}
    public function test_users_registration()
    {
        $response = $this->post('http://127.0.0.1:8000/api/users/register', ['name' => 'Gilles KPANOU', 'email' =>'okpanou2@gmail.com', 'password' => 'test']);
        $response->assertStatus(200);
    }


    //test users login
    //path: users/login method: POST data: {email:'okpanou2@gmail.com', password: 'test'}
    public function test_users_login()
    {
        $response = $this->post('http://127.0.0.1:8000/api/users/login', ['email' =>'okpanou2@gmail.com', 'password' => 'test']);
        $response->assertStatus(200);
    }

}
