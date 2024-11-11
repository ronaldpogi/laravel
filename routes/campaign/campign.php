<?php

use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::controller(CampaignController::class)->prefix('campaign')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('campaign.restore');
    Route::get('/options', 'get_options')->name('campaign.option');
});

Route::apiResource('/campaign',CampaignController::class);