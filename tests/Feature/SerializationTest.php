<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class SerializationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSerializationToJson(): void
    {
        $this->seed(["CategorySeeder", "ProductSeeder"]);

        $category = Category::with(["products"])->find('GADGET');
        self::assertNotNull($category);

        $json = $category->products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }

    public function testSerializationToArray(): void
    {
        $this->seed(["CategorySeeder", "ProductSeeder"]);

        $category = Category::with(["products"])->find('GADGET');
        self::assertNotNull($category);

        $array = $category->products->toArray();
        Log::info($array);
    }
}
