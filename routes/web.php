<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing Page: Redirect if logged in
Route::get('/', function () {
    return Auth::check() ? redirect()->route('tasks.index') : view('welcome');
});

// Protected Area
Route::middleware(['auth', 'verified'])->group(function () {
    
    // HOME: Task Management
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::resource('tasks', TaskController::class)->except(['index']);

    // DASHBOARD: Analytics
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';