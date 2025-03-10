<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

Route::get('/buildings', [BuildingController::class, 'index']);
Route::post('/buildings', [BuildingController::class, 'store']);
Route::get('/buildings/{id}', [BuildingController::class, 'show']);
Route::put('/buildings/{id}', [BuildingController::class, 'update']);
Route::delete('/buildings/{id}', [BuildingController::class, 'destroy']);

Route::get('/tasks', [TaskController::class, 'index']); // Lista todas as tarefas com filtros
Route::post('/tasks', [TaskController::class, 'store']); // Criar nova tarefa
Route::get('/tasks/{id}', [TaskController::class, 'show']); // Buscar tarefa específica
Route::put('/tasks/{id}', [TaskController::class, 'update']); // Atualizar tarefa
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // Remover tarefa

Route::get('/tasks/{taskId}/comments', [CommentController::class, 'index']); // Listar comentários de uma tarefa
Route::post('/tasks/{taskId}/comments', [CommentController::class, 'store']); // Criar novo comentário
Route::get('/tasks/{taskId}/comments/{commentId}', [CommentController::class, 'show']); // Buscar comentário específico
Route::put('/tasks/{taskId}/comments/{commentId}', [CommentController::class, 'update']); // Atualizar comentário
Route::delete('/tasks/{taskId}/comments/{commentId}', [CommentController::class, 'destroy']); // Remover comentário
