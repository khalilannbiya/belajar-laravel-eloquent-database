<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryResourceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCategoryResource(): void
    {
        $this->seed(["CategorySeeder"]);
        $category = \App\Models\Category::first();

        $this->get("/api/categories/$category->id")->assertStatus(200)->assertJson([
            'data' => [
                "id" => $category->id,
                "name" => $category->name,
                "description" => $category->description,
                "created_at" => $category->created_at
            ]
        ]);
    }

    public function testCategoryResourceCollection(): void
    {
        $this->seed(["CategorySeeder"]);
        $categories = \App\Models\Category::all();

        $this->get("/api/categories")->assertStatus(200)->assertJson([
            'data' => [
                [
                    "id" => $categories[0]->id,
                    "name" => $categories[0]->name,
                    "description" => $categories[0]->description,
                    "created_at" => $categories[0]->created_at
                ],
                [
                    "id" => $categories[1]->id,
                    "name" => $categories[1]->name,
                    "description" => $categories[1]->description,
                    "created_at" => $categories[1]->created_at
                ]
            ]
        ]);
    }

    public function testCategoryCustomResourceCollection(): void
    {
        $this->seed(["CategorySeeder"]);
        $categories = \App\Models\Category::all();

        $this->get("/api/categories-custom-resource-collection")->assertStatus(200)->assertJson([
            'data' => [
                [
                    "id" => $categories[0]->id,
                    "name" => $categories[0]->name,
                    "description" => $categories[0]->description,
                    "created_at" => $categories[0]->created_at
                ],
                [
                    "id" => $categories[1]->id,
                    "name" => $categories[1]->name,
                    "description" => $categories[1]->description,
                    "created_at" => $categories[1]->created_at
                ]
            ],
            "total" => 2
        ]);
    }

    public function testCategorySimpleResource(): void
    {
        $this->seed(["CategorySeeder"]);
        $category = \App\Models\Category::first();

        $this->get("/api/categories/$category->id")->assertStatus(200)->assertJson([
            'data' => [
                "id" => $category->id,
                "name" => $category->name,
            ]
        ]);
    }

    public function testCategoryNestedResourceCollection(): void
    {
        $this->seed(["CategorySeeder"]);
        $categories = \App\Models\Category::all();

        $this->get("/api/categories-nested-resource-collection")->assertStatus(200)->assertJson([
            'data' => [
                [
                    "id" => $categories[0]->id,
                    "name" => $categories[0]->name,
                ],
                [
                    "id" => $categories[1]->id,
                    "name" => $categories[1]->name,
                ]
            ],
            "total" => 2
        ]);
    }
}
