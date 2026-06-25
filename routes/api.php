<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\LeadNoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('leads', LeadController::class);

    Route::patch('leads/{lead}/assign', [LeadController::class, 'assign']);
    Route::patch('leads/{lead}/status', [LeadController::class, 'updateStatus']);

    Route::get('leads/{lead}/notes', [LeadNoteController::class, 'index']);
    Route::post('leads/{lead}/notes', [LeadNoteController::class, 'store']);
});
