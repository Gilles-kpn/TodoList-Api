<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//Authentification route
Route::post('users/register', [UserController::class, "registerUser"]);
Route::post('users/login', [UserController::class,"loginUser"]);
Route::post('users/resetPassword', [UserController::class,'resetPassword']);
Route::post('users/{id}/changePassword', [UserController::class,'updatePassword'])->where('id', '[0-9]+');




