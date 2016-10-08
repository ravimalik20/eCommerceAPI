<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v0.1'], function () {
    Route::post('login', 'ApiAuthController@authenticate');

    Route::resource('user', 'UserController');
});

Route::group(['prefix' => 'v0.1', 'middleware' => ['auth:api', 'cors']], function () {
    Route::resource("category", "CategoryController");
    Route::resource('category.product', "CategoryProductController");

    Route::resource("color", "ColorController");

    Route::resource("manufacturer", "ManufacturerController");

    Route::resource("vendor", "VendorController");

    Route::resource("product", "ProductController");
    Route::resource("product.image", "ProductImageController");

    Route::resource("order", "OrderController");

    Route::resource('user.wishlist', "WishListController");
    Route::resource('user.address', 'UserAddressController');
    Route::resource('user.cart', 'CartController');
    Route::resource('user.cart.product', 'CartProductController');

    Route::resource('collection', "CollectionController");
    Route::resource('collection.product', "CollectionProductController");
    
});

?>
