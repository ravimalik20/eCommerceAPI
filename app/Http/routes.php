<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v0.1'], function () {
    Route::resource("category", "CategoryController");
    Route::resource('category.product', "CategoryProductController");

    Route::resource("color", "ColorController");

    Route::resource("manufacturer", "ManufacturerController");

    Route::resource("vendor", "VendorController");

    Route::resource("product", "ProductController");

    Route::resource("order", "OrderController");

    Route::resource('user.wishlist', "WishListController");
    Route::resource('user.address', 'UserAddressController');
    Route::resource('user.cart', 'CartController');

    Route::resource('collection', "CollectionController");
    Route::resource('collection.product', "CollectionProductController");
    
});

?>
