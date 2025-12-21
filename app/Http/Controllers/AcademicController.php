<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Filiere;
use App\Models\Semester;
use App\Models\Responsable;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    /**
     * Page "Filières & Modules" – liste des modules + filtres.
     */
    public function index(Request $request)
    {
        $query = Module::with(['filiere.department', 'semester', 'responsable']);

        
    
            if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('code', 'like', "%$q%")
                        ->orWhere('title', 'like', "%$q%");
            });
        }

        if ($request->filled('filiere_id')) {
            $query->where('filiere_id', $request->filiere_id);
        }

        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        if ($request->filled('responsable_id')) {
            $query->where('responsable_id', $request->responsable_id);
        }

        // tri
        switch ($request->get('sort')) {
            case 'code_desc':
                $query->orderBy('code', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('code', 'asc');
        }

        $modules       = $query->paginate(10)->withQueryString();
        $filieres      = Filiere::orderBy('code')->get();
        $semesters     = Semester::orderBy('order')->get();
        $responsables  = Responsable::orderBy('last_name')->orderBy('first_name')->get();

         // pour le panneau de droite
        $selectedModule = null;
        if ($request->filled('module_id')) {
            $selectedModule = Module::with(['filiere.department', 'semester', 'responsable'])
                ->find($request->module_id);
        }

        $filieres      = Filiere::all();
        $semesters     = Semester::all();
        $responsables  = Responsable::all();

        return view('modules.index', compact(
            'modules', 'selectedModule', 'filieres', 'semesters', 'responsables'
        ));
    }

    /**
     * Formulaire de création d’un module.
     */
    public function create()
    {
        $filieres     = Filiere::orderBy('code')->get();
        $semesters    = Semester::orderBy('order')->get();
        $responsables = Responsable::orderBy('last_name')->orderBy('first_name')->get();

        return view('modules.create', compact('filieres', 'semesters', 'responsables'));
    }

    /**
     * Enregistre un nouveau module.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'filiere_id'      => ['required', 'exists:filieres,id'],
            'semester_id'     => ['nullable', 'exists:semesters,id'],
            'responsable_id'  => ['nullable', 'exists:responsables,id'],
            'code'            => ['required', 'string', 'max:20', 'unique:modules,code'],
            'title'           => ['required', 'string', 'max:255'],
            'status'          => ['required', 'in:actif,en_attente,archive'],
        ]);

        Module::create($validated);

        return redirect()
            ->route('filieres_modules')
            ->with('success', 'Module créé avec succès.');
    }

    /**
     * Affiche le détail d’un module.
     */
    public function show(Module $module)
    {
        $module->load(['filiere.department', 'semester', 'responsable']);

        return view('modules.show', compact('module'));
    }

    /**
     * Formulaire d’édition d’un module.
     */
    public function edit(Module $module)
    {
        $filieres     = Filiere::orderBy('code')->get();
        $semesters    = Semester::orderBy('order')->get();
        $responsables = Responsable::orderBy('last_name')->orderBy('first_name')->get();

        return view('modules.edit', compact('module', 'filieres', 'semesters', 'responsables'));
    }

    /**
     * Met à jour un module.
     */
    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'filiere_id'      => ['required', 'exists:filieres,id'],
            'semester_id'     => ['nullable', 'exists:semesters,id'],
            'responsable_id'  => ['nullable', 'exists:responsables,id'],
            'code'            => [
                'required',
                'string',
                'max:20',
                'unique:modules,code,' . $module->id,
            ],
            'title'           => ['required', 'string', 'max:255'],
            'status'          => ['required', 'in:actif,en_attente,archive'],
        ]);

        $module->update($validated);

        return redirect()
            ->route('filieres_modules')
            ->with('success', 'Module mis à jour avec succès.');
    }

    /**
     * Supprime un module.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()
            ->route('filieres_modules')
            ->with('success', 'Module supprimé avec succès.');
    }
}
