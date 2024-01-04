<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder;

class QueryBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from categories');
    }

    public function testInsertData()
    {
        DB::table('categories')->insert([
            "id" => "GADGET",
            "name" => "Gadget",
            "description" => "Gadget Category",
            "created_at" => "2023-12-11 10:10:10",
        ]);

        DB::table('categories')->insert([
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category",
            "created_at" => "2023-12-11 10:10:10",
        ]);

        $results = DB::table('categories')->get();

        self::assertCount(2, $results);
    }

    public function testSelect()
    {
        $this->testInsertData();

        $results = DB::table('categories')->get();

        self::assertCount(2, $results);
        self::assertNotNull($results);

        $results->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testInsertCategories()
    {
        DB::table('categories')->insert([
            "id" => "GADGET",
            "name" => "Gadget",
            "description" => "Gadget Category",
            "created_at" => "2023-12-10 12:10:10",
        ]);
        DB::table('categories')->insert([
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category",
            "created_at" => "2023-09-11 10:10:10",
        ]);
        DB::table('categories')->insert([
            "id" => "FASHION",
            "name" => "Fashion",
            "description" => "Fashion Category",
            "created_at" => "2023-12-11 10:10:10",
        ]);
        DB::table('categories')->insert([
            "id" => "DRINK",
            "name" => "Drink",
            "description" => "Drink Category",
            "created_at" => "2023-12-12 10:10:10",
        ]);

        $results = DB::table('categories')->get();

        self::assertCount(4, $results);
        self::assertNotNull($results);

        $results->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhere()
    {
        $this->testInsertCategories();

        $results = DB::table('categories')->where(function (Builder $builder) {
            $builder->where('id', 'DRINK');
            $builder->orWhere('id', 'FOOD');
        })->get();

        self::assertCount(2, $results);

        $results->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereBetween()
    {
        $this->testInsertCategories();

        $results = DB::table('categories')->whereBetween('created_at', ['2023-12-10 12:10:10', '2023-12-12 10:10:10'])->get();

        self::assertCount(3, $results);

        $results->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereDate()
    {
        $this->testInsertCategories();

        $results = DB::table('categories')->whereDate('created_at', '2023-12-10')->get();

        self::assertCount(1, $results);

        $results->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpdateData()
    {
        $this->testInsertCategories();
        DB::table('categories')->where('id', "DRINK")->update([
            "description" => "Drink Category Uhuy"
        ]);

        $result = DB::table('categories')->where('id', 'DRINK')->first();

        self::assertNotNull($result);
        self::assertEquals('Drink Category Uhuy', $result->description);

        Log::info(json_encode($result));
    }
}
