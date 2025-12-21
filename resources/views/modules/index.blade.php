@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières
    </p>

    {{-- Titre + actions (Importer CSV / Nouveau Module) --}}
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h3 mb-1">Configuration Académique</h1>
            <p class="text-muted mb-0">
                Créez et organisez les structures académiques, gérez les programmes et assignez les équipes pédagogiques.
            </p>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm">
                Importer CSV
            </button>
            <a href="{{ route('modules.create') }}" class="btn btn-primary btn-sm">
                + Nouveau Module
            </a>
        </div>
    </div>

    {{-- Mini-menu horizontal --}}
    <div class="d-flex align-items-center gap-4 mb-3 border-bottom pb-2">
        <a href="{{ route('filieres_modules') }}"
           class="d-flex align-items-center gap-2 text-decoration-none
                  {{ request()->routeIs('filieres_modules') ? 'fw-semibold text-primary border-primary border-bottom pb-2' : 'text-muted' }}">
            <span>▦</span><span>Modules</span>
        </a>
        <a href="{{ route('filieres.index') }}"
           class="d-flex align-items-center gap-2 text-decoration-none
                  {{ request()->routeIs('filieres.*') ? 'fw-semibold text-primary border-primary border-bottom pb-2' : 'text-muted' }}">
            <span>☷</span><span>Filières</span>
        </a>
        <a href="{{ route('semesters.index') }}"
           class="d-flex align-items-center gap-2 text-decoration-none
                  {{ request()->routeIs('semesters.*') ? 'fw-semibold text-primary border-primary border-bottom pb-2' : 'text-muted' }}">
            <span>🗓</span><span>Semestres</span>
        </a>
        <a href="{{ route('responsables.index') }}"
           class="d-flex align-items-center gap-2 text-decoration-none
                  {{ request()->routeIs('responsables.*') ? 'fw-semibold text-primary border-primary border-bottom pb-2' : 'text-muted' }}">
            <span>👥</span><span>Responsables</span>
        </a>
    </div>

    {{-- Barre recherche + filtres / tri --}}
    <form method="GET" action="{{ route('filieres_modules') }}" class="row g-2 mb-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text">🔍</span>
                <input type="text" name="q" class="form-control"
                       placeholder="Rechercher par code ou titre..."
                       value="{{ request('q') }}">
            </div>
        </div>

        <div class="col-md-4 d-flex gap-2">

            {{-- Dropdown Filtres --}}
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    Filtres
                </button>
                <div class="dropdown-menu p-3" style="min-width: 260px;">
                    {{-- Filière --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Filière</label>
                        <select name="filiere_id" class="form-select form-select-sm">
                            <option value="">Toutes</option>
                            @foreach ($filieres as $filiere)
                                <option value="{{ $filiere->id }}"
                                    {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->code }} - {{ $filiere->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Semestre --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Semestre</label>
                        <select name="semester_id" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->code }} - {{ $semester->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Responsable --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Responsable</label>
                        <select name="responsable_id" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            @foreach ($responsables as $responsable)
                                <option value="{{ $responsable->id }}"
                                    {{ request('responsable_id') == $responsable->id ? 'selected' : '' }}>
                                    {{ $responsable->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('filieres_modules') }}" class="btn btn-sm btn-outline-secondary">
                            Réinitialiser
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary">
                            Appliquer
                        </button>
                    </div>
                </div>
            </div>

            {{-- Dropdown Trier --}}
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    Trier
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="code_asc">
                            Code (A → Z)
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="code_desc">
                            Code (Z → A)
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="title_asc">
                            Titre (A → Z)
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="title_desc">
                            Titre (Z → A)
                        </button>
                    </li>
                </ul>
            </div>

        </div>
    </form>

    {{-- Contenu principal : liste + détails --}}
    <div class="row mt-2">

        {{-- Colonne gauche : liste des modules --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Module</th>
                            <th>Responsable</th>
                            <th>Semestre</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ $module->code }}</td>
                                <td>
                                    <a href="{{ route('filieres_modules', array_merge(request()->all(), ['module_id' => $module->id])) }}">
                                        {{ $module->title }}
                                    </a>
                                </td>
                                <td>
                                    @if($module->responsable)
                                        <a href="{{ route('filieres_modules',
                                            array_merge(request()->all(), ['responsable_id' => $module->responsable->id])) }}">
                                            {{ $module->responsable->full_name }}
                                        </a>
                                    @else
                                        Non assigné
                                    @endif
                                </td>
                                <td>
                                    @if($module->semester)
                                        <a href="{{ route('filieres_modules',
                                            array_merge(request()->all(), ['semester_id' => $module->semester->id])) }}">
                                            {{ $module->semester->code }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @switch($module->status)
                                        @case('actif')
                                            Actif
                                            @break
                                        @case('en_attente')
                                            En attente
                                            @break
                                        @case('archive')
                                            Archivé
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('filieres_modules', array_merge(request()->all(), ['module_id' => $module->id])) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Affichage de {{ $modules->firstItem() }} à {{ $modules->lastItem() }}
                        sur {{ $modules->total() }} résultats
                    </small>
                    {{ $modules->links() }}
                </div>
            </div>
        </div>

        {{-- Colonne droite : panneau "Détails du Module" --}}
        <div class="col-lg-4 mt-3 mt-lg-0">
            @isset($selectedModule)
            <div class="card">
                {{-- Header avec poubelle + croix --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-0">Détails du Module</h2>
                        <small class="text-muted">Modification de {{ $selectedModule->code }}</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        {{-- icône poubelle --}}
                        <form action="{{ route('modules.destroy', $selectedModule) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer ce module ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                🗑
                            </button>
                        </form>

                        {{-- icône fermer --}}
                        <a href="{{ route('filieres_modules') }}" class="btn btn-sm btn-link text-muted p-0">
                            ✕
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('modules.update', $selectedModule) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- CODE --}}
                        <div class="mb-2">
                            <label class="form-label small">Code</label>
                            <input type="text" name="code"
                                   class="form-control form-control-sm @error('code') is-invalid @enderror"
                                   value="{{ old('code', $selectedModule->code) }}">
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INTITULÉ --}}
                        <div class="mb-2">
                            <label class="form-label small">Intitulé du module</label>
                            <input type="text" name="title"
                                   class="form-control form-control-sm @error('title') is-invalid @enderror"
                                   value="{{ old('title', $selectedModule->title) }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- FILIÈRE --}}
                        <div class="mb-2">
                            <label class="form-label small">Filière de rattachement</label>
                            <select name="filiere_id"
                                    class="form-select form-select-sm @error('filiere_id') is-invalid @enderror">
                                <option value="">Aucune</option>
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}"
                                        {{ old('filiere_id', $selectedModule->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                        {{ $filiere->code }} - {{ $filiere->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('filiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- SEMESTRE --}}
                        <div class="mb-2">
                            <label class="form-label small">Semestre</label>
                            <select name="semester_id"
                                    class="form-select form-select-sm @error('semester_id') is-invalid @enderror">
                                <option value="">Aucun</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}"
                                        {{ old('semester_id', $selectedModule->semester_id) == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->code }} - {{ $semester->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- RESPONSABLE --}}
                        <div class="mb-3">
                            <label class="form-label small">Responsable</label>
                            <select name="responsable_id"
                                    class="form-select form-select-sm @error('responsable_id') is-invalid @enderror">
                                <option value="">Non assigné</option>
                                @foreach($responsables as $responsable)
                                    <option value="{{ $responsable->id }}"
                                        {{ old('responsable_id', $selectedModule->responsable_id) == $responsable->id ? 'selected' : '' }}>
                                        {{ $responsable->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Statut --}}
                        <div class="mb-3">
                            <label class="form-label small">Statut</label>
                            <select name="status"
                                    class="form-select form-select-sm @error('status') is-invalid @enderror">
                                <option value="actif" {{ old('status', $selectedModule->status) == 'actif' ? 'selected' : '' }}>
                                    Actif
                                </option>
                                <option value="en_attente" {{ old('status', $selectedModule->status) == 'en_attente' ? 'selected' : '' }}>
                                    En attente
                                </option>
                                <option value="archive" {{ old('status', $selectedModule->status) == 'archive' ? 'selected' : '' }}>
                                    Archivé
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bas : Annuler / Enregistrer --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('filieres_modules') }}" class="btn btn-sm btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary">
                                Enregistrer
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            @endisset
        </div>

    </div>{{-- /.row --}}

</div>
@endsection
