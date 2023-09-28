<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Register a new user
//Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);

// Login an existing user
Route::post('/login', [AuthController::class, 'login']);

// Create a new task
Route::post('/tasks', [TaskController::class, 'store']);

// Get a list of all tasks
Route::get('/tasks', [TaskController::class, 'index']);

// Get a specific task by ID
Route::get('/tasks/{id}', [TaskController::class, 'show']);

// Update a task by ID
Route::put('/tasks/{id}', [TaskController::class, 'update']);

// Delete a task by ID
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
