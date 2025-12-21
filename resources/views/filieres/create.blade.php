@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Filières / Nouvelle filière
    </p>

    {{-- Titre + bouton retour --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouvelle Filière</h1>
            <p class="text-muted mb-0">
                Créez un nouveau programme et rattachez-le à un département académique.
            </p>
        </div>

        <a href="{{ route('filieres.index') }}" class="btn btn-outline-secondary btn-sm">
            Annuler
        </a>
    </div>

    {{-- Mini-menu horizontal --}}
    <div class="d-flex align-items-center gap-4 mb-3 border-bottom pb-2">
        <a href="{{ route('filieres_modules') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>▦</span>
            <span>Modules</span>
        </a>
        <a href="{{ route('filieres.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>☷</span>
            <span>Filières</span>
        </a>
        <a href="{{ route('semesters.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>🗓</span>
            <span>Semestres</span>
        </a>
        <a href="{{ route('responsables.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>👥</span>
            <span>Responsables</span>
        </a>
    </div>

    {{-- Formulaire --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('filieres.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Code --}}
                    <div class="col-md-4">
                        <label for="code" class="form-label small">Code</label>
                        <input type="text" name="code" id="code"
                               value="{{ old('code') }}"
                               class="form-control form-control-sm @error('code') is-invalid @enderror"
                               placeholder="GL, GI, TC...">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Intitulé --}}
                    <div class="col-md-8">
                        <label for="name" class="form-label small">Intitulé de la filière</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror"
                               placeholder="Génie Logiciel">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Département --}}
                    <div class="col-md-6">
                        <label for="department_id" class="form-label small">Département</label>
                        <select name="department_id" id="department_id"
                                class="form-select form-select-sm @error('department_id') is-invalid @enderror">
                            <option value="">Sélectionner un département</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Niveau --}}
                    <div class="col-md-3">
                        <label for="level" class="form-label small">Niveau</label>
                        <input type="text" name="level" id="level"
                               value="{{ old('level') }}"
                               class="form-control form-control-sm @error('level') is-invalid @enderror"
                               placeholder="Licence 1, Master 2...">
                        @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Statut --}}
                    <div class="col-md-3">
                        <label for="is_active" class="form-label small">Statut</label>
                        <select name="is_active" id="is_active"
                                class="form-select form-select-sm @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Archivée</option>
                        </select>
                        @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Boutons --}}
                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('filieres.index') }}" class="btn btn-outline-secondary btn-sm">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Enregistrer
                        </button>
                    </div>

                </div>{{-- /row --}}
            </form>
        </div>
    </div>

</div>
@endsection
