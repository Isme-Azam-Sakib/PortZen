<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkExperienceController;

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

// Work Experience API Routes
Route::middleware('auth:web')->group(function () {
    Route::get('/experiences/{experience}', [WorkExperienceController::class, 'show']);
    Route::post('/experiences', [WorkExperienceController::class, 'store']);
    Route::put('/experiences/{experience}', [WorkExperienceController::class, 'update']);
    Route::delete('/experiences/{experience}', [WorkExperienceController::class, 'destroy']);
});
