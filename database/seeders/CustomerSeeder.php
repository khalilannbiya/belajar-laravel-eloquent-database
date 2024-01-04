<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Customer();
        $customer->id = "CUST-SYEICHKHALIANNBIYA30";
        $customer->name = "Syeich Khalil Annbiya";
        $customer->email = "syeichkhalil30@gmail.com";
        $customer->save();
    }
}
