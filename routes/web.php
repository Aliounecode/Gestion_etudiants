<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Tâche TOI : Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tâche TOI : Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tâche COLLABORATEUR : Modules & Filières
    Route::resource('modules', AcademicController::class);

    // Tâche COLLABORATEUR : Importation
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');

    // Tâche COLLABORATEUR : Validation
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::post('/grades/validate', [GradeController::class, 'validateBatch'])->name('grades.validate');

    // Tâche COLLABORATEUR : Export
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/download', [ExportController::class, 'download'])->name('export.download');
});

require __DIR__.'/auth.php';