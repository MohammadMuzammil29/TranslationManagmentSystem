<?php

use App\Http\Controllers\Api\Authentication\AuthenticationController;
use App\Http\Controllers\Api\TranslationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('translations-export', [TranslationController::class, 'export']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/translations', [TranslationController::class, 'store']);
    Route::get('/get-translations', [TranslationController::class, 'get']);
    Route::put('/update-translations/{id}', [TranslationController::class, 'update']);
    Route::get('/translations-search', [TranslationController::class, 'search']);
});
