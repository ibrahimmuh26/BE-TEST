<?php

use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\dashboard\DivisionController;
use App\Http\Controllers\dashboard\EmployeeController;
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

Route::controller(UserAuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    //logout
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');

    //division
    Route::controller(DivisionController::class)->group(function () {
        Route::get('divisions', 'getData')->name('division');
    });

    //employee
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('employees', 'create')->name('employee');
    });
});
