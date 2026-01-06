@extends('layouts.export')

@section('title', 'Modifier un jury')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Modifier un jury</h1>
            <p class="text-muted mb-0">Mettre à jour les informations du jury et les étudiants associés.</p>
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

            <form action="{{ route('jurys.update', $jury) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du jury</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $jury->name) }}"
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
                        value="{{ old('promotion', $jury->promotion) }}"
                        placeholder="L3 Informatique..."
                    >
                    @error('promotion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-1">
                    <label for="semester" class="form-label">Sem.</label>
                    <input
                        type="text"
                        name="semester"
                        id="semester"
                        class="form-control @error('semester') is-invalid @enderror"
                        value="{{ old('semester', $jury->semester) }}"
                        placeholder="S5"
                    >
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="session" class="form-label">Session</label>
                    <input
                        type="text"
                        name="session"
                        id="session"
                        class="form-control @error('session') is-invalid @enderror"
                        value="{{ old('session', $jury->session) }}"
                        placeholder="Normale, Rattrapage..."
                    >
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
                        value="{{ old('meeting_at', optional($jury->meeting_at)->format('Y-m-d\TH:i')) }}"
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
                        <option value="draft"     @selected(old('status', $jury->status) === 'draft')>Brouillon</option>
                        <option value="validated" @selected(old('status', $jury->status) === 'validated')>Validé</option>
                        <option value="archived"  @selected(old('status', $jury->status) === 'archived')>Archivé</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Étudiants liés (many-to-many) --}}
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
                        @php
                            $selectedStudents = old('students', $jury->students->pluck('id')->toArray());
                        @endphp
                        @foreach($students as $student)
                            <option
                                value="{{ $student->id }}"
                                @if(in_array($student->id, $selectedStudents)) selected @endif
                            >
                                {{ $student->first_name ?? '' }} {{ $student->last_name ?? $student->name }}
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
                        Mettre à jour le jury
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
