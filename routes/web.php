<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\JuryController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Filières & Modules
    Route::get('/filieres-modules', [AcademicController::class, 'index'])
        ->name('filieres_modules');
    Route::resource('modules', AcademicController::class)->except(['index']);

    // 🔽 IMPORTATION (fusion du petit code)
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');

    // Rapports & Export
    Route::get('/rapports', [ExportController::class, 'index'])->name('rapports.index');
    Route::post('/rapports/export/pdf', [ExportController::class, 'exportPdf'])->name('rapports.export.pdf');

    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/download', [ExportController::class, 'download'])->name('export.download');

    // CRUD
    Route::resource('grades', GradeController::class);
    Route::resource('filieres', FiliereController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('responsables', ResponsableController::class);
});

Route::resource('departments', DepartmentController::class)->except(['show', 'edit']);
Route::resource('students', StudentController::class)->except(['show', 'edit']);
Route::resource('jurys', JuryController::class);

require __DIR__.'/auth.php';
