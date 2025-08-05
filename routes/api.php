<?php

use App\Http\Controllers\Api\ContactUsPageController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PartnershipPageController;
use App\Http\Controllers\Api\ServicePageController;
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

//Services
Route::get('/services/page', [ServicePageController::class, 'getFullPage']);
Route::post('/services/seed', [ServicePageController::class, 'seedTestData']);

//Partnerships
Route::get('/partnerships/page', [PartnershipPageController::class, 'getFullPage']);
Route::post('/partnerships/seed', [PartnershipPageController::class, 'seedTestData']);

//Contact Us
Route::get('/contact-us/page', [ContactUsPageController::class, 'getFullPage']);
Route::post('/contact-us/seed', [ContactUsPageController::class, 'seedTestData']);
Route::post('/contact-us', [ContactUsPageController::class, 'sendContactInquiry']);

//Settings
Route::get('/home', [HomeController::class, 'getHomePage']);
Route::post('/home/update', [HomeController::class, 'updateFooter']);

