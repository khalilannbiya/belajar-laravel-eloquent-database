<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from categories');
        DB::delete('delete from products');
        DB::delete('delete from vouchers');
        DB::delete('delete from comments');
        DB::delete('delete from customers');
        DB::delete('delete from wallets');
        DB::delete('delete from vitual_accounts');
    }
}
