<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->name('dashboard.')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('guest', GuestController::class);
    Route::get('/print', [GuestController::class, 'createPDF'])->name('print');
    Route::get('/word', [GuestController::class, 'createWord'])->name('word');
    Route::get('/print-word', [GuestController::class, 'exportWord'])->name('print-word');

    Route::get('/trash-guest', [GuestController::class, 'trash'])->name('trash-guest');
    Route::get('/restore/{id}', [GuestController::class, 'restore'])->name('restore');
    Route::get('/restore', [GuestController::class, 'restoreAll'])->name('restore-all');
    Route::get('/force/{id}', [GuestController::class, 'force'])->name('force');
    Route::get('/force', [GuestController::class, 'forceAll'])->name('force-all');
    Route::get('/log-guest', [GuestController::class, 'log'])->name('log-guest');
});
