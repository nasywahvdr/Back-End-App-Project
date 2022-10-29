<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/hello', function (Request $request) {
    return "hello world";
});


Route::get("product", ProductController::class. "@listProduct");
Route::get("product/{product_id}", ProductController::class. "@detailProduct");
Route::delete("product/{product_id}", ProductController::class. "@deleteProduct");
Route::post("product", ProductController::class. "@saveProduct");
Route::post("order", OrderController::class. "@saveOrder");

//Route::put("product", ProductController::class. "@saveProduct");
//Route::patch("product", ProductController::class. "@saveProduct");


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Passport::routes();