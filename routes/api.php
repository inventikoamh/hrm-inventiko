<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Theme Management API Routes
Route::post('/theme/toggle', [App\Http\Controllers\Api\ThemeController::class, 'toggle']);
Route::get('/theme/mode', [App\Http\Controllers\Api\ThemeController::class, 'getMode']);

// Lead Management API Routes
Route::prefix('leads')->group(function () {
    Route::get('/', [LeadController::class, 'index'])->name('api.leads.index');
    Route::post('/', [LeadController::class, 'store'])->name('api.leads.store');
    Route::get('/{lead}', [LeadController::class, 'show'])->name('api.leads.show');
    Route::post('/{lead}/convert-to-client', [LeadController::class, 'convertToClient'])->name('api.leads.convert-to-client');
});
