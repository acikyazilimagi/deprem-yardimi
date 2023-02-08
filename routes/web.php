<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  DashboardController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('/')->group(function () {
  Route::get("/", [DashboardController::class, "index"])->name("dashboard");
  Route::get("/liste", [DashboardController::class, "list"])->name("dashboard.list");
  Route::get("/datatable", [DashboardController::class, "datatable"])->name("dashboard.datatable");
  Route::post("/store", [DashboardController::class, "store"])->name("dashboard.store")->middleware(['auth-token-without-user']);
});
Route::post("get_district", [DashboardController::class, "get_district"])->name("get_district");
Route::post("get_street", [DashboardController::class, "get_street"])->name("get_street");

Route::get('get-token', function (){
    return response()->json(['status' => true]);
})->name('get-token')->middleware(['auth-token-without-user']);
