@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Responsables
    </p>

    {{-- Titre + boutons (Importer CSV / Nouveau responsable) --}}
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
            <a href="{{ route('responsables.create') }}" class="btn btn-sm btn-primary">
                + Nouveau responsable
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

    {{-- Barre de recherche / filtres / tri --}}
    <form method="GET" action="{{ route('responsables.index') }}" class="row g-2 mb-3 align-items-center">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text">🔍</span>
                <input type="text" name="q" class="form-control"
                       placeholder="Rechercher par nom, email..."
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
                        <a href="{{ route('responsables.index') }}" class="btn btn-sm btn-outline-secondary">
                            Réinitialiser
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary">
                            Appliquer
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bouton Trier (tu peux le transformer en dropdown plus tard) --}}
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    Trier
                </button>
            </div>

        </div>
    </form>

    <div class="row mt-2">

        {{-- Colonne gauche : liste des responsables --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($responsables as $responsable)
                            <tr>
                                <td>
                                    {{-- clic => ouvre le panneau détails --}}
                                    <a href="{{ route('responsables.index', array_merge(request()->all(), ['responsable_id' => $responsable->id])) }}">
                                        {{ $responsable->full_name }}
                                    </a>
                                </td>
                                <td>{{ $responsable->email ?? '-' }}</td>
                                <td>{{ $responsable->grade ?? '-' }}</td>
                                <td>{{ $responsable->is_active ? 'Actif' : 'Archivé' }}</td>
                                <td>
                                    <a href="{{ route('responsables.index', array_merge(request()->all(), ['responsable_id' => $responsable->id])) }}"
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
                        Affichage de {{ $responsables->firstItem() }} à {{ $responsables->lastItem() }}
                        sur {{ $responsables->total() }} résultats
                    </small>
                    {{ $responsables->links() }}
                </div>
            </div>
        </div>

        {{-- Colonne droite : Détails du Responsable (formulaire) --}}
        <div class="col-lg-4 mt-3 mt-lg-0">
            @isset($selectedResponsable)
            <div class="card">
                {{-- Header avec poubelle + croix --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-0">Détails du Responsable</h2>
                        <small class="text-muted">
                            Modification de {{ $selectedResponsable->full_name }}
                        </small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        {{-- icône poubelle --}}
                        <form action="{{ route('responsables.destroy', $selectedResponsable) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer ce responsable ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                🗑
                            </button>
                        </form>

                        {{-- icône fermer --}}
                        <a href="{{ route('responsables.index') }}" class="btn btn-sm btn-link text-muted p-0">
                            ✕
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('responsables.update', $selectedResponsable) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label small">Prénom</label>
                            <input type="text" name="first_name"
                                   class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                                   value="{{ old('first_name', $selectedResponsable->first_name) }}">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Nom</label>
                            <input type="text" name="last_name"
                                   class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                                   value="{{ old('last_name', $selectedResponsable->last_name) }}">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror"
                                   value="{{ old('email', $selectedResponsable->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Grade</label>
                            <input type="text" name="grade"
                                   class="form-control form-control-sm @error('grade') is-invalid @enderror"
                                   value="{{ old('grade', $selectedResponsable->grade) }}">
                            @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="is_active"
                                   value="1"
                                   {{ old('is_active', $selectedResponsable->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="is_active">
                                Responsable actif – peut être assigné aux modules
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('responsables.index') }}" class="btn btn-sm btn-outline-secondary">
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
