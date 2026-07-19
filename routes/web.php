<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('junior/dashboard', [DashboardController::class, 'index'])->name('junior-dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/master', [AssignmentController::class, 'index'])->name('master');
    Route::get('/shutter', [AssignmentController::class, 'shutter'])->name('shutter');
    Route::get('/recital', [AssignmentController::class, 'recital'])->name('recital');
    Route::get('/rubbish', [AssignmentController::class, 'rubbish'])->name('rubbish');
});

require __DIR__.'/auth.php';
