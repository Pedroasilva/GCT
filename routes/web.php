<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Usuarios Routes
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/new', [UsuariosController::class, 'new'])->name('new');
        Route::post('/store', [UsuariosController::class, 'store'])->name('store');
        Route::get('/list', [UsuariosController::class, 'list'])->name('list');
    });
});

// Authentication Routes
require __DIR__.'/auth.php';
