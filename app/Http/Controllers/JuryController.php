<?php

namespace App\Http\Controllers;

use App\Models\Jury;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;

class JuryController extends Controller
{
    public function index()
    {
        
        
        $students  = Student::orderBy('first_name')->get();

        // récupère les semestres existants en base
        $semesters = Semester::query()
            ->whereNotNull('code')
            ->distinct()
            ->orderBy('code')
            ->pluck('code'); // collection type ["S1","S2", ...]

            $jurys = Jury::latest()->paginate(20);
        return view('jurys.index', compact('students', 'semesters', 'jurys'));
    }

    public function create()
    {
        $students  = Student::orderBy('first_name')->get();
        $semesters = Semester::whereNotNull('code')
            ->distinct()
            ->orderBy('code')
            ->pluck('code');

        return view('jurys.create', compact('students', 'semesters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'promotion'  => ['nullable', 'string', 'max:255'],
            'semester'   => ['nullable', 'string', 'max:50'],
            'session'    => ['nullable', 'string', 'max:50'],
            'meeting_at' => ['nullable', 'date'],
            'status'     => ['required', 'in:draft,validated,archived'],
            'students'   => ['array'],
            'students.*' => ['exists:students,id'],
        ]);

        $jury = Jury::create($data);

        if (!empty($data['students'])) {
            $jury->students()->sync($data['students']);
        }

        return redirect()->route('jurys.index')->with('success', 'Jury créé avec succès.');
    }

    public function show(Jury $jury)
    {
        $jury->load('students');

        return view('jurys.show', compact('jury'));
    }

    public function edit(Jury $jury)
    {
        $students = Student::orderBy('first_name')->get();
        $jury->load('students');

        return view('jurys.edit', compact('jury', 'students'));
    }

    public function update(Request $request, Jury $jury)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'promotion'  => ['nullable', 'string', 'max:255'],
            'semester'   => ['nullable', 'string', 'max:50'],
            'session'    => ['nullable', 'string', 'max:50'],
            'meeting_at' => ['nullable', 'date'],
            'status'     => ['required', 'in:draft,validated,archived'],
            'students'   => ['array'],
            'students.*' => ['exists:students,id'],
        ]);

        $jury->update($data);
        $jury->students()->sync($data['students'] ?? []);

        return redirect()->route('jurys.index')->with('success', 'Jury mis à jour.');
    }

    public function destroy(Jury $jury)
    {
        $jury->delete();

        return redirect()->route('jurys.index')->with('success', 'Jury supprimé.');
    }
}
