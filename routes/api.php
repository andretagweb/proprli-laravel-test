<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/buildings', [BuildingController::class, 'index']);
Route::post('/buildings', [BuildingController::class, 'store']);

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);

Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);


