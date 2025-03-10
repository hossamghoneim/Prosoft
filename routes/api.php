<?php

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

Route::group( [ 'namespace' => 'Api', 'middleware' => ['web'] ] , function (){

//    Route::get('categories','CategoryController@index');
//    Route::get('categories/search/{word}','CategoryController@search');
//
//    // products apis
//    Route::get('products','ProductController@index');
//    Route::get('products/search/{word}','ProductController@search');
//    Route::get('products/{product}','ProductController@show');
//    Route::get('collections','ProductController@tagsWithProducts'); // tags with products
//    Route::get('collections/{tag}','ProductController@singleTagWithProducts'); // single tag with products
//    // products apis
//
//    // sliders apis
//    Route::get('sliders','SliderController');
//    // sliders apis
//
//    // settings apis
//    Route::get('settings','SettingsController');
//    // settings apis
//
//    // authentication apis
//    Route::post('login','AuthController@login');
//    Route::post('social-login','AuthController@socialLogin');
//    Route::post('register','AuthController@register');
//    // authentication apis
//
//
//    // newsletter apis
//    Route::post('subscriber','SubscriberController');
//    // newsletter apis
//
//    // contact us apis
//    Route::post('contact-us','ContactUsController@store');
//    // contact us apis
//
//    // product reviews apis
//    Route::get('product-reviews/{product}','ProductController@reviews');
//    // product reviews apis
//
//    Route::group( [ 'middleware' => 'auth:api' ] , function (){
//
//
//        // authentication apis
//        Route::post('user-data','UserController@getUserData');
//        Route::post('log-out','AuthController@logOut');
//        // authentication apis
//
//
//        // user apis
//        Route::post('update-profile','UserController@updateProfile');
//        Route::put('update-password','UserController@updatePassword');
//        // user apis
//
//        // product reviews apis
//        Route::post('product-reviews','UserController@addReview');
//        // product reviews apis
//
//        // carts apis
//        Route::apiResource('cart','CartController');
//        // carts apis
//
//        // favourites apis
//        Route::apiResource('favourites','FavouriteController');
//        // favourites apis
//
//        // orders apis
//        Route::apiResource('orders','OrderController');
//        // orders apis
//
//        // user addresses apis
//        Route::apiResource('user-addresses','UserAddressController')->only(['store','index','destroy']);
//        // user addresses apis
//
//        Route::post('apply-coupon','CouponController@applyCoupon');
//    });


});
