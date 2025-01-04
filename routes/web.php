<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\ElementController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes(['register' => false]);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/change-country', [SettingController::class, 'changeCountry']);


Route::group(['prefix' => 'admin/', 'as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('/', [PanelController::class, 'index'])->name('index');
    Route::get('/profile', [PanelController::class, 'profile'])->name('profile');
    Route::post('/profile', [PanelController::class, 'updateProfile'])->name('update.profile');

    /**Manage Categories */
    Route::group(['prefix' => 'network/', 'as' => 'network.'], function () {
        Route::get('/', [FeatureController::class, 'getNetwork'])->name('index');
        Route::put('/update/{id}', [FeatureController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'features/', 'as' => 'features.'], function () {
        Route::get('/', [FeatureController::class, 'getFeatures'])->name('index');
        Route::put('/update/{id}', [FeatureController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'nfc/', 'as' => 'nfc.'], function () {
        Route::get('/', [FeatureController::class, 'getNfc'])->name('index');
        Route::put('/update/{id}', [FeatureController::class, 'update'])->name('update');
    });

    // /**Manage FAQs */
    // Route::group(['prefix' => 'faqs/', 'as' => 'faqs.'], function () {
    //     Route::get('/', [FaqController::class, 'index'])->name('index');
    //     Route::post('/store', [FaqController::class, 'store'])->name('store');
    //     Route::put('/update/{id}', [FaqController::class, 'update'])->name('update');
    //     Route::delete('/delete/{id}', [FaqController::class, 'delete'])->name('delete');
    // });
   
    /**Manage Settings */
    Route::group(['prefix' => 'settings/', 'as' => 'settings.'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/update', [SettingController::class, 'update'])->name('update');
    });
    //islam category
  Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    Route::post('/active/{id}', [CategoryController::class, 'active'])->name('active');
});
//user //islam
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/country', [UserController::class, 'usersCountry'])->name('usersCountry');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    // Route::post('/active/{id}', [UserController::class, 'active'])->name('active');
});
//islam //packages
Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
    Route::get('/', [PackageController::class, 'index'])->name('index');
    Route::put('/update/{id}', [PackageController::class, 'update'])->name('update');
    Route::post('packages/{package}/link-elements', [PackageController::class, 'linkElements'])->name('linkElements');

    
});
//islam // currencies
Route::group(['prefix' => 'currencies', 'as' => 'currencies.'], function () {
    Route::get('/', [CurrencyController::class, 'index'])->name('index');
    Route::post('/store', [CurrencyController::class, 'store'])->name('store');
    Route::put('/update/{id}', [CurrencyController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CurrencyController::class, 'delete'])->name('delete');
    Route::post('/active/{id}', [CurrencyController::class, 'active'])->name('active');
});
//islam //elements
Route::group(['prefix' => 'elements', 'as' => 'elements.'], function () {
    Route::get('/', [ElementController::class, 'index'])->name('index');
    Route::post('/store', [ElementController::class, 'store'])->name('store');
    Route::put('/update/{id}', [ElementController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ElementController::class, 'delete'])->name('delete');

});
Route::group(['prefix' => 'stores', 'as' => 'stores.'], function () {
    Route::get('/', [StoreController::class, 'index'])->name('index');
    // Route::get('create', [StoreController::class, 'create'])->name('create');
    // Route::post('store', [StoreController::class, 'store'])->name('store');
    Route::get('{id}/details', [StoreController::class, 'details'])->name('details');
    Route::get('{id}/branches', [StoreController::class, 'branches'])->name('branches');
    Route::get('{id}/departments', [StoreController::class, 'departments'])->name('departments');
    Route::post('{id}/status', [StoreController::class, 'status'])->name('status');
    Route::put('{id}', [StoreController::class, 'update'])->name('update');
    Route::delete('{id}', [StoreController::class, 'delete'])->name('delete');
});

});

