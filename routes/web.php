<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\PublicTurnsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/confirmar-turno/{token}', [PublicTurnsController::class, 'confirm'])->name('turns.confirm');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::resource('barbers', BarberController::class);
});

Route::get('/reservar', [PublicTurnsController::class, 'create'])->name('turns.create');
Route::post('/reservar', [PublicTurnsController::class, 'store'])->name('turns.store');
require __DIR__.'/auth.php';
