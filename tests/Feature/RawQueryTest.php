<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RawQueryTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from categories');
    }

    public function setInsertData()
    {
        DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
            "id" => "GADGET",
            "name" => "Gadget",
            "description" => "Gadget Category",
            "created_at" => "2023-12-11 10:10:10"
        ]);
        DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category",
            "created_at" => "2023-12-11 10:10:10"
        ]);
    }

    public function testInsertData(): void
    {
        DB::insert('insert into categories(id, name, description, created_at) values(?, ?, ?, ?)', [
            "GADGET", "Gadget", "Gadget Category", "2023-12-11 10:10:10"
        ]);

        $result = DB::select('select * from categories where id = ?', ["GADGET"]);

        self::assertCount(1, $result);
        self::assertEquals('GADGET', $result[0]->id);
        self::assertEquals('Gadget', $result[0]->name);
        self::assertEquals('Gadget Category', $result[0]->description);
        self::assertEquals('2023-12-11 10:10:10', $result[0]->created_at);
    }

    public function testInsertDataNamedParameter(): void
    {
        DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
            "id" => "GADGET",
            "name" => "Gadget",
            "description" => "Gadget Category",
            "created_at" => "2023-12-11 10:10:10"
        ]);

        $result = DB::select('select * from categories where id = :id', ["id" => "GADGET"]);

        self::assertCount(1, $result);
        self::assertEquals('GADGET', $result[0]->id);
        self::assertEquals('Gadget', $result[0]->name);
        self::assertEquals('Gadget Category', $result[0]->description);
        self::assertEquals('2023-12-11 10:10:10', $result[0]->created_at);
    }

    public function testSelectDataNamedParameter(): void
    {
        $this->setInsertData();

        $results = DB::select('select * from categories');

        self::assertCount(2, $results);
    }

    public function testUpdateDataNamedParameter(): void
    {
        $this->setInsertData();

        DB::update('update categories set description = "Food Category Uhuy" where id = :id', ["id" => "FOOD"]);

        $results = DB::select('select * from categories where id = :id', ["id" => "FOOD"]);

        self::assertCount(1, $results);
        self::assertEquals('FOOD', $results[0]->id);
        self::assertEquals('Food', $results[0]->name);
        self::assertEquals('Food Category Uhuy', $results[0]->description);
    }

    public function testDeleteDataNamedParameter()
    {
        $this->setInsertData();

        DB::delete('delete from categories where id = :id', ["id" => "FOOD"]);

        $results = DB::select('select * from categories');

        self::assertCount(1, $results);
        self::assertEquals('GADGET', $results[0]->id);
    }
}
