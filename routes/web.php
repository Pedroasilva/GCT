<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::redirect('/', '/login');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });
});

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Profile Routes
    Route::prefix('profile')
        ->name('profile.')
        ->middleware(CheckPermission::class . ':perfil_gerenciar')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });

    // Usuarios Routes
    Route::prefix('users')
        ->name('users.')
        ->middleware(CheckPermission::class . ':usuarios_gerenciar')
        ->controller(UsuariosController::class)
        ->group(function () {
            Route::get('/new', 'new')->name('new');
            Route::post('/store', 'store')->name('store');
            Route::get('/list', 'list')->name('list');
        });

    // Email Verification and Password Routes
    Route::middleware(CheckPermission::class . ':perfil_gerenciar')->group(function () {
        Route::controller(ConfirmablePasswordController::class)->group(function () {
            Route::get('confirm-password', 'show')->name('password.confirm');
            Route::post('confirm-password', 'store');
        });
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    });

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
