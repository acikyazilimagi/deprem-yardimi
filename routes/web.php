<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/liste', [DashboardController::class, 'list'])->name('dashboard.list');
    Route::get('/datatable', [DashboardController::class, 'datatable'])->name('dashboard.datatable');
    Route::get('/yardim-isteyenler', [DashboardController::class, 'fast_search'])->name('fast_search');
});
Route::post('get_district', [DashboardController::class, 'get_district'])->name('get_district');
Route::post('get_street', [DashboardController::class, 'get_street'])->name('get_street');

Route::get('get-token', function () {
    return response()->json(['status' => true]);
})->name('get-token')->middleware(['auth-token-without-user']);

//Icerik Routes
Route::prefix('icerik')->group(function () {
    Route::get('/', [ContentController::class, 'index'])->name('icerik');
    Route::get('/gecici-barinma-alanlari', [ContentController::class, 'geciciBarinma'])->name('icerik.gecici-barinma-alanlari');
});

Route::get('/filtre', [\App\Http\Controllers\FilterController::class, 'index'])->name('filter.index');
