@extends('layouts.export')

@section('title', 'Nouvelle note')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouvelle note</h1>
            <p class="text-muted mb-0">Créer une note pour un étudiant et un module.</p>
        </div>
        <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary btn-sm">
            ⬅ Retour à la liste
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('grades.store') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label for="student_id" class="form-label">Étudiant</label>
                    <select
                        name="student_id"
                        id="student_id"
                        class="form-select @error('student_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Sélectionner un étudiant --</option>
                        @foreach($students as $student)
                            <option
                                value="{{ $student->id }}"
                                @selected(old('student_id') == $student->id)
                            >
                                {{ $student->name }} ({{ $student->matricule ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="module_id" class="form-label">Module</label>
                    <select
                        name="module_id"
                        id="module_id"
                        class="form-select @error('module_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Sélectionner un module --</option>
                        @foreach($modules as $module)
                            <option
                                value="{{ $module->id }}"
                                @selected(old('module_id') == $module->id)
                            >
                                {{ $module->code ?? '' }} - {{ $module->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('module_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="score_exam" class="form-label">Note examen</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="20"
                        name="score_exam"
                        id="score_exam"
                        value="{{ old('score_exam') }}"
                        class="form-control @error('score_exam') is-invalid @enderror"
                    >
                    @error('score_exam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="score_cc" class="form-label">Note contrôle continu</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="20"
                        name="score_cc"
                        id="score_cc"
                        value="{{ old('score_cc') }}"
                        class="form-control @error('score_cc') is-invalid @enderror"
                    >
                    @error('score_cc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="average" class="form-label">
                        Moyenne (optionnel, sinon auto-calculée)
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        max="20"
                        name="average"
                        id="average"
                        value="{{ old('average') }}"
                        class="form-control @error('average') is-invalid @enderror"
                    >
                    @error('average')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Statut</label>
                    <select
                        name="status"
                        id="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        <option value="pending"   @selected(old('status') === 'pending')>En attente</option>
                        <option value="validated" @selected(old('status') === 'validated')>Validée</option>
                        <option value="rejected"  @selected(old('status') === 'rejected')>Rejetée</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Enregistrer la note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
