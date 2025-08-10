<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\SidingController;
use App\Http\Controllers\API\PoolController;
use App\Http\Controllers\API\Task\TaskController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\StripeController;
use App\Http\Controllers\API\Test\TestController;
use App\Http\Controllers\API\slider\SliderController;
use App\Http\Controllers\API\notification\NotificationController;
use App\Http\Controllers\API\RequestService\RequestServiceController;
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

Route::middleware('wp.jwt')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');


Route::POST('test-water', [TestController::class, 'testWater']);
Route::middleware(['wp.jwt'])->group(function () {
    Route::get('about', [RequestServiceController::class, 'about']);
    Route::get('contact', [RequestServiceController::class, 'contact']);
    Route::get('privacy', [RequestServiceController::class, 'privacy']);
    Route::post('request-service', [RequestServiceController::class, 'store']);
    Route::get('/medias', [MediaController::class, 'index']);
    Route::get('/sidings', [SidingController::class, 'index']);
    Route::apiResource('pools', PoolController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::get('test-data', [TestController::class, 'getData']);

    Route::apiResource('tests', TestController::class)->only([
        'store',
        'show',
        'index',
    ]);
    Route::apiResource('sliders', SliderController::class);

    Route::apiResource('notifications', NotificationController::class)->only([
        'index',
        'show'
    ]);

    Route::post('checkout', [StripeController::class, 'checkout'])->name(
        'checkout'
    );
});

Route::get('checkout/cancel', [StripeController::class, 'paymentCancel'])->name('checkout.cancel');
Route::get('checkout/success', [StripeController::class,'paymentSuccess'])->name('checkout.success');

Route::post('admin/notification', [StripeController::class,'sendNotification'])->name('notification');
Route::post('admin/notification/many', [StripeController::class,'sendNotificationMany'])->name('notificationMany');

