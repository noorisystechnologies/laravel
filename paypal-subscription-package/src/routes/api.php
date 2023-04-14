<?php

use Noorisys\PaypalSubscription\Controllers\api\PayPalController;
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

Route::post('subscribe' , [PayPalController::class, 'subscribe']);
Route::any('success' , [PayPalController::class, 'success']);
Route::any('cancel' , [PayPalController::class, 'cancel']);
Route::any('webhook' , [PayPalController::class, 'webhook']);