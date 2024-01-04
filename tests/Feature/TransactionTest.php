<?php

namespace Tests\Feature;

use Illuminate\Database\QueryException;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from categories');
    }

    public function testTransactionSuccess()
    {
        DB::transaction(function () {
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
        });

        $result = DB::select('select * from categories');

        self::assertCount(2, $result);
    }

    public function testTransactionFailed()
    {
        try {
            DB::transaction(function () {
                DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
                    "id" => "GADGET",
                    "name" => "Gadget",
                    "description" => "Gadget Category",
                    "created_at" => "2023-12-11 10:10:10"
                ]);
                DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
                    "id" => "GADGET",
                    "name" => "Food",
                    "description" => "Food Category",
                    "created_at" => "2023-12-11 10:10:10"
                ]);
            });
        } catch (QueryException $error) {
            //throw $th;
        }


        $result = DB::select('select * from categories');

        self::assertCount(0, $result);
    }

    public function testManualTransactionSuccess()
    {
        try {
            DB::beginTransaction();

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

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }


        $result = DB::select('select * from categories');

        self::assertCount(2, $result);
    }

    public function testManualTransactionFailed()
    {
        try {
            DB::beginTransaction();

            DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
                "id" => "GADGET",
                "name" => "Gadget",
                "description" => "Gadget Category",
                "created_at" => "2023-12-11 10:10:10"
            ]);
            DB::insert('insert into categories(id, name, description, created_at) values(:id, :name, :description, :created_at)', [
                "id" => "GADGET",
                "name" => "Food",
                "description" => "Food Category",
                "created_at" => "2023-12-11 10:10:10"
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }


        $result = DB::select('select * from categories');

        self::assertCount(0, $result);
    }
}
