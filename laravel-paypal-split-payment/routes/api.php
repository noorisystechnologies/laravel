<?php

use App\Http\Controllers\api\PaypalController;
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

Route::prefix('paypal')->group(function () {
    Route::any('createPayment' , [PaypalController::class, 'createPayout']);
    Route::any('paymentSuccess' , [PayPalController::class, 'paymentSuccess'])->name('paymentSuccess');
    Route::any('paymentFail' , [PayPalController::class, 'paymentFail'])->name('paymentFail');
    Route::any('createBatchPayout' , [PayPalController::class, 'createBatchPayout'])->name('createBatchPayout');

});