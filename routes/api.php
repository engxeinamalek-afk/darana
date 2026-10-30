<?php

use App\Http\Controllers\V1\Customer\PropertyController as V1CustomerPropertyController;
use App\Http\Controllers\V1\Office\PropertyController as V1OfficePtopertyController;

use App\Http\Controllers\V2\Office\PropertyController as V2OfficePropertyController;
use App\Http\Controllers\V2\Customer\PropertyController as V2CustomerPropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Office\ImageController as V1ImageController;
use App\Http\Controllers\V2\Office\ImageController as V2ImageController;
use App\Http\Controllers\V1\Customer\CityController as V1CityController;
use App\Http\Controllers\V2\Customer\CityController as V2CityController;
// Route::get('/cache', [OfficePropertyController::class, 'checkCache']);

Route::prefix('V1')->middleware('auth:sanctum')->group(function(){
    Route::prefix('office')->middleware('role:office')->group(function(){
        // العقارات
        Route::get('/properties', [V1OfficePtopertyController::class, 'index']);
        Route::get('/properties/{office_property}', [V1OfficePtopertyController::class, 'show']);
        Route::post('/properties', [V1OfficePtopertyController::class, 'store']);
        Route::patch('/properties/{office_property}/status', [V1OfficePtopertyController::class, 'updateStatus']);
        Route::patch('/properties/{office_property}/is_featured', [V1OfficePtopertyController::class, 'toggleFeatured']);

        // الصور
        Route::post('/images/{imageable_type}/{imageable}',[V1ImageController::class, 'store']);

    });

    Route::prefix('customer')->middleware('role:customer')->group(function(){
        // العقارات
        Route::get('/properties', [V1CustomerPropertyController::class, 'index']);
        Route::get('/properties/{property}/show', [V1CustomerPropertyController::class, 'show']);
        Route::get('/properties/featured', [V1CustomerPropertyController::class, 'getFeaturedProperties']);

        // عدد العقارات في المدينة
        Route::get('/cities/{city}/count', [V1CityController::class, 'getCount']);
    });
});

Route::prefix('V2')->middleware('auth:sanctum')->group(function(){
    Route::prefix('office')->middleware('role:office')->group(function(){
        // العقارات
        Route::get('/properties', [V2OfficePropertyController::class, 'index']);
        Route::get('/properties/{office_property}', [V2OfficePropertyController::class, 'show']);
        Route::post('/properties', [V2OfficePropertyController::class, 'store']);
        Route::patch('/properties/status', [V2OfficePropertyController::class, 'updateStatus']);
        Route::patch('/properties/is_featured', [V2OfficePropertyController::class, 'toggleFeatured']);

        // الصور
        Route::post('/images/{imageable_type}/{imageable}',[V2ImageController::class, 'store']);

    });

    Route::prefix('customer')->middleware('role:customer')->group(function(){
        // العقارات
        Route::get('/properties', [V2CustomerPropertyController::class, 'index']);
        Route::get('/properties/{property}/show', [V2CustomerPropertyController::class, 'show']);
        Route::get('/properties/featured', [V2CustomerPropertyController::class, 'getFeaturedProperties']);

        // عدد العقارات في المدينة
        Route::get('/cities/{city}/count', [V2CityController::class, 'getCount']);
    });
});