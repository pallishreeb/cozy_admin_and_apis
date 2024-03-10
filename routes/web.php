<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\ManageProviderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ManageDiscountController;

//home route
Route::middleware('auth')->get('/', function () {
    return view('welcome');
});

// Authentication Routes...
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');

// Password Reset Routes...
Route::get('password/reset', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('password/email', [UserController::class, 'forgotPassword'])->name('password.email');
Route::get('password/reset/{token}',  [UserController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [UserController::class, 'resetPassword'])->name('password.update');

// manage users Routes...
Route::get('/users', [ManageUserController::class, 'index'])->name('manage_users.index');
Route::get('/users/{id}/edit', [ManageUserController::class, 'edit'])->name('manage_users.edit');
Route::put('/users/{id}', [ManageUserController::class, 'update'])->name('manage_users.update');
Route::delete('/users/{id}', [ManageUserController::class, 'destroy'])->name('manage_users.destroy');

// manage providers Routes...
Route::get('/providers', [ManageProviderController::class, 'index'])->name('manage_providers.index');
Route::get('/providers/{id}/edit', [ManageProviderController::class, 'edit'])->name('manage_providers.edit');
Route::put('/providers/{id}', [ManageProviderController::class, 'update'])->name('manage_providers.update');
Route::delete('/providers/{id}', [ManageProviderController::class, 'destroy'])->name('manage_providers.destroy');

//manage categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

//manage services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

//manage discounts
Route::get('/discounts', [ManageDiscountController::class, 'index'])->name('manage_discounts.index');
Route::get('/discounts/create', [ManageDiscountController::class, 'create'])->name('manage_discounts.create');
Route::post('/discounts', [ManageDiscountController::class, 'store'])->name('manage_discounts.store');
Route::get('/discounts/{id}/edit', [ManageDiscountController::class, 'edit'])->name('manage_discounts.edit');
Route::put('/discounts/{id}', [ManageDiscountController::class, 'update'])->name('manage_discounts.update');
Route::delete('/discounts/{id}', [ManageDiscountController::class, 'destroy'])->name('manage_discounts.destroy');

