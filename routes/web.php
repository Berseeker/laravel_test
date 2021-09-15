<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WEB\Dashboard\DashboardController;
use App\Http\Controllers\WEB\Auth\VerifyEmailController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/very-email',[VerifyEmailController::class,'index'])->name('verify.email.custom');
Route::get('/dashboard',function(){ dd('dashboard');})->name('dashboard');
Route::get('/request-verify-email',[VerifyEmailController::class,'verify'])->name('verification.notice');
//Route::get('login');

Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->name('home');
