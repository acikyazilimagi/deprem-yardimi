<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
  DashboardController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/list", [DashboardController::class, "index"])->name("api.list")->middleware(['auth-token-without-user']);
Route::get("/list-all", [DashboardController::class, "list_all"])->name("api.list_all")->middleware(['auth-token-without-user']);
