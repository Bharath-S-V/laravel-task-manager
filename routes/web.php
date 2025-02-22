<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

Route::get('/', [TaskController::class, 'index']);
Route::resource('tasks', TaskController::class);
Route::resource('projects', ProjectController::class);
Route::post('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');



Route::get('/', function () {
    return view('welcome');
});
