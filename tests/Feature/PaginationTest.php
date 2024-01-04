<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginationTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from categories');
    }

    public function testInsertData()
    {

        for ($i = 1; $i <= 100; $i++) {
            $word = fake()->word();
            DB::table('categories')->insert([
                "id" => fake()->unixTime(),
                "name" => ucfirst($word),
                "description" => ucfirst($word) . " Category",
                "created_at" => date('Y-m-d H:i:s', fake()->unixTime()),
            ]);
        }

        $result = DB::select('select * from categories');

        self::assertCount(100, $result);
    }

    /**
     * A basic feature test example.
     */
    public function testPaginatingQuery(): void
    {
        $this->testInsertData();

        $results = DB::table('categories')->paginate(10);


        self::assertCount(10, $results->items());
    }
}
