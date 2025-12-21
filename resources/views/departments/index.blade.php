@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Départements
    </p>

    {{-- Titre + boutons (Importer CSV / Nouveau département) --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
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
            <a href="{{ route('departments.create') }}" class="btn btn-sm btn-primary">
                + Nouveau département
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
    <form method="GET" action="{{ route('departments.index') }}" class="row g-2 mb-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text">🔍</span>
                <input type="text" name="q" class="form-control"
                       placeholder="Rechercher par code ou intitulé..."
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
                <div class="dropdown-menu p-3" style="min-width: 220px;">

                    {{-- Statut --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Statut</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <option value="active"   {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archivés</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-outline-secondary">
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
                        <button class="dropdown-item" type="submit" name="sort" value="name_asc">
                            Intitulé (A → Z)
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="name_desc">
                            Intitulé (Z → A)
                        </button>
                    </li>
                </ul>
            </div>

        </div>
    </form>

    <div class="row mt-2">

        {{-- Colonne gauche : liste des départements --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Intitulé</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $department)
                            <tr>
                                <td>{{ $department->code }}</td>
                                <td>
                                    <a href="{{ route('departments.index', array_merge(request()->all(), ['department_id' => $department->id])) }}">
                                        {{ $department->name }}
                                    </a>
                                </td>
                                <td>{{ $department->is_active ? 'Actif' : 'Archivé' }}</td>
                                <td>
                                    <a href="{{ route('departments.index', array_merge(request()->all(), ['department_id' => $department->id])) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Affichage de {{ $departments->firstItem() }} à {{ $departments->lastItem() }}
                        sur {{ $departments->total() }} résultats
                    </small>
                    {{ $departments->links() }}
                </div>
            </div>
        </div>

        {{-- Colonne droite : Détails du Département (formulaire) --}}
        <div class="col-lg-4 mt-3 mt-lg-0">
            @isset($selectedDepartment)
            <div class="card">
                {{-- Header avec poubelle + croix --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-0">Détails du Département</h2>
                        <small class="text-muted">Modification de {{ $selectedDepartment->code }}</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        {{-- icône poubelle --}}
                        <form action="{{ route('departments.destroy', $selectedDepartment) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer ce département ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                🗑
                            </button>
                        </form>

                        {{-- icône fermer --}}
                        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-link text-muted p-0">
                            ✕
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('departments.update', $selectedDepartment) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- CODE --}}
                        <div class="mb-2">
                            <label class="form-label small">Code</label>
                            <input type="text" name="code"
                                   class="form-control form-control-sm @error('code') is-invalid @enderror"
                                   value="{{ old('code', $selectedDepartment->code) }}">
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INTITULÉ --}}
                        <div class="mb-2">
                            <label class="form-label small">Intitulé</label>
                            <input type="text" name="name"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror"
                                   value="{{ old('name', $selectedDepartment->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Statut actif --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="is_active"
                                   value="1"
                                   {{ old('is_active', $selectedDepartment->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="is_active">
                                Département actif – utilisable dans la configuration des filières
                            </label>
                        </div>

                        {{-- Bas : Annuler / Enregistrer --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('departments.index') }}" class="btn btn-sm btn-outline-secondary">
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

    </div>{{-- /row --}}

</div>
@endsection
