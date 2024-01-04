<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                "id" => "SAMSUNG-S23",
                "category_id" => "GADGET",
                "name" => "Samsung S23",
                "description" => "Samsung S23 Black",
                "price" => 15000000,
                "stock" => 5,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => "IPHONE-15PRO",
                "category_id" => "GADGET",
                "name" => "Iphone 15 Pro",
                "description" => "Iphone 15 Pro Black Doff",
                "price" => 20000000,
                "stock" => 10,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => "MARTABAKAPIN-01",
                "category_id" => "FOOD",
                "name" => "Martabak Apin Keju Coklat",
                "description" => "Martabak Apin Keju Coklat",
                "price" => 20000,
                "stock" => 200,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        ];

        Product::insert($products);
    }
}
