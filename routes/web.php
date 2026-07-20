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
    Route::middleware('junior')->group(function () {
        //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/junior/{assignment}/swap', [AssignmentController::class, 'swapAssignment'])->name('swap');
        Route::post('/junior/{assignment}/swap/confirm', [AssignmentController::class, 'confirmSwap'])->name('swap.confirm');
    });

    Route::middleware('admin')->group(function () {
        //Route::get('admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin-dashboard');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/master', [AssignmentController::class, 'master'])->name('master');
    Route::get('/shutter', [AssignmentController::class, 'shutter'])->name('shutter');
    Route::get('/recital', [AssignmentController::class, 'recital'])->name('recital');
    Route::get('/rubbish', [AssignmentController::class, 'rubbish'])->name('rubbish');
    Route::post('/{assignment}/done', [AssignmentController::class, 'markAsDone'])->name('done');
});

require __DIR__.'/auth.php';
