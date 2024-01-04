<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsertDataCategory(): void
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $result = $category->save();

        self::assertTrue($result);
    }

    public function testSelectDataCategory()
    {
        $this->seed('CategorySeeder');

        $categories = Category::all();

        self::assertCount(2, $categories);
    }

    public function testInsertManyCategories()
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }

        $result = Category::insert($categories);

        self::assertTrue($result);

        $total = Category::all();

        self::assertCount(10, $total);
    }

    public function testFind()
    {
        $this->seed('CategorySeeder');

        $category = Category::select(['id', 'name'])->find("GADGET");

        self::assertNotNull($category);
        self::assertEquals("GADGET", $category->id);
        self::assertEquals("Gadget", $category->name);
    }

    public function testUpdate()
    {
        $this->seed('CategorySeeder');

        $category = Category::select(['id', 'name'])->find("GADGET");
        $category->name = "Gadget Ubah";
        $result = $category->update();


        self::assertTrue($result);
        self::assertEquals("Gadget Ubah", $category->name);
    }

    public function testAlternateUpdate()
    {
        $this->seed('CategorySeeder');
        // The approach can be used with
        // the condition that you have already created the `fillable` property in the Model representing the corresponding table.
        // This method is commonly referred to as mass assignment.
        $result = Category::find("GADGET")->update([
            "description" => "Updated"
        ]);

        self::assertTrue($result);

        $category = Category::find("GADGET");

        self::assertEquals("Updated", $category->description);
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        Category::whereNull('description')->update([
            "description" => "Updated"
        ]);
        $total = Category::where('description', "Updated")->count();
        self::assertEquals(10, $total);
    }

    public function testDeleteData()
    {
        $this->seed('CategorySeeder');

        // get data by id "GADGET"
        $category = Category::find("GADGET");
        $result = $category->delete();

        self::assertTrue($result);

        $total = Category::count();
        self::assertEquals(1, $total);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        Category::whereNull('description')->delete();
        $total = Category::count();
        self::assertEquals(0, $total);
    }

    public function testCreateMassDataUsingSaveMethod()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testCreatedMassUsingCreateMethod()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        $category = Category::create($request);

        self::assertNotNull($category->id);
    }

    public function testUpdateMassUsingFillMethod()
    {
        $this->seed('CategorySeeder');

        $request = [
            'name' => 'Gadget Updated',
            'description' => 'Gadget Category Updated'
        ];

        $category = Category::find('GADGET');
        $category->fill($request);
        $result = $category->save();

        self::assertTrue($result);
        self::assertNotNull($category->id);
        self::assertEquals('Gadget Updated', $category->name);
        self::assertEquals('Gadget Category Updated', $category->description);
    }

    public function testUpdateMassUsingUpdateMethod()
    {
        $this->seed('CategorySeeder');

        $request = [
            'name' => 'Gadget Updated',
            'description' => 'Gadget Category Updated'
        ];

        $result = Category::find('GADGET')->update($request);

        self::assertTrue($result);

        $category = Category::find('GADGET');

        self::assertEquals('Gadget Updated', $category->name);
        self::assertEquals('Gadget Category Updated', $category->description);
    }

    public function testGlobalScope()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        $category = Category::find('FOOD');
        self::assertNull($category);
    }
}
