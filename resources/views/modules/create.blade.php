@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Nouveau Module
    </p>

    {{-- Titre + retour --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouveau Module</h1>
            <p class="text-muted mb-0">
                Ajoutez un nouveau module et rattachez-le à une filière, un semestre et un responsable.
            </p>
        </div>

        <a href="{{ route('filieres_modules') }}" class="btn btn-outline-secondary btn-sm">
            Annuler
        </a>
    </div>

    {{-- Mini-menu horizontal --}}
    <div class="d-flex align-items-center gap-4 mb-3 border-bottom pb-2">
        <a href="{{ route('filieres_modules') }}"
           class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>▦</span>
            <span>Modules</span>
        </a>
        <a href="{{ route('filieres.index') }}"
           class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>☷</span>
            <span>Filières</span>
        </a>
        <a href="{{ route('semesters.index') }}"
           class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>🗓</span>
            <span>Semestres</span>
        </a>
        <a href="{{ route('responsables.index') }}"
           class="d-flex align-items-center gap-2 text-decoration-none text-muted">
            <span>👥</span>
            <span>Responsables</span>
        </a>
    </div>

    {{-- Formulaire de création --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('modules.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Code --}}
                    <div class="col-md-4">
                        <label for="code" class="form-label small">Code</label>
                        <input type="text" name="code" id="code"
                               value="{{ old('code') }}"
                               class="form-control form-control-sm @error('code') is-invalid @enderror"
                               placeholder="INF-204">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Intitulé --}}
                    <div class="col-md-8">
                        <label for="title" class="form-label small">Intitulé du module</label>
                        <input type="text" name="title" id="title"
                               value="{{ old('title') }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror"
                               placeholder="Bases de Données Relationnelles">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Filière --}}
                    <div class="col-md-6">
                        <label for="filiere_id" class="form-label small">Filière de rattachement</label>
                        <select name="filiere_id" id="filiere_id"
                                class="form-select form-select-sm @error('filiere_id') is-invalid @enderror">
                            <option value="">Sélectionner une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}"
                                    {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->code }} - {{ $filiere->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('filiere_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Semestre --}}
                    <div class="col-md-3">
                        <label for="semester_id" class="form-label small">Semestre</label>
                        <select name="semester_id" id="semester_id"
                                class="form-select form-select-sm @error('semester_id') is-invalid @enderror">
                            <option value="">Sélectionner</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->code }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Responsable --}}
                    <div class="col-md-3">
                        <label for="responsable_id" class="form-label small">Responsable</label>
                        <select name="responsable_id" id="responsable_id"
                                class="form-select form-select-sm @error('responsable_id') is-invalid @enderror">
                            <option value="">Non assigné</option>
                            @foreach($responsables as $responsable)
                                <option value="{{ $responsable->id }}"
                                    {{ old('responsable_id') == $responsable->id ? 'selected' : '' }}>
                                    {{ $responsable->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('responsable_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Statut --}}
                    <div class="col-md-4">
                        <label for="status" class="form-label small">Statut</label>
                        <select name="status" id="status"
                                class="form-select form-select-sm @error('status') is-invalid @enderror">
                            <option value="actif" {{ old('status', 'actif') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="en_attente" {{ old('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="archive" {{ old('status') == 'archive' ? 'selected' : '' }}>Archivé</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Boutons --}}
                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('filieres_modules') }}" class="btn btn-outline-secondary btn-sm">
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
