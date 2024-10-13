<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\v1'], function () {
    Route::apiResource('book', BookController::class)->only(['index', 'show']); 
    Route::apiResource('review', ReviewController::class)->only(['index', 'show']); 
    
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\v1'], function () {
        Route::apiResource('book', BookController::class)->except(['index', 'show']);
        Route::apiResource('review', ReviewController::class)->except(['index', 'show']); 
        
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});