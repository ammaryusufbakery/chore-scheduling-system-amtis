<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JuniorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Services\FirebaseNotificationService;
use App\Models\FcmToken;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('junior')->group(function () {
        //
    });

    Route::middleware('admin')->group(function () {
        Route::get('/juniors', [JuniorController::class, 'index'])->name('juniors.index');
        Route::get('/juniors/create', [JuniorController::class, 'create'])->name('juniors.create');
        Route::post('/juniors', [JuniorController::class, 'store'])->name('juniors.store');
        Route::get('/juniors/{junior}', [JuniorController::class, 'show'])->name('juniors.show');
        Route::get('/juniors/{junior}/edit', [JuniorController::class, 'edit'])->name('juniors.edit');
        Route::put('/juniors/{junior}', [JuniorController::class, 'update'])->name('juniors.update');
        Route::delete('/juniors/{junior}', [JuniorController::class, 'destroy'])->name('juniors.destroy');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/assignments/master', [AssignmentController::class, 'master'])->name('master');
    Route::get('/assignments/shutter', [AssignmentController::class, 'shutter'])->name('shutter');
    Route::get('/assignments/recital', [AssignmentController::class, 'recital'])->name('recital');
    Route::get('/assignments/rubbish', [AssignmentController::class, 'rubbish'])->name('rubbish');
    Route::post('/assignments/{assignment}/done', [AssignmentController::class, 'markAsDone'])->name('done');
    Route::post('/assignments/{assignment}/swap', [AssignmentController::class, 'swapAssignment'])->name('swap');
    Route::post('/assignments/{assignment}/swap/confirm', [AssignmentController::class, 'confirmSwap'])->name('swap.confirm');

    Route::post('/api/fcm-token', function (Request $request) {

        $request->validate([
            'token' => 'required|string',
        ]);

        $request->user()
            ->fcmTokens()
            ->updateOrCreate(
                [
                    'token' => $request->token,
                    // 'user_id' => auth()->user()->id,
                ],
                [
                    'token' => $request->token,
                ]
            );

        return response()->json([
            'success' => true,
        ]);
    });

    // Route::get('/test-notification/{user}', function ($userId, FirebaseNotificationService $firebase) 
    // {
    //     $fcmToken = FcmToken::where('user_id', $userId)
    //         ->where('device', 'mobile')
    //         ->first();

    //     if (!$fcmToken) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No mobile FCM token found.',
    //         ], 404);
    //     }

    //     $firebase->send(
    //         $fcmToken->token,
    //         'Test Notification',
    //         'This is a test notification from your Laravel PWA.'
    //     );

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Notification sent.',
    //     ]);
    // });
});

require __DIR__.'/auth.php';
