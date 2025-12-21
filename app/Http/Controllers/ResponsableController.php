<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    public function index(Request $request)
    {
        $query = Responsable::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('first_name', 'like', "%$q%")
                ->orWhere('last_name', 'like', "%$q%")
                ->orWhere('email', 'like', "%$q%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'archived') {
                $query->where('is_active', 0);
            }
        }

        $responsables = $query->orderBy('last_name')->orderBy('first_name')
                            ->paginate(10)->withQueryString(); // conserve filtres [web:68][web:126]

        $selectedResponsable = null;
        if ($request->filled('responsable_id')) {
            $selectedResponsable = Responsable::find($request->responsable_id);
        }

        return view('responsables.index', compact('responsables', 'selectedResponsable'));
    }


    public function create()
    {
        return view('responsables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['nullable', 'email', 'max:255', 'unique:responsables,email'],
            'grade'      => ['nullable', 'string', 'max:50'],
            'is_active'  => ['required', 'boolean'],
        ]);

        Responsable::create($validated);

        return redirect()
            ->route('responsables.index')
            ->with('success', 'Responsable créé avec succès.');
    }

    /*public function edit(Responsable $responsable)
    {
        return view('responsables.edit', compact('responsable'));
    }*/

   public function update(Request $request, Responsable $responsable)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['nullable', 'email', 'max:255', 'unique:responsables,email,' . $responsable->id],
            'grade'      => ['nullable', 'string', 'max:50'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $responsable->update($validated);

        return redirect()
            ->route('responsables.index', ['responsable_id' => $responsable->id])
            ->with('success', 'Responsable mis à jour avec succès.');
    }
    public function destroy(Responsable $responsable)
    {
        $responsable->delete();

        return redirect()
            ->route('responsables.index')
            ->with('success', 'Responsable supprimé avec succès.');
    }
}
