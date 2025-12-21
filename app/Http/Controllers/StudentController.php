<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Filiere;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('filiere'); // si relation filiere() sur Student

        // Recherche texte
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('first_name', 'like', "%$q%")
                   ->orWhere('last_name', 'like', "%$q%")
                   ->orWhere('email', 'like', "%$q%")
                   ->orWhere('matricule', 'like', "%$q%")
                   ->orWhere('group', 'like', "%$q%");
            });
        }

        // Filtre filière
        if ($request->filled('filiere_id')) {
            $query->where('filiere_id', $request->filiere_id);
        }

        // Tri
        switch ($request->get('sort')) {
            case 'name_asc':
                $query->orderBy('last_name')->orderBy('first_name');
                break;
            case 'name_desc':
                $query->orderBy('last_name', 'desc')->orderBy('first_name', 'desc');
                break;
            case 'matricule_asc':
                $query->orderBy('matricule', 'asc');
                break;
            case 'matricule_desc':
                $query->orderBy('matricule', 'desc');
                break;
            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;
            case 'email_desc':
                $query->orderBy('email', 'desc');
                break;
            case 'group_asc':
                $query->orderBy('group', 'asc');
                break;
            case 'group_desc':
                $query->orderBy('group', 'desc');
                break;
            default:
                $query->orderBy('last_name')->orderBy('first_name');
        }

        $students = $query->paginate(10)->withQueryString(); // conserve filtres [web:126][web:71]

        $selectedStudent = null;
        if ($request->filled('student_id')) {
            $selectedStudent = Student::with('filiere')->find($request->student_id);
        }

        $filieres = Filiere::orderBy('name')->get();

        return view('students.index', compact('students', 'selectedStudent', 'filieres'));
    }

    public function create()
    {
        $filieres = Filiere::orderBy('name')->get();

        return view('students.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule'   => ['required', 'string', 'max:50', 'unique:students,matricule'],
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'email'       => ['nullable', 'email', 'max:255', 'unique:students,email'],
            'filiere_id'  => ['nullable', 'exists:filieres,id'],
            'group'   => ['nullable', 'string', 'max:100'],
        ]); // [web:81][web:214]


        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Étudiant créé avec succès.');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'matricule'   => ['required', 'string', 'max:50', 'unique:students,matricule,' . $student->id],
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'email'       => ['nullable', 'email', 'max:255', 'unique:students,email,' . $student->id],
            'filiere_id'  => ['nullable', 'exists:filieres,id'],
            'group'   => ['nullable', 'string', 'max:100'],
        ]);


        $student->update($validated);

        return redirect()
            ->route('students.index', ['student_id' => $student->id])
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}
