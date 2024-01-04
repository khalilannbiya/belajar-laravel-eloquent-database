<?php

use App\Http\Resources\CategoryNestedResourceCollection;
use App\Http\Resources\CategorySimpleResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories/{id}', function (string $id) {
    $category = \App\Models\Category::findOrFail($id);
    return new \App\Http\Resources\CategoryResource($category);
});

Route::get('/categories', function () {
    $categories = \App\Models\Category::all();
    return \App\Http\Resources\CategoryResource::collection($categories);
});

Route::get('/categories-custom-resource-collection', function () {
    $categories = \App\Models\Category::all();
    return new \App\Http\Resources\CategoryCollection($categories);
});

Route::get('/categories-simple-resource', function () {
    $category = \App\Models\Category::first();
    return new CategorySimpleResource($category);
});

Route::get('/categories-nested-resource-collection', function () {
    $categories = \App\Models\Category::all();
    return new CategoryNestedResourceCollection($categories);
});

Route::get('/products/{id}', function (string $id) {
    $product = \App\Models\Product::with('category')->findOrFail($id);
    return new ProductResource($product);
});

Route::get('/products-paging', function () {
    $products = \App\Models\Product::with('category')->paginate(2);
    return ProductResource::collection($products);
});

Route::get('/products-debug-resource/{id}', function (string $id) {
    $product = \App\Models\Product::find($id);
    return new \App\Http\Resources\ProductDebugResource($product);
});
