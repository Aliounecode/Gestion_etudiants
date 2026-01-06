@extends('layouts.export')

@section('title', 'Détail du jury')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Détail du jury</h1>
            <p class="text-muted mb-0">
                Informations sur le jury et les étudiants associés.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('jurys.edit', $jury) }}" class="btn btn-primary btn-sm">
                Éditer
            </a>
            <a href="{{ route('jurys.index') }}" class="btn btn-outline-secondary btn-sm">
                ⬅ Retour à la liste
            </a>
        </div>
    </div>

    {{-- Carte infos jury --}}
    <div class="card mb-4">
        <div class="card-body row g-3">
            <div class="col-md-6">
                <h2 class="h6 text-muted">Informations générales</h2>
                <p class="mb-1">
                    <span class="fw-semibold">Nom :</span>
                    {{ $jury->name }}
                </p>
                <p class="mb-1">
                    <span class="fw-semibold">Promotion :</span>
                    {{ $jury->promotion ?? '-' }}
                </p>
                <p class="mb-1">
                    <span class="fw-semibold">Semestre :</span>
                    {{ $jury->semester ?? '-' }}
                </p>
                <p class="mb-1">
                    <span class="fw-semibold">Session :</span>
                    {{ $jury->session ?? '-' }}
                </p>
            </div>

            <div class="col-md-6">
                <h2 class="h6 text-muted">Planification</h2>
                <p class="mb-1">
                    <span class="fw-semibold">Date du jury :</span>
                    {{ $jury->meeting_at ? $jury->meeting_at->format('d/m/Y H:i') : '-' }}
                </p>
                <p class="mb-1">
                    <span class="fw-semibold">Statut :</span>
                    @php
                        $badgeClass = [
                            'draft'     => 'bg-secondary',
                            'validated' => 'bg-success',
                            'archived'  => 'bg-dark',
                        ][$jury->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ ucfirst($jury->status) }}
                    </span>
                </p>
                <p class="mb-0 small text-muted">
                    Créé le {{ $jury->created_at->format('d/m/Y H:i') }},
                    mis à jour le {{ $jury->updated_at->format('d/m/Y H:i') }}.
                </p>
            </div>
        </div>
    </div>

    {{-- Carte étudiants --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="h6 mb-0">Étudiants du jury</h2>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                {{ $jury->students->count() }} étudiant(s)
            </span>
        </div>
        <div class="card-body p-0">
            @if($jury->students->isEmpty())
                <p class="text-muted text-center my-4">
                    Aucun étudiant associé à ce jury pour le moment.
                </p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Étudiant</th>
                                <th>Matricule</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jury->students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>
                                        {{ $student->first_name ?? '' }} {{ $student->last_name ?? $student->name }}
                                    </td>
                                    <td>
                                        {{ $student->matricule ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
