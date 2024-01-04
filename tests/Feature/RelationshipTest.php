<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\VitualAccount;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertNotNull;

class RelationshipTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testQueryOneToOne(): void
    {
        $this->seed('CustomerSeeder');
        $this->seed('WalletSeeder');

        $customer = Customer::with('wallet')->find('CUST-SYEICHKHALIANNBIYA30');
        self::assertNotNull($customer);

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(100000000, $wallet->amount);
    }

    public function testQueryOneToManyCategory()
    {
        $this->seed('CategorySeeder');
        $this->seed('ProductSeeder');

        $category = Category::with('products')->find('GADGET');
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($products);
        self::assertCount(2, $products);
    }

    public function testQueryOneToManyProduct()
    {
        $this->seed('CategorySeeder');
        $this->seed('ProductSeeder');

        $product = Product::with('category')->find('SAMSUNG-S23');
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals('GADGET', $category->id);

        $category = $category->count();
        self::assertEquals(2, $category);
    }

    public function testInsertRelationshipOneToOne()
    {
        $customer = new Customer();
        $customer->id = "CUST-SYEICHKHALILANNBIYA";
        $customer->name = "Syeich Khalil Annbiya";
        $customer->email = "syeichkhalil30@gmail.com";
        $customer->save();
        self::assertNotNull($customer);

        $wallet = new Wallet();
        $wallet->amount = 100000;
        $customer->wallet()->save($wallet);
        self::assertNotNull($wallet);
    }

    public function testInsertRelationshipOneToMany()
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $category->description = "Gadget Category";
        $category->is_active = true;
        $category->save();

        self::assertNotNull($category);
        self::assertEquals('GADGET', $category->id);

        $product = new Product();
        $product->id = "PRODUCT";
        $product->category_id = $category->id;
        $product->name = "PRODUCT";
        $product->description = "Ini adalah Product";
        $product->price = 20000;
        $product->stock = 4;
        $category->products()->save($product);

        self::assertNotNull($product);
    }

    public function testSearchProduct()
    {
        $this->testInsertRelationshipOneToMany();

        $category = Category::find('GADGET');
        $outOfStockProducts = $category->products()->where('stock', '<=', 5)->get();

        self::assertNotNull($outOfStockProducts);
    }

    public function testHasOneOfMany()
    {
        $this->seed(['CategorySeeder', 'ProductSeeder']);

        $category = Category::find('GADGET');

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals('Samsung S23', $cheapestProduct->name);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals('Iphone 15 Pro', $mostExpensiveProduct->name);
    }

    public function testQueryOneThousandData()
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $category->description = "Gadget Category";
        $category->is_active = true;
        $category->save();

        self::assertNotNull($category);
        self::assertEquals('GADGET', $category->id);

        $products = [];
        for ($i = 1; $i <= 1000; $i++) {
            $products[] = [
                "id" => "PRODUCT-$i",
                "category_id" => $category->id,
                "name" => "Product $i",
                "description" => "Ini Deskirpsi Product $i",
                "price" => 5000 * $i,
                "stock" => 10,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ];
        }

        $insertDataProduct = Product::insert($products);
        self::assertTrue($insertDataProduct);

        $getProducts = Product::where('category_id', 'GADGET')->get();
        self::assertCount(1000, $getProducts);
    }

    public function testQueryFiveThousandData()
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $category->description = "Gadget Category";
        $category->is_active = true;
        $category->save();

        self::assertNotNull($category);
        self::assertEquals('GADGET', $category->id);

        $products = [];
        for ($i = 1; $i <= 5000; $i++) {
            $products[] = [
                "id" => "PRODUCT-$i",
                "category_id" => $category->id,
                "name" => "Product $i",
                "description" => "Ini Deskirpsi Product $i",
                "price" => 5000 * $i,
                "stock" => 10,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ];
        }

        $insertDataProduct = Product::insert($products);
        self::assertTrue($insertDataProduct);

        $getProducts = Product::where('category_id', 'GADGET')->get();
        self::assertCount(5000, $getProducts);
    }

    public function testHasOneThrough()
    {
        $customer = new Customer();
        $customer->id = "CUST-SYEICHKHALILANNBIYA";
        $customer->name = "Syeich Khalil Annbiya";
        $customer->email = "syeichkhalil30@gmail.com";
        $customer->save();

        self::assertNotNull($customer);

        $getCustomer = Customer::all();
        self::assertCount(1, $getCustomer);

        $wallet = new Wallet();
        $wallet->amount = 20000;
        $customer->wallet()->save($wallet);

        self::assertNotNull($wallet);

        $getWallet = Customer::with('wallet')->find('CUST-SYEICHKHALILANNBIYA')->wallet()->count();
        // $result = $getWallet->wallet;
        self::assertEquals(1, $getWallet);

        $virtualAccount = new VitualAccount();
        $virtualAccount->bank = "BCA";
        $virtualAccount->va_number = "982928891082";
        $wallet->virtualAccount()->save($virtualAccount);

        self::assertNotNull($virtualAccount);

        $getVirtualAccount = Customer::with('virtualAccount')->find('CUST-SYEICHKHALILANNBIYA')->virtualAccount()->count();
        self::assertEquals(1, $getVirtualAccount);
    }
}
