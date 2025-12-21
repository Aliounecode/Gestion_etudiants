@extends('layouts.appp')

@section('content')
<div class="container">

    {{-- Fil d’Ariane --}}
    <p class="text-muted mb-1">
        home / Gestion Modules et Filières / Responsables / Nouveau responsable
    </p>

    {{-- Titre + bouton retour --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouveau Responsable</h1>
            <p class="text-muted mb-0">
                Ajoutez une nouvelle personne pouvant être assignée aux modules.
            </p>
        </div>

        <a href="{{ route('responsables.index') }}" class="btn btn-outline-secondary btn-sm">
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
            <form action="{{ route('responsables.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="first_name" class="form-label small">Prénom</label>
                        <input type="text" name="first_name" id="first_name"
                               value="{{ old('first_name') }}"
                               class="form-control form-control-sm @error('first_name') is-invalid @enderror">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="last_name" class="form-label small">Nom</label>
                        <input type="text" name="last_name" id="last_name"
                               value="{{ old('last_name') }}"
                               class="form-control form-control-sm @error('last_name') is-invalid @enderror">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="grade" class="form-label small">Grade</label>
                        <input type="text" name="grade" id="grade"
                               value="{{ old('grade') }}"
                               class="form-control form-control-sm @error('grade') is-invalid @enderror"
                               placeholder="Pr., Dr., Mme., ...">
                        @error('grade')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label small">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               class="form-control form-control-sm @error('email') is-invalid @enderror">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
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
                        <a href="{{ route('responsables.index') }}" class="btn btn-outline-secondary btn-sm">
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
