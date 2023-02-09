<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'location', 'as' => 'location.'], function (){
    Route::post('/district', [\App\Http\Controllers\Api\LocationController::class, 'districts'])->name('districts')->middleware(['auth-token-without-user']);
    Route::post('/street', [\App\Http\Controllers\Api\LocationController::class, 'streets'])->name('streets')->middleware(['auth-token-without-user']);
});
