<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}/{broker}', function (string $token , string $broker) {
    return view('auth.reset-password', ['token' => $token , 'broker' => $broker]);
})->middleware('guest:superAdmin')->name('password.reset');

Route::post('/reset-password',[ResetPasswordController::class , 'reset'])->name('password.update');

