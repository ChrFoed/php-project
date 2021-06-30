<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Resources\ProductsResource;
use App\Http\Controllers\ProductsController;
use App\Models\Products;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', function () {
    return new ProductsResource(Products::getLastProductsState()->get());
});

Route::get('/products/{identifier}', function ($identifier) {
    return new ProductsResource(Products::where('identifier', $identifier)->get());
});

Route::post('/products', [ProductsController::class, 'addProduct']);

Route::delete('/products/{identifier}', [ProductsController::class, 'deleteProduct']);
