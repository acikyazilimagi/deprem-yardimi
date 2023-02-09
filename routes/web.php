<?php

use App\Http\Controllers\Web\ContentController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard.index');

Route::group(['as' => 'help.'], function (){
    Route::get('/yardim-isteyenler', [\App\Http\Controllers\Web\HelpController::class, 'index'])->name('index');
    Route::get('/help/datatable', [\App\Http\Controllers\Web\HelpController::class, 'datatable'])->name('datatable');
});

Route::group(['prefix' => 'security', 'as' => 'security.'], function (){
    Route::get('/get-token', \App\Http\Controllers\SecurityController::class)->name('get-token')->middleware(['auth-token-without-user']);
});

Route::group(['prefix' => '', 'as' => 'filter.'], function (){
    Route::get('/filtre', [\App\Http\Controllers\Web\FilterController::class, 'index'])->name('index');
    Route::post('/filter', [\App\Http\Controllers\Web\FilterController::class, 'filter'])->name('filter');
});

// TODO : Devam edilmeli veya projedeki tüm kalıntıları silinmeli.
Route::prefix('icerik')->group(function () {
    Route::get('/', [ContentController::class, 'index'])->name('icerik');
    Route::get('/gecici-barinma-alanlari', [ContentController::class, 'geciciBarinma'])->name('icerik.gecici-barinma-alanlari');
});

