<?php

use Illuminate\Support\Facades\Route;
use Socialogin\Linkedin\Controllers\LinkedinController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('auth/linkedin', [LinkedinController::class, 'linkedinRedirect']);
Route::get('auth/linkedin/callback', [LinkedinController::class, 'linkedinCallback']);