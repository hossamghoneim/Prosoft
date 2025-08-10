<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\ContactUsPageController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PartnershipPageController;
use App\Http\Controllers\Api\ServicePageController;
use App\Http\Controllers\Api\SolutionController;
use App\Http\Controllers\Api\TermsAndConditionsController;
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

//General
Route::get('/general', [GeneralController::class, 'general']);
Route::post('/general/update', [GeneralController::class, 'updateFooter']);

//About Us
Route::get('/about-us/page', [AboutUsController::class, 'getFullPage']);
Route::post('/about-us/seed', [AboutUsController::class, 'seedTestData']);

//Terms And Conditions
Route::get('/terms-and-conditions/page', [TermsAndConditionsController::class, 'getFullPage']);
Route::post('/terms-and-conditions/seed', [TermsAndConditionsController::class, 'seedTestData']);

//Solutions
Route::get('/solutions/page', [SolutionController::class, 'getFullPage']);
Route::post('/solutions/seed', [SolutionController::class, 'seed']);

//Home
Route::get('/home/page', [HomeController::class, 'getHomePage']);
Route::post('/home/seed', [HomeController::class, 'seed']);

