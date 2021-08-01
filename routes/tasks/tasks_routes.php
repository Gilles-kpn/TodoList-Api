<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
Route::get('tasks/{userId}/taskslist', [TaskController::class,"index"])->where('userId', '[0-9]+');
Route::post('tasks/{id}/addTask', [TaskController::class, "create"])->where("id", "[0-9]+");
Route::delete('tasks/{id}/delete',[TaskController::class,'delete'])->where("id", "[0-9]+");
Route::post('tasks/{id}/done/{status}', [TaskController::class,'setStatus'])->where("id", "[0-9]+")->where("status", "[0-9]+");
Route::put('tasks/{id}/update', [TaskController::class, 'update'])->where("id", "[0-9]+");
Route::delete('tasks/{id}/deleteAll',[TaskController::class,'deleteAll'])->where("id", "[0-9]+");

// chemin : tasks/id/getCSV TaskController export
Route::get('tasks/{id}/getCSV', [TaskController::class, 'export'])->where("id", "[0-9]+");

