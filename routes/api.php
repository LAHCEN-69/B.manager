<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
    Route::put('/projects/{project}/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy']);
});
