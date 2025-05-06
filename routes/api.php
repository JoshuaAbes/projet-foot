<?php

use App\Http\Controllers\Api\V1\StoryController;
use App\Http\Controllers\Api\V1\ChapterController;
use App\Http\Controllers\Api\V1\ChoiceController;
use App\Http\Controllers\Api\V1\StoryProgressionController;
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

// API Version 1
Route::prefix('api/v1')->group(function () {
    // Routes publiques
    Route::get('/stories', [StoryController::class, 'index']);
    Route::get('/stories/{story}', [StoryController::class, 'show']);
    Route::get('/chapters/{chapter}', [ChapterController::class, 'show']);
    
    // Authentication routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Story routes
        Route::post('/stories', [StoryController::class, 'store']);
        Route::put('/stories/{story}', [StoryController::class, 'update']);
        Route::delete('/stories/{story}', [StoryController::class, 'destroy']);
        
        // Chapter routes
        Route::get('/stories/{story}/chapters', [ChapterController::class, 'index']);
        Route::post('/chapters', [ChapterController::class, 'store']);
        Route::put('/chapters/{chapter}', [ChapterController::class, 'update']);
        Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy']);
        
        // Choice routes
        Route::get('/chapters/{chapter}/choices', [ChoiceController::class, 'index']);
        Route::post('/choices', [ChoiceController::class, 'store']);
        Route::put('/choices/{choice}', [ChoiceController::class, 'update']);
        Route::delete('/choices/{choice}', [ChoiceController::class, 'destroy']);
        
        // Progression routes
        Route::get('/progressions', [StoryProgressionController::class, 'index']);
        Route::post('/progressions', [StoryProgressionController::class, 'store']);
        Route::put('/progressions/{progression}', [StoryProgressionController::class, 'update']);
    });
});