<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTimeController;

Route::get('/', [ProjectController::class, 'index'])->name('home'); // Kezdőoldal: Projektek listája


Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index'); // Projekt lista
    Route::post('/', [ProjectController::class, 'store'])->name('store'); // Új projekt létrehozása
    Route::get('/export', [ProjectController::class, 'export'])->name('export'); // Adatok exportálása
});

Route::prefix('project-times')->name('project-times.')->group(function () {
    Route::get('/', [ProjectTimeController::class, 'index'])->name('index'); // Idősávok listája
    Route::post('/', [ProjectTimeController::class, 'store'])->name('store'); // Új idősáv létrehozása
    Route::patch('/{id}', [ProjectTimeController::class, 'update'])->name('update'); // Idősáv frissítése
});