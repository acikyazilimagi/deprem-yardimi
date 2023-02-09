<?php

use Illuminate\Support\Facades\Route;

Route::get('/list', [\App\Http\Controllers\Api\DashboardController::class, 'index'])->name('api.list')->middleware(['auth-token-without-user']);
Route::get('/list-all', [\App\Http\Controllers\Api\DashboardController::class, 'list_all'])->name('api.list_all')->middleware(['auth-token-without-user']);

Route::group(['prefix' => 'location', 'as' => 'location.'], function () {
    Route::post('/district', [\App\Http\Controllers\Api\LocationController::class, 'districts'])->name('districts')->middleware(['auth-token-without-user']);
    Route::post('/street', [\App\Http\Controllers\Api\LocationController::class, 'streets'])->name('streets')->middleware(['auth-token-without-user']);
});
