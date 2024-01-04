<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    public function testFormSuccess(): void
    {
        $response = $this->post('/login', [
            "username" => "khalil",
            "password" => "khalilannbiya098#"
        ]);

        $response->assertStatus(200);
    }

    public function testFormFailed(): void
    {
        $response = $this->post('/login', [
            "username" => "",
            "password" => "#"
        ]);

        $response->assertStatus(302);
    }
}
