<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('students',[StudentController::class,'index']);
Route::post('students',[StudentController::class,'store']);
Route::get('fetch-students',[StudentController::class,'show']);
Route::get('edit-students/{id}',[StudentController::class,'edit']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
