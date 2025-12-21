<?php
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\JuryController;
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


    // Page "Filières & Modules" (onglet du header) => index maquette
    Route::get('/filieres-modules', [AcademicController::class, 'index'])
        ->name('filieres_modules');

    // Ressource modules (CRUD) utilisée par la maquette (table Code / Module / Responsable / Semestre / Statut)
    Route::resource('modules', AcademicController::class)->except(['index']);
    // ->except(['index']) car l’index est désormais /filieres-modules pour coller à la maquette. [file:20]

    // Tâche COLLABORATEUR : Importation
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');

    // Tâche COLLABORATEUR : Validation
    Route::resource('grades', GradeController::class);

    // Tâche COLLABORATEUR : Export
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/download', [ExportController::class, 'download'])->name('export.download');

    // CRUD Filières
    Route::resource('filieres', FiliereController::class);

    // CRUD Semestres
    Route::resource('semesters', SemesterController::class);

    // CRUD Responsables (enseignants)
    Route::resource('responsables', ResponsableController::class);});

    Route::resource('departments', DepartmentController::class)->except(['show', 'edit']);

    Route::resource('students', StudentController::class)->except(['show', 'edit']);
    Route::resource('jurys', JuryController::class);


require __DIR__.'/auth.php';