<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\PublicTurnsController;
use App\Http\Controllers\Admin\AdminTurnController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/api/available-times', [PublicTurnsController::class, 'getAvailableTimes']);
Route::get('/confirmar-turno/{token}', [PublicTurnsController::class, 'confirm'])->name('turns.confirm');
Route::post('/admin/blocked-days', [AdminTurnController::class, 'storeBlockedDay'])->name('admin.blocked-days.store');
Route::delete('/admin/blocked-days/{blockedDay}', [AdminTurnController::class, 'destroyBlockedDay'])->name('admin.blocked-days.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Rutas de Administración
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/agenda', [AdminTurnController::class, 'index'])->name('turns.index');
    Route::delete('/agenda/{turn}', [AdminTurnController::class, 'destroy'])->name('turns.destroy');
    
    Route::resource('barbers', BarberController::class);
    
    Route::get('/configuracion', [AdminTurnController::class, 'editSettings'])->name('settings.edit');
    Route::put('/configuracion', [AdminTurnController::class, 'updateSettings'])->name('settings.update');
});

Route::get('/reservar', [PublicTurnsController::class, 'create'])->name('turns.create');
Route::post('/reservar', [PublicTurnsController::class, 'store'])->name('turns.store');
require __DIR__.'/auth.php';
