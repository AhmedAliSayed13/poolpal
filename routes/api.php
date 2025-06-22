<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\SidingController;
use App\Http\Controllers\API\PoolController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\Test\TestController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::POST('test-water', [TestController::class, 'testWater']);
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::get('/medias', [MediaController::class, 'index']);
    Route::get('/sidings', [SidingController::class, 'index']);
    Route::apiResource('pools', PoolController::class);
    Route::get('test-data', [TestController::class, 'getData']);

    Route::apiResource('tests', TestController::class)->only([
        'store',
        'show',
        'index'
    ]);
});
