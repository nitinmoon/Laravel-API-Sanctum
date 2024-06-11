<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
|
*/
Route::controller(LoginController::class)->group(function() {
    Route::get('/auth/login', 'login');
    Route::post('/auth/register', 'register');
});


/*
|--------------------------------------------------------------------------
| API Protected Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware('auth:sanctum')->group(function() {
    Route::controller(StudentController::class)->group(function() {
        Route::get('/students', 'index');
        Route::get('/students/show/{student_id}', 'show');
        Route::post('/students/store', 'store');
        Route::put('/students/update/{id}', 'update');
        Route::delete('/students/delete/{id}', 'destroy');
    });
    Route::post('/auth/logout', [LoginController::class, 'logout']);
});



 
