@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Filières
    </p>

    {{-- Titre + actions (Importer CSV / Nouvelle filière) --}}
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
            <a href="{{ route('filieres.create') }}" class="btn btn-sm btn-primary">
                + Nouvelle filière
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
    <form method="GET" action="{{ route('filieres.index') }}" class="row g-2 mb-3 align-items-center">
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
                <div class="dropdown-menu p-3" style="min-width: 260px;">

                    {{-- Département --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Département</label>
                        <select name="department_id" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Statut --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Statut</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actives</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archivées</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('filieres.index') }}" class="btn btn-sm btn-outline-secondary">
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

        {{-- Colonne gauche : liste des filières --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Intitulé</th>
                            <th>Département</th>
                            <th>Niveau</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($filieres as $filiere)
                            <tr>
                                <td>{{ $filiere->code }}</td>
                                <td>
                                    <a href="{{ route('filieres.index', array_merge(request()->all(), ['filiere_id' => $filiere->id])) }}">
                                        {{ $filiere->name }}
                                    </a>
                                </td>
                                <td>{{ $filiere->department->name ?? '-' }}</td>
                                <td>{{ $filiere->level ?? '-' }}</td>
                                <td>{{ $filiere->is_active ? 'Active' : 'Archivée' }}</td>
                                <td>
                                    <a href="{{ route('filieres.index', array_merge(request()->all(), ['filiere_id' => $filiere->id])) }}"
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
                        Affichage de {{ $filieres->firstItem() }} à {{ $filieres->lastItem() }}
                        sur {{ $filieres->total() }} résultats
                    </small>
                    {{ $filieres->links() }}
                </div>
            </div>
        </div>

        {{-- Colonne droite : Détails de la filière (formulaire) --}}
        <div class="col-lg-4 mt-3 mt-lg-0">
            @isset($selectedFiliere)
            <div class="card">
                {{-- Header avec poubelle + croix --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-0">Détails de la Filière</h2>
                        <small class="text-muted">Modification de {{ $selectedFiliere->code }}</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        {{-- icône poubelle --}}
                        <form action="{{ route('filieres.destroy', $selectedFiliere) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer cette filière ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                🗑
                            </button>
                        </form>

                        {{-- icône fermer --}}
                        <a href="{{ route('filieres.index') }}" class="btn btn-sm btn-link text-muted p-0">
                            ✕
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('filieres.update', $selectedFiliere) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- CODE --}}
                        <div class="mb-2">
                            <label class="form-label small">Code</label>
                            <input type="text" name="code"
                                   class="form-control form-control-sm @error('code') is-invalid @enderror"
                                   value="{{ old('code', $selectedFiliere->code) }}">
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INTITULÉ --}}
                        <div class="mb-2">
                            <label class="form-label small">Intitulé</label>
                            <input type="text" name="name"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror"
                                   value="{{ old('name', $selectedFiliere->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DÉPARTEMENT --}}
                        <div class="mb-2">
                            <label class="form-label small">Département</label>
                            <select name="department_id"
                                    class="form-select form-select-sm @error('department_id') is-invalid @enderror">
                                <option value="">Aucun</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id', $selectedFiliere->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIVEAU --}}
                        <div class="mb-2">
                            <label class="form-label small">Niveau</label>
                            <input type="text" name="level"
                                   class="form-control form-control-sm @error('level') is-invalid @enderror"
                                   value="{{ old('level', $selectedFiliere->level) }}">
                            @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Statut actif --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="is_active"
                                   value="1"
                                   {{ old('is_active', $selectedFiliere->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="is_active">
                                Filière active – visible dans la configuration des modules
                            </label>
                        </div>

                        {{-- Bas : Annuler / Enregistrer --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('filieres.index') }}" class="btn btn-sm btn-outline-secondary">
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
