<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Module;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'module'])->latest()->paginate(20);

        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        $modules  = Module::all();

        return view('grades.create', compact('students', 'modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'module_id'  => ['required', 'exists:modules,id'],
            'score_exam' => ['nullable', 'numeric', 'between:0,20'],
            'score_cc'   => ['nullable', 'numeric', 'between:0,20'],
            'average'    => ['nullable', 'numeric', 'between:0,20'],
            // plus de 'status' dans la requête
        ]);

        // Calcul automatique de la moyenne si non fournie
        if (!is_null($data['score_exam']) || !is_null($data['score_cc'])) {
            $exam = $data['score_exam'] ?? 0;
            $cc   = $data['score_cc'] ?? 0;

            // si l'utilisateur n'a pas forcé average, on la calcule
            if (!isset($data['average'])) {
                $data['average'] = round(($exam + $cc) / 2, 2);
            }
        }

        // Détermination automatique du status
        if (isset($data['average'])) {
            $data['status'] = $data['average'] < 10 ? 'rejected' : 'validated';
        } else {
            $data['status'] = 'pending';
        }

        Grade::create($data);

        return redirect()->route('grades.index')->with('success', 'Note enregistrée.');
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $modules  = Module::all();

        return view('grades.edit', compact('grade', 'students', 'modules'));
    }

    public function update(Request $request, Grade $grade)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'module_id'  => ['required', 'exists:modules,id'],
            'score_exam' => ['nullable', 'numeric', 'between:0,20'],
            'score_cc'   => ['nullable', 'numeric', 'between:0,20'],
            'average'    => ['nullable', 'numeric', 'between:0,20'],
            // plus de 'status' dans la requête
        ]);

        if (!is_null($data['score_exam']) || !is_null($data['score_cc'])) {
            $exam = $data['score_exam'] ?? 0;
            $cc   = $data['score_cc'] ?? 0;

            if (!isset($data['average'])) {
                $data['average'] = round(($exam + $cc) / 2, 2);
            }
        }

        if (isset($data['average'])) {
            $data['status'] = $data['average'] < 10 ? 'rejected' : 'validated';
        } else {
            $data['status'] = 'pending';
        }

        $grade->update($data);

        return redirect()->route('grades.index')->with('success', 'Note mise à jour.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Note supprimée.');
    }
}
