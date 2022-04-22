<?php

use App\Http\Controllers\APIs\Shop\V1\ShopAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('shop/v1')->group(function (){
    Route::get('get-counties', [ShopAPIController::class, 'getCounties']);
    Route::get('get-categories', [ShopAPIController::class, 'getAllCategories']);
    Route::get('get-products', [ShopAPIController::class, 'getAllProducts']);
    Route::get('get-product/{slug}', [ShopAPIController::class, 'getProductBySlug']);
    Route::get('get-products/{category}', [ShopAPIController::class, 'getProductsByCategory']);
    Route::get('get-sliders', [ShopAPIController::class, 'getAllSliders']);
    Route::get('search/{query}', [ShopAPIController::class, 'searchProductByQuery']);
    Route::get('get-product-images/{id}', [ShopAPIController::class, 'getProductImages']);

    Route::post('subscribe', [ShopAPIController::class, 'subscribe']);
    Route::post('save-user-contact', [ShopAPIController::class, 'saveUserContact']);
    
    Route::post('cart', [ShopAPIController::class, 'addToCart']);
    Route::get('cart/{user_id}', [ShopAPIController::class, 'getUserCart']);
    Route::delete('cart/{id}', [ShopAPIController::class, 'removeFromCart']);

    Route::post('place-bid', [ShopAPIController::class, 'placeBid']);
    Route::get('bids/{id}', [ShopAPIController::class, 'getUserBids']);
    Route::get('bid/{id}', [ShopAPIController::class, 'getBidById']);
});