<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoucherTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUuid(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Test Voucher";
        $voucher->voucher_code = "123456789123456789";
        $result = $voucher->save();

        self::assertTrue($result);
        self::assertNotNull($voucher->id);

        $select = Voucher::count();

        self::assertEquals(1, $select);
    }

    public function testCustomUuidColumns(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Test Voucher";
        $result = $voucher->save();

        self::assertTrue($result);
        self::assertNotNull($voucher->id);
        // The "voucher_code" field is automatically generated as a UUID.
        self::assertNotNull($voucher->voucher_code);

        $select = Voucher::count();

        self::assertEquals(1, $select);
    }

    public function testCreateModel()
    {
        $this->seed('VoucherSeeder');

        $vouchers  = Voucher::all();

        self::assertCount(1, $vouchers);
        self::assertEquals('Test Voucher', $vouchers[0]->name);

        Voucher::firstOrCreate([
            'name' => 'London to Paris'
        ], [
            'voucher_code' => "1243354765765768087987"
        ]);

        $vouchers  = Voucher::all();
        self::assertCount(2, $vouchers);
        self::assertEquals('London to Paris', $vouchers[1]->name);
    }

    public function testSoftDelete()
    {
        $this->seed('VoucherSeeder');

        $voucher = Voucher::where('name', 'Test Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::where('name', 'Test Voucher')->first();
        self::assertNull($voucher);
    }

    // If you want to permanently delete it but have already implemented soft delete
    public function testSoftDeleteUsingForceDeleteMethod()
    {
        $this->seed('VoucherSeeder');

        $voucher = Voucher::where('name', 'Test Voucher')->first();
        $voucher->forceDelete();

        $voucher = Voucher::where('name', 'Test Voucher')->first();
        self::assertNull($voucher);
    }

    // If you really want to retrieve all data, including those that have been soft deleted
    public function testCompleteDataRetrievalIncludingSoftDeletedRecords()
    {
        $this->seed('VoucherSeeder');

        $voucher = Voucher::where('name', 'Test Voucher')->first();
        $voucher->delete(); // soft delete

        $voucher = Voucher::where('name', 'Test Voucher')->first();
        self::assertNull($voucher);

        // Retrieving all data, including those that have been soft deleted
        $voucher = Voucher::withTrashed()->where('name', 'Test Voucher')->first();
        self::assertNotNull($voucher);
    }
}
