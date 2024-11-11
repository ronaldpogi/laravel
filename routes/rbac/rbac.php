<?php

use App\Http\Controllers\RbacController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;

Route::controller(RbacController::class)->prefix('rbac')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('rbac.restore');
    Route::get('/options', 'get_options')->name('rbac.option');
    Route::put('/permission/{id}', 'update_role_permission')->name('rbac.permission.update');
});

Route::apiResource('/rbac',RbacController::class);
