<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductResourceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testProductResouce(): void
    {
        $this->seed(['CategorySeeder', 'ProductSeeder']);
        $product = \App\Models\Product::with('category')->find("SAMSUNG-S23");

        $this->get("/api/products/$product->id")->assertStatus(200)->assertJson([
            "data" => [
                "id" => $product->id,
                "name" => $product->name,
                "category" => [
                    "id" => $product->category->id,
                    "name" => $product->category->name
                ],
                "price" => $product->price,
                "stock" => $product->stock,
                "created_at" => $product->created_at->toJSON(),
                "updated_at" => $product->updated_at->toJSON(),
            ]
        ]);
    }

    public function testProductsPaging()
    {
        $this->seed(['CategorySeeder', 'ProductSeeder']);
        $response = $this->get('/api/products-paging')->assertStatus(200);

        self::assertNotNull($response->json("links"));
        self::assertNotNull($response->json("meta"));
        self::assertNotNull($response->json("data"));
    }

    public function testAdditionalAttributeDinamis(): void
    {
        $this->seed(['CategorySeeder', 'ProductSeeder']);
        $product = \App\Models\Product::find("SAMSUNG-S23");

        $response = $this->get("/api/products-debug-resource/$product->id")->assertStatus(200)->assertJson([
            "author" => "Syeich Khalil Annbiya",
            "data" => [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "stock" => $product->stock,
                "created_at" => $product->created_at->toJSON(),
                "updated_at" => $product->updated_at->toJSON(),
            ]
        ]);

        self::assertNotNull($response->json("server_time"));
    }
}
