@extends('layouts.export')

@section('title', 'Nouveau jury')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Nouveau jury</h1>
            <p class="text-muted mb-0">Créer un jury et lui associer des étudiants.</p>
        </div>
        <a href="{{ route('jurys.index') }}" class="btn btn-outline-secondary btn-sm">
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

            <form action="{{ route('jurys.store') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du jury</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="promotion" class="form-label">Promotion</label>
                    <input
                        type="text"
                        name="promotion"
                        id="promotion"
                        class="form-control @error('promotion') is-invalid @enderror"
                        value="{{ old('promotion') }}"
                        placeholder="L3 Informatique..."
                    >
                    @error('promotion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Semestre dynamique depuis la base --}}
                <div class="col-md-1">
                    <label for="semester" class="form-label">Sem.</label>
                    <select
                        name="semester"
                        id="semester"
                        class="form-select @error('semester') is-invalid @enderror"
                    >
                        <option value="">--</option>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem }}" @selected(old('semester') === $sem)>
                                {{ $sem }}
                            </option>
                        @endforeach
                    </select>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Session : Normale / Rattrapage --}}
                <div class="col-md-2">
                    <label for="session" class="form-label">Session</label>
                    <select
                        name="session"
                        id="session"
                        class="form-select @error('session') is-invalid @enderror"
                    >
                        <option value="">--</option>
                        <option value="Normale" @selected(old('session') === 'Normale')>Normale</option>
                        <option value="Rattrapage" @selected(old('session') === 'Rattrapage')>Rattrapage</option>
                    </select>
                    @error('session')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="meeting_at" class="form-label">Date du jury</label>
                    <input
                        type="datetime-local"
                        name="meeting_at"
                        id="meeting_at"
                        class="form-control @error('meeting_at') is-invalid @enderror"
                        value="{{ old('meeting_at') }}"
                    >
                    @error('meeting_at')
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
                        <option value="draft"     @selected(old('status') === 'draft')>Brouillon</option>
                        <option value="validated" @selected(old('status') === 'validated')>Validé</option>
                        <option value="archived"  @selected(old('status') === 'archived')>Archivé</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="students" class="form-label">
                        Étudiants concernés par le jury
                    </label>
                    <select
                        name="students[]"
                        id="students"
                        class="form-select @error('students') is-invalid @enderror"
                        multiple
                        size="8"
                    >
                        @foreach($students as $student)
                            <option
                                value="{{ $student->id }}"
                                @if(collect(old('students'))->contains($student->id)) selected @endif
                            >
                                {{ $student->name }}
                                @if($student->matricule)
                                    ({{ $student->matricule }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">
                        Maintiens Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs étudiants.
                    </div>
                    @error('students')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('students.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('jurys.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Enregistrer le jury
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
