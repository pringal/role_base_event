<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('/events/store', [EventController::class, 'store'])->name('create-events');
    Route::post('/events/update', [EventController::class, 'update'])->name('edit-events');
    Route::post('/events/delete', [EventController::class, 'destroy'])->name('delete-events');
    Route::post('/events/show', [EventController::class, 'show'])->name('view-events');
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin|buyer']], function () {
    Route::post('/events/search', [EventController::class, 'search'])->name('search-events');
});
