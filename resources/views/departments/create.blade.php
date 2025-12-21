@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Départements / Nouveau département
    </p>

    {{-- Titre + bouton retour --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouveau département</h1>
            <p class="text-muted mb-0">
                Ajoutez un département pour organiser vos filières.
            </p>
        </div>

        <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary btn-sm">
            Annuler
        </a>
    </div>

    {{-- Mini-menu horizontal --}}
    <div class="d-flex align-items-center gap-4 mb-3 border-bottom pb-2">
        <a href="{{ route('filieres_modules') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>▦</span><span>Modules</span>
        </a>
        <a href="{{ route('filieres.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>☷</span><span>Filières</span>
        </a>
        <a href="{{ route('semesters.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>🗓</span><span>Semestres</span>
        </a>
        <a href="{{ route('responsables.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>👥</span><span>Responsables</span>
        </a>
    </div>

    {{-- Formulaire de création --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-3">
                        <label for="code" class="form-label small">Code</label>
                        <input type="text" name="code" id="code"
                               value="{{ old('code') }}"
                               class="form-control form-control-sm @error('code') is-invalid @enderror">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label small">Intitulé</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="is_active"
                                   value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="is_active">
                                Actif
                            </label>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary btn-sm">
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
