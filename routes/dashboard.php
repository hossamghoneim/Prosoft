<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ServiceHeroSectionController;
use App\Http\Controllers\Dashboard\CarModelController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ServiceBannerSectionController;
use App\Http\Controllers\Dashboard\ServiceSectionController;
use App\Http\Controllers\Dashboard\ServiceSectionItemController;
use App\Http\Controllers\Dashboard\PartnershipHeroSectionController;
use App\Http\Controllers\Dashboard\PartnershipSectionController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\PartnerBannerSectionController;
use App\Http\Controllers\Dashboard\PartnerBannerSectionItemController;
use App\Http\Controllers\Dashboard\ContactUsContentController;
use App\Http\Controllers\Dashboard\ContactUsSectionController;
use App\Http\Controllers\Dashboard\ContactInquiryController;
use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\Dashboard\AboutUsHeroSectionController;
use App\Http\Controllers\Dashboard\AboutUsFeatureController;
use App\Http\Controllers\Dashboard\AboutUsFeatureItemController;
use App\Http\Controllers\Dashboard\AboutUsMiddleSectionController;
use App\Http\Controllers\Dashboard\AboutUsMiddleSectionItemController;
use App\Http\Controllers\Dashboard\AboutUsFinalSectionController;
use App\Http\Controllers\Dashboard\AboutUsFinalSectionItemController;
use App\Http\Controllers\Dashboard\AboutUsBannerSectionController;
use App\Http\Controllers\Dashboard\HomeHeroSectionController;
use App\Http\Controllers\Dashboard\HomePrimarySectionController;
use App\Http\Controllers\Dashboard\HomeSecondarySectionController;
use App\Http\Controllers\Dashboard\SolutionController;
use App\Http\Controllers\Dashboard\SolutionHeroSectionController;
use App\Http\Controllers\Dashboard\SolutionMainSectionController;
use App\Http\Controllers\Dashboard\SolutionMainSectionItemController;
use App\Http\Controllers\Dashboard\SolutionMainSectionItemContentController;
use App\Http\Controllers\Dashboard\SolutionMiddleSectionController;
use App\Http\Controllers\Dashboard\TermsConditionHeroSectionController;
use App\Http\Controllers\Dashboard\TermsConditionItemController;
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
    Route::resource('service-hero-sections',ServiceHeroSectionController::class);
    Route::get('service-banner-sections/check-exists',[ServiceBannerSectionController::class, 'checkExists'])->name('service-banner-sections.check-exists');
    Route::resource('service-banner-sections',ServiceBannerSectionController::class);
    Route::get('service-sections/check-exists',[ServiceSectionController::class, 'checkExists'])->name('service-sections.check-exists');
    Route::resource('service-sections',ServiceSectionController::class);
    Route::get('service-section-items/check-exists', [ServiceSectionItemController::class, 'checkExists'])->name('service-section-items.check-exists');
    Route::resource('service-section-items',ServiceSectionItemController::class);
    Route::get('partnership-hero-sections/check-exists', [PartnershipHeroSectionController::class, 'checkExists'])->name('partnership-hero-sections.check-exists');
    Route::resource('partnership-hero-sections',PartnershipHeroSectionController::class);
    Route::get('partnership-sections/check-exists', [PartnershipSectionController::class, 'checkExists'])->name('partnership-sections.check-exists');
    Route::resource('partnership-sections',PartnershipSectionController::class);
    Route::get('partners/check-exists', [PartnerController::class, 'checkExists'])->name('partners.check-exists');
    Route::resource('partners',PartnerController::class);
    Route::get('partner-banner-sections/check-exists', [PartnerBannerSectionController::class, 'checkExists'])->name('partner-banner-sections.check-exists');
    Route::resource('partner-banner-sections',PartnerBannerSectionController::class);
    Route::get('partner-banner-section-items/check-exists', [PartnerBannerSectionItemController::class, 'checkExists'])->name('partner-banner-section-items.check-exists');
    Route::resource('partner-banner-section-items',PartnerBannerSectionItemController::class);
    Route::get('contact-us-contents/check-exists', [ContactUsContentController::class, 'checkExists'])->name('contact-us-contents.check-exists');
    Route::resource('contact-us-contents',ContactUsContentController::class);
    Route::get('contact-us-sections/check-exists', [ContactUsSectionController::class, 'checkExists'])->name('contact-us-sections.check-exists');
    Route::resource('contact-us-sections',ContactUsSectionController::class);
    Route::resource('contact-inquiries',ContactInquiryController::class);
    Route::get('locations/check-exists', [LocationController::class, 'checkExists'])->name('locations.check-exists');
    Route::resource('locations',LocationController::class);
    Route::get('about-us-hero-sections/check-exists', [AboutUsHeroSectionController::class, 'checkExists'])->name('about-us-hero-sections.check-exists');
    Route::resource('about-us-hero-sections',AboutUsHeroSectionController::class);
    Route::get('about-us-features/check-exists', [AboutUsFeatureController::class, 'checkExists'])->name('about-us-features.check-exists');
    Route::resource('about-us-features',AboutUsFeatureController::class);
    Route::get('about-us-feature-items/check-exists', [AboutUsFeatureItemController::class, 'checkExists'])->name('about-us-feature-items.check-exists');
Route::resource('about-us-feature-items',AboutUsFeatureItemController::class);
Route::get('about-us-middle-sections/check-exists', [AboutUsMiddleSectionController::class, 'checkExists'])->name('about-us-middle-sections.check-exists');
Route::resource('about-us-middle-sections',AboutUsMiddleSectionController::class);
Route::get('about-us-middle-section-items/check-exists', [AboutUsMiddleSectionItemController::class, 'checkExists'])->name('about-us-middle-section-items.check-exists');
Route::resource('about-us-middle-section-items',AboutUsMiddleSectionItemController::class);
Route::get('about-us-final-sections/check-exists', [AboutUsFinalSectionController::class, 'checkExists'])->name('about-us-final-sections.check-exists');
Route::resource('about-us-final-sections',AboutUsFinalSectionController::class);
Route::get('about-us-final-section-items/check-exists', [AboutUsFinalSectionItemController::class, 'checkExists'])->name('about-us-final-section-items.check-exists');
Route::resource('about-us-final-section-items',AboutUsFinalSectionItemController::class);
    Route::get('about-us-banner-sections/check-exists', [AboutUsBannerSectionController::class, 'checkExists'])->name('about-us-banner-sections.check-exists');
    Route::resource('about-us-banner-sections',AboutUsBannerSectionController::class);
    Route::get('home-hero-sections/check-exists', [HomeHeroSectionController::class, 'checkExists'])->name('home-hero-sections.check-exists');
    Route::resource('home-hero-sections',HomeHeroSectionController::class);
    Route::get('home-primary-sections/check-exists', [HomePrimarySectionController::class, 'checkExists'])->name('home-primary-sections.check-exists');
    Route::resource('home-primary-sections',HomePrimarySectionController::class);
    Route::get('home-secondary-sections/check-exists', [HomeSecondarySectionController::class, 'checkExists'])->name('home-secondary-sections.check-exists');
    Route::resource('home-secondary-sections',HomeSecondarySectionController::class);
    Route::resource('solutions',SolutionController::class);
Route::get('solution-hero-sections/check-exists', [SolutionHeroSectionController::class, 'checkExists'])->name('solution-hero-sections.check-exists');
Route::resource('solution-hero-sections',SolutionHeroSectionController::class);
Route::get('solution-main-sections/check-exists', [SolutionMainSectionController::class, 'checkExists'])->name('solution-main-sections.check-exists');
Route::resource('solution-main-sections',SolutionMainSectionController::class);
Route::get('solution-main-section-items/check-exists', [SolutionMainSectionItemController::class, 'checkExists'])->name('solution-main-section-items.check-exists');
Route::resource('solution-main-section-items',SolutionMainSectionItemController::class);
Route::get('solution-main-section-item-contents/check-exists', [SolutionMainSectionItemContentController::class, 'checkExists'])->name('solution-main-section-item-contents.check-exists');
Route::resource('solution-main-section-item-contents', SolutionMainSectionItemContentController::class)->parameters(['solution-main-section-item-contents' => 'content']);
Route::get('solution-middle-sections/check-exists', [SolutionMiddleSectionController::class, 'checkExists'])->name('solution-middle-sections.check-exists');
Route::resource('solution-middle-sections',SolutionMiddleSectionController::class);
Route::get('terms-condition-hero-sections/check-exists', [TermsConditionHeroSectionController::class, 'checkExists'])->name('terms-condition-hero-sections.check-exists');
Route::resource('terms-condition-hero-sections',TermsConditionHeroSectionController::class);
Route::get('terms-condition-items/check-exists', [TermsConditionItemController::class, 'checkExists'])->name('terms-condition-items.check-exists');
Route::resource('terms-condition-items',TermsConditionItemController::class);
    // Route::resource('car-models',CarModelController::class);
    // Route::resource('products',ProductController::class);
    // Route::resource('tags',TagController::class);
    // Route::resource('users',UserController::class)->only(['index', 'destroy']);
    // Route::resource('categories',CategoryController::class)->except(['edit','create']);
    // Route::resource('orders',OrderController::class);
    // Route::post('change-status/{order}',[OrderController::class, 'changeStatus']);
    Route::get('settings',[SettingController::class,'index'])->name('settings.index');
    Route::put('settings',[SettingController::class,'update'])->name('settings.update');
    Route::get('permissions',[PermissionController::class,'index']);

    /** admin settings update **/
    Route::view('edit-profile','dashboard.admins.edit-profile')->name('edit-profile');
    Route::put('update-profile', [AdminController::class, 'updateProfile'])->name('update-profile');
    Route::put('update-password', [AdminController::class, 'updatePassword'])->name('update-password');
    /** admin settings update **/

    /** Trash routes */
    // Route::get('trash/{modelName?}','TrashController@index')->name('trash');
    // Route::get('trash/{modelName}/{id}','TrashController@restore');
    // Route::delete('trash/{modelName}/{id}','TrashController@forceDelete');
    /** Trash routes */

});
/** authenticated routes **/


/** preferences routes **/
Route::get('/language/{lang}', function ($lang) {
    session()->put('locale', $lang);
    return redirect()->back();

})->name('change-language')->middleware('web');

/** preferences routes **/


