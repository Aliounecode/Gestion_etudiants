@extends('layouts.appp')

@section('content')
<div class="container">

    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Semestres / Nouveau semestre
    </p>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouveau Semestre</h1>
            <p class="text-muted mb-0">
                Ajoutez un nouveau semestre pour organiser les modules et relevés de notes.
            </p>
        </div>

        <a href="{{ route('semesters.index') }}" class="btn btn-outline-secondary btn-sm">
            Annuler
        </a>
    </div>

    {{-- Mini-menu --}}
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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('semesters.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-3">
                        <label for="code" class="form-label small">Code</label>
                        <input type="text" name="code" id="code"
                               value="{{ old('code') }}"
                               class="form-control form-control-sm @error('code') is-invalid @enderror"
                               placeholder="S1, S2...">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label for="name" class="form-label small">Intitulé</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror"
                               placeholder="Semestre 1, Printemps 2025...">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label for="order" class="form-label small">Ordre</label>
                        <input type="number" name="order" id="order"
                               value="{{ old('order', 1) }}"
                               class="form-control form-control-sm @error('order') is-invalid @enderror"
                               min="1">
                        @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label for="is_active" class="form-label small">Statut</label>
                        <select name="is_active" id="is_active"
                                class="form-select form-select-sm @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Archivé</option>
                        </select>
                        @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('semesters.index') }}" class="btn btn-outline-secondary btn-sm">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Enregistrer
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>
@endsection
