<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\PublicTurnsController;
use App\Http\Controllers\Admin\AdminTurnController;

// RUTA RAÍZ: Ahora muestra el formulario de reserva
Route::get('/', [PublicTurnsController::class, 'create'])->name('turns.create');

// Rutas de API y Confirmación
Route::get('/api/available-times', [PublicTurnsController::class, 'getAvailableTimes']);
Route::get('/confirmar-turno/{token}', [PublicTurnsController::class, 'confirm'])->name('turns.confirm');

// Rutas de Bloqueo de Días
Route::post('/admin/blocked-days', [AdminTurnController::class, 'storeBlockedDay'])->name('admin.blocked-days.store');
Route::delete('/admin/blocked-days/{blockedDay}', [AdminTurnController::class, 'destroyBlockedDay'])->name('admin.blocked-days.destroy');

// Perfil de Usuario (Auth)
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

// Mantenemos estas rutas por si alguien escribe /reservar manualmente
Route::get('/reservar', [PublicTurnsController::class, 'create']); 
Route::post('/reservar', [PublicTurnsController::class, 'store'])->name('turns.store');

require __DIR__.'/auth.php';