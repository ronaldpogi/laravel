<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\RegisterController;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::apiResource('campaign', CampaignController::class);

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('campaign', CampaignController::class);
});