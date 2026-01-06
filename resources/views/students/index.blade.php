@extends('layouts.export')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Étudiants / Étudiants
    </p>

    {{-- Titre + boutons --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Gestion des étudiants</h1>
            <p class="text-muted mb-0">
                Liste des étudiants, filtres par filière et groupe, et modification rapide des informations.
            </p>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm">
                Importer CSV
            </button>
            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                + Nouvel étudiant
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
    <form method="GET" action="{{ route('students.index') }}" class="row g-2 mb-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text">🔍</span>
                <input type="text" name="q" class="form-control"
                       placeholder="Rechercher par nom, email, matricule..."
                       value="{{ request('q') }}">
            </div>
        </div>

        <div class="col-md-5 d-flex gap-2">

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
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}"
                                    {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Statut --}}
                    <div class="mb-2">
                        <label class="form-label small mb-1">Groupe</label>
                        <input type="text" name="group" class="form-control form-control-sm"
                               value="{{ request('group') }}">
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">
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
                        <button class="dropdown-item" type="submit" name="sort" value="name_asc">
                            Nom (A → Z)
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="name_desc">
                            Nom (Z → A)
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="matricule_asc">
                            Matricule (A → Z)
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="sort" value="matricule_desc">
                            Matricule (Z → A)
                        </button>
                    </li>
                </ul>
            </div>

        </div>
    </form>

    <div class="row mt-2">

        {{-- Colonne gauche : liste des étudiants --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Filière</th>
                            <th>Groupe</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->matricule }}</td>
                                <td>
                                    <a href="{{ route('students.index', array_merge(request()->all(), ['student_id' => $student->id])) }}">
                                        {{ $student->last_name }} {{ $student->first_name }}
                                    </a>
                                </td>
                                <td>{{ $student->email ?? '-' }}</td>
                                <td>{{ $student->filiere->name ?? '-' }}</td>
                                <td>{{ $student->group ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('students.index', array_merge(request()->all(), ['student_id' => $student->id])) }}"
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
                        Affichage de {{ $students->firstItem() }} à {{ $students->lastItem() }}
                        sur {{ $students->total() }} résultats
                    </small>
                    {{ $students->links() }}
                </div>
            </div>
        </div>

        {{-- Colonne droite : Détails de l’étudiant (formulaire) --}}
        <div class="col-lg-4 mt-3 mt-lg-0">
            @isset($selectedStudent)
            <div class="card">
                {{-- Header avec poubelle + croix --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-0">Détails de l’étudiant</h2>
                        <small class="text-muted">
                            {{ $selectedStudent->last_name }} {{ $selectedStudent->first_name }}
                        </small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        {{-- icône poubelle --}}
                        <form action="{{ route('students.destroy', $selectedStudent) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer cet étudiant ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                🗑
                            </button>
                        </form>

                        {{-- icône fermer --}}
                        <a href="{{ route('students.index') }}" class="btn btn-sm btn-link text-muted p-0">
                            ✕
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('students.update', $selectedStudent) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label small">Matricule</label>
                            <input type="text" name="matricule"
                                   class="form-control form-control-sm @error('matricule') is-invalid @enderror"
                                   value="{{ old('matricule', $selectedStudent->matricule) }}">
                            @error('matricule')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Prénom</label>
                            <input type="text" name="first_name"
                                   class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                                   value="{{ old('first_name', $selectedStudent->first_name) }}">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Nom</label>
                            <input type="text" name="last_name"
                                   class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                                   value="{{ old('last_name', $selectedStudent->last_name) }}">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror"
                                   value="{{ old('email', $selectedStudent->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Filière</label>
                            <select name="filiere_id"
                                    class="form-select form-select-sm @error('filiere_id') is-invalid @enderror">
                                <option value="">Aucune</option>
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}"
                                        {{ old('filiere_id', $selectedStudent->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                        {{ $filiere->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('filiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                          <div class="mb-2">
                            <label class="form-label small">group</label>
                            <input type="text" name="group"
                                   class="form-control form-control-sm @error('group') is-invalid @enderror"
                                   value="{{ old('group', $selectedStudent->group) }}">
                            @error('group')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">
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
