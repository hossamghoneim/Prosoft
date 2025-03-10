<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CarModelController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

/** public routes **/
Route::group(['namespace' => 'Auth', 'prefix' => 'admin', 'middleware' => ['web', 'set_locale']] , function () {

    Route::view('login','auth.admin_login')->name('admin.login-form');
    Route::post('login',[AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('logout',[AdminAuthController::class, 'logout'])->name('admin.logout');

});
/** public routes **/


/** authenticated routes **/
Route::group(['as' => 'dashboard.' , 'middleware' => ['web', 'set_locale', 'auth:admin', 'normalize_datatables_search_and_filter_requests'] ] , function (){


    /** dashboard index **/
    Route::get('/' , [DashboardController::class, 'index'])->name('index');

    Route::resource('admins', AdminController::class);
    Route::resource('roles',RoleController::class);
    Route::resource('brands',BrandController::class);
    Route::resource('car-models',CarModelController::class);
    Route::resource('products',ProductController::class);
    Route::resource('tags',TagController::class);
    Route::resource('users',UserController::class)->only(['index', 'destroy']);
    Route::resource('categories',CategoryController::class)->except(['edit','create']);
    Route::resource('orders',OrderController::class);
    Route::post('change-status/{order}',[OrderController::class, 'changeStatus']);
    Route::get('settings',[SettingController::class,'index'])->name('settings.index');
    Route::put('settings',[SettingController::class,'update'])->name('settings.update');
    Route::get('permissions',[PermissionController::class,'index']);

    /** admin settings update **/
    Route::view('edit-profile','dashboard.admins.edit-profile')->name('edit-profile');
    Route::put('update-profile', [AdminController::class, 'updateProfile'])->name('update-profile');
    Route::put('update-password', [AdminController::class, 'updatePassword'])->name('update-password');
    /** admin settings update **/

    /** Trash routes */
    Route::get('trash/{modelName?}','TrashController@index')->name('trash');
    Route::get('trash/{modelName}/{id}','TrashController@restore');
    Route::delete('trash/{modelName}/{id}','TrashController@forceDelete');
    /** Trash routes */

});
/** authenticated routes **/


/** preferences routes **/
Route::get('/language/{lang}', function ($lang) {
    session()->put('locale', $lang);
    return redirect()->back();

})->name('change-language')->middleware('web');

/** preferences routes **/


