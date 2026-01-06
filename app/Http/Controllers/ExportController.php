<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Grade;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $studentId = $request->input('student_id');

        // Liste des étudiants pour le select
        $students = Student::orderBy('first_name')->get();

        $student = null;
        $grades  = collect();
        $average = null;

        if ($studentId) {
            $student = Student::find($studentId);

            if ($student) {
                // On récupère toutes ses notes
                $grades = Grade::with('module')
                    ->where('student_id', $student->id)
                    ->get();

                if ($grades->count() > 0) {
                    $average = round($grades->avg('average'), 2);
                }
            }
        }

        return view('rapports.index', [
            'students' => $students,
            'student'  => $student,
            'grades'   => $grades,
            'average'  => $average,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $studentId = $request->input('student_id');

        $student = Student::findOrFail($studentId);

        $grades = Grade::with('module')
            ->where('student_id', $student->id)
            ->get();

        $average = $grades->count() > 0
            ? round($grades->avg('average'), 2)
            : null;

        $pdf = Pdf::loadView('rapports.export.pdf', [
            'student'      => $student,
            'grades'       => $grades,
            'average'      => $average,
            'generated_at' => now(),
        ])->setPaper('a4', 'portrait');

        $fileName = 'releve_'.$student->id.'.pdf';

        return $pdf->download($fileName);
    }
}
