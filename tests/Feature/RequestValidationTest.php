<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestValidationTest extends TestCase
{
    public function testLoginSuccess()
    {
        $response = $this->post('/form/login', [
            "username" => "khalilannbiya",
            "password" => "khalilannbiya507#"
        ]);

        $response->assertStatus(200);
    }

    public function testLoginFailed()
    {
        $response = $this->post('/form/login', [
            "username" => "",
            "password" => ""
        ]);

        $response->assertStatus(400);
    }
}
