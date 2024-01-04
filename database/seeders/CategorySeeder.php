<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $category->description = "Gadget Category";
        $category->is_active = true;
        $category->save();

        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = true;
        $category->save();
    }
}
