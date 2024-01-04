<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = new Wallet();
        $wallet->customer_id = "CUST-SYEICHKHALIANNBIYA30";
        $wallet->amount = "100000000";
        $wallet->save();
    }
}