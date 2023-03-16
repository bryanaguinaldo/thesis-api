<?php

use App\Http\Controllers\EntriesController;
use App\Http\Controllers\FunctionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/entries', EntriesController::class);
Route::post('/entries/update/{entry}', [EntriesController::class, 'update'])->name('entries.update');
Route::post('/verify/{entry}', [FunctionsController::class, 'verify'])->name('functions.verify');
Route::get('/verify/server_validity', [FunctionsController::class, 'isValid'])->name('functions.verify');