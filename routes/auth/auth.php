<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::controller(RegisterController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register')->name('campaign.option');
    Route::post('login', 'login')->name('campaign.option');
});
