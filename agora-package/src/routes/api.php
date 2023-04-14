<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Noorisys\Agora\Controllers\AgoraController;

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

Route::post('generate-token' , [AgoraController::class, 'generateToken'])->name('generate-token');
Route::post('save-call' , [AgoraController::class, 'callHistory'])->name('save-call');
