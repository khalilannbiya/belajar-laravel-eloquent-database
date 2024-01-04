<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Test Voucher";
        $voucher->voucher_code = "123456789123456789";
        $voucher->save();
    }
}
