<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}/{broker}', function (string $token , string $broker) {
    return view('auth.reset-password', ['token' => $token , 'broker' => $broker]);
})->middleware('guest:superAdmin')->name('password.reset');

Route::post('/reset-password',[ResetPasswordController::class , 'reset'])->name('password.update');

