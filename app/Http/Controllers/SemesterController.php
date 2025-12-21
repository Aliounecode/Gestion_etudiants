<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        $query = Semester::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('code', 'like', "%$q%")
                ->orWhere('name', 'like', "%$q%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'archived') {
                $query->where('is_active', 0);
            }
        }

        switch ($request->get('sort')) {
            case 'order_desc':
                $query->orderBy('order', 'desc');
                break;
            case 'code_asc':
                $query->orderBy('code', 'asc');
                break;
            case 'code_desc':
                $query->orderBy('code', 'desc');
                break;
            default:
                $query->orderBy('order', 'asc');
        }

        $semesters = $query->paginate(10)->withQueryString(); // garde filtres/tri [web:68][web:161]

        $selectedSemester = null;
        if ($request->filled('semester_id')) {
            $selectedSemester = Semester::find($request->semester_id);
        }

        return view('semesters.index', compact('semesters', 'selectedSemester'));
    }

    public function create()
    {
        // Vue: resources/views/semesters/create.blade.php
        return view('semesters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'      => ['required', 'string', 'max:10', 'unique:semesters,code'],
            'name'      => ['required', 'string', 'max:255'],
            'order'     => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ]);

        Semester::create($validated);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semestre créé avec succès.');
    }

    /**
     * Mise à jour depuis le formulaire dans le panneau Détails.
     * La route typique est: PUT /semesters/{semester}
     */
    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'code'      => ['required', 'string', 'max:10', 'unique:semesters,code,' . $semester->id],
            'name'      => ['required', 'string', 'max:255'],
            'order'     => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // checkbox non cochée => is_active = 0
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $semester->update($validated);

        return redirect()
            ->route('semesters.index', ['semester_id' => $semester->id])
            ->with('success', 'Semestre mis à jour avec succès.');
    }


    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()
            ->route('semestres.index')
            ->with('success', 'Semestre supprimé avec succès.');
    }
}
