<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InertiaAuthController;
use App\Http\Controllers\InertiaLeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [InertiaAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [InertiaAuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [InertiaAuthController::class, 'logout'])->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/leads', [InertiaLeadController::class, 'index'])->name('web.leads.index');
    Route::get('/leads/create', [InertiaLeadController::class, 'create'])->name('web.leads.create');
    Route::post('/leads', [InertiaLeadController::class, 'store'])->name('web.leads.store');
Route::get('/leads/{lead}', [InertiaLeadController::class, 'show'])->name('web.leads.show');
    Route::get('/leads/{lead}/edit', [InertiaLeadController::class, 'edit'])->name('web.leads.edit');
    Route::put('/leads/{lead}', [InertiaLeadController::class, 'update'])->name('web.leads.update');
    Route::delete('/leads/{lead}', [InertiaLeadController::class, 'destroy'])->name('web.leads.destroy');
    Route::patch('/leads/{lead}/status', [InertiaLeadController::class, 'updateStatus'])->name('web.leads.status');
    Route::post('/leads/{lead}/notes', [InertiaLeadController::class, 'addNote'])->name('web.leads.notes.store');
});
