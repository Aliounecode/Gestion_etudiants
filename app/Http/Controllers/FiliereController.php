<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Department;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index(Request $request)
    {
        $query = Filiere::with('department');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('code', 'like', "%$q%")
                ->orWhere('name', 'like', "%$q%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'archived') {
                $query->where('is_active', 0);
            }
        }

        switch ($request->get('sort')) {
            case 'code_desc':
                $query->orderBy('code', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('code', 'asc');
        }

        $filieres = $query->paginate(10)->withQueryString(); // conserve filtres [web:71]

        $selectedFiliere = null;
        if ($request->filled('filiere_id')) {
            $selectedFiliere = Filiere::with('department')->find($request->filiere_id);
        }

        $departments = Department::orderBy('name')->get();

        return view('filieres.index', compact('filieres', 'selectedFiliere', 'departments'));  
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();


        return view('filieres.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => ['nullable', 'exists:departments,id'],
            'code'          => ['required', 'string', 'max:20', 'unique:filieres,code'],
            'name'          => ['required', 'string', 'max:255'],
            'level'         => ['nullable', 'string', 'max:100'],
            'is_active'     => ['required', 'boolean'],
        ]);

        Filiere::create($validated);

        return redirect()
            ->route('filieres.index')
            ->with('success', 'Filière créée avec succès.');
    }

    public function edit(Filiere $filiere)
    {
        $departments = Department::orderBy('name')->get();

        return view('filieres.edit', compact('filiere', 'departments'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $validated = $request->validate([
            'department_id' => ['nullable', 'exists:departments,id'],
            'code'          => [
                'required', 'string', 'max:20',
                'unique:filieres,code,' . $filiere->id,
            ],
            'name'          => ['required', 'string', 'max:255'],
            'level'         => ['nullable', 'string', 'max:100'],
            'is_active'     => ['required', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $filiere->update($validated);


        return redirect()
            ->route('filieres.index')
            ->with('success', 'Filière mise à jour avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();

        return redirect()
            ->route('filieres.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}
