<?php

use App\Http\Controllers\Panel\SubscriptionController;
use App\Http\Controllers\User\ActivityController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\BranchController;
use App\Http\Controllers\User\BranchNumberController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\CityController;
use App\Http\Controllers\User\ContactUsController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\DepartmentController;
use App\Http\Controllers\User\FeatureController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LinkController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\OfferController;
use App\Http\Controllers\User\PackageController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\User\WorkingHourController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/contact-us', [ContactUsController::class, 'store']);
//google back
Route::get('/google',[AuthController::class,'redirectToGoogle']);
Route::get('/auth/google/callback',[AuthController::class,'handleGoogleCallback']);
//google front
Route::post('/google/login',[AuthController::class,'googleAuth']);


Route::middleware(['localization'])->group(function () {
    //Auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::prefix('otp')->group(function () {
        Route::post('/send', [AuthController::class, 'send']);
        Route::post('/verify', [AuthController::class, 'verify']);
    });

    Route::middleware(['custom.auth:user'])->group(function () {
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::prefix('profile')->group(function () {
            Route::get('/', [AuthController::class, 'profile']);
            Route::put('/', [AuthController::class, 'updateProfile']);
            Route::delete('/', [AuthController::class, 'deleteProfile']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);
            Route::put('/language', [AuthController::class, 'updateProfile']);
        });

        Route::prefix('panel')->group(function () {

            Route::get('/home', [HomeController::class, 'getPanel']);
            Route::get('/cities', [CityController::class, 'index']);
            Route::get('/countries', [CountryController::class, 'index']);
            Route::get('/packages', [PackageController::class, 'index']);
            Route::get('/categories', [CategoryController::class, 'index']);

            Route::prefix('subscription')->group(function () {
                Route::get('/', [SubscriptionController::class, 'index']);
                Route::post('/new', [SubscriptionController::class, 'new']);
            });
            Route::prefix('store')->group(function () {
                Route::get('/', [StoreController::class, 'index']);
                Route::post('/', [StoreController::class, 'store']);
                Route::put('/{id}', [StoreController::class, 'update']);
                Route::post('/images/delete', [StoreController::class, 'deleteImages']);
            });
            Route::prefix('branches')->group(function () {
                Route::get('/{id?}', [BranchController::class, 'index']);
                Route::post('/', [BranchController::class, 'store']);
                Route::put('/{id}', [BranchController::class, 'update']);
                Route::delete('/{id}', [BranchController::class, 'delete']);
                Route::prefix('{branch_id}/working-hours')->group(function () {
                    Route::get('/', [WorkingHourController::class, 'index']);
                    Route::put('/', [WorkingHourController::class, 'update']);
                });
                Route::prefix('{branch_id}/numbers')->group(function () {
                    Route::get('/', [BranchNumberController::class, 'index']);
                    Route::post('/', [BranchNumberController::class, 'store']);
                    Route::put('/{id}', [BranchNumberController::class, 'update']);
                    Route::delete('/{id}', [BranchNumberController::class, 'delete']);
                });
            });
            Route::prefix('links')->group(function () {
                Route::get('/types', [LinkController::class, 'getTypes']);
                Route::get('/library', [LinkController::class, 'getLibrary']);
                Route::get('/', [LinkController::class, 'index']);
                Route::post('/', [LinkController::class, 'store']);
                Route::put('/{id}', [LinkController::class, 'update']);
                Route::delete('/{id}', [LinkController::class, 'delete']);
            });
            Route::prefix('departments')->group(function () {
                Route::get('/{id?}', [DepartmentController::class, 'index']);
                Route::post('/', [DepartmentController::class, 'store']);
                Route::put('/{id}', [DepartmentController::class, 'update']);
                Route::delete('/{id}', [DepartmentController::class, 'delete']);
            });
            Route::prefix('products')->group(function () {
                Route::get('/{id?}', [ProductController::class, 'index']);
                Route::post('/', [ProductController::class, 'store']);
                Route::put('/{id}', [ProductController::class, 'update']);
                Route::delete('/{id}', [ProductController::class, 'delete']);
            });
            Route::prefix('offers')->group(function () {
                Route::get('/{id?}', [OfferController::class, 'index']);
                Route::post('/', [OfferController::class, 'store']);
                Route::put('/{id}', [OfferController::class, 'update']);
                Route::delete('/{id}', [OfferController::class, 'delete']);
            });
            Route::prefix('ratings')->group(function () {
                Route::get('/', [RatingController::class, 'index']);
            });
            Route::prefix('messages')->group(function () {
                Route::get('/', [MessageController::class, 'index']);
            });
            Route::prefix('activities')->group(function () {
                Route::get('/', [ActivityController::class, 'index']);
            });
            Route::prefix('settings')->group(function () {
                Route::get('/', [SettingController::class, 'index']);
                Route::put('/', [SettingController::class, 'update']);
            });
            Route::prefix('features')->group(function () {
                Route::get('/', [FeatureController::class, 'index']);
                Route::put('/effect-button', [FeatureController::class, 'updateEffectButton']);
                Route::put('/introduction-screen', [FeatureController::class, 'updateIntroductionScreen']);
                Route::put('/ad-bar', [FeatureController::class, 'updateAdBar']);
                Route::put('/background-image', [FeatureController::class, 'updateBackgroundImage']);
            });
        });


        //User App

    });
});
