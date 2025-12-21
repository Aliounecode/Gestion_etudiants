<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();

        // Recherche texte
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('code', 'like', "%$q%")
                   ->orWhere('name', 'like', "%$q%");
            });
        }

        // Filtre statut
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'archived') {
                $query->where('is_active', 0);
            }
        }

        // Tri
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

        $departments = $query->paginate(10)->withQueryString(); // garde filtres/tri [web:71]

        // département sélectionné pour le panneau de droite
        $selectedDepartment = null;
        if ($request->filled('department_id')) {
            $selectedDepartment = Department::find($request->department_id);
        }

        return view('departments.index', compact('departments', 'selectedDepartment'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'      => ['required', 'string', 'max:10', 'unique:departments,code'],
            'name'      => ['required', 'string', 'max:255', 'unique:departments,name'],
            'is_active' => ['nullable', 'boolean'],
        ]); // [web:81][web:145]

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Department::create($validated);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'code'      => ['required', 'string', 'max:10', 'unique:departments,code,' . $department->id],
            'name'      => ['required', 'string', 'max:255', 'unique:departments,name,' . $department->id],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $department->update($validated);

        return redirect()
            ->route('departments.index', ['department_id' => $department->id])
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Département supprimé avec succès.');
    }
}
