<?php

use App\Http\Controllers\Api\Ad\AdController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('/ad-list')->group(function () {

            Route::post('/items/edit', [AdController::class, 'updateAd']);
            Route::post('/items/add', [AdController::class, 'createAd']);
            Route::get('/items', [AdController::class, 'list']);

        });
    });
});
