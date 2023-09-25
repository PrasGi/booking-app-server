<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/food', [FoodController::class, 'index'])->name('food.index');
    Route::post('/food', [FoodController::class, 'store'])->name('food.store');

    Route::get('/car', [CarController::class, 'index'])->name('car.index');
    Route::post('/car', [CarController::class, 'store'])->name('car.store');
});
