@extends('layouts.export')

@section('title', 'Liste des notes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Notes (Grades)</h1>
            <p class="text-muted mb-0">Liste des notes par étudiant et par module.</p>
        </div>
        <a href="{{ route('grades.create') }}" class="btn btn-primary">
            + Nouvelle note
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success small">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Étudiant</th>
                            <th>Module</th>
                            <th class="text-end">Exam</th>
                            <th class="text-end">CC</th>
                            <th class="text-end">Moyenne</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grades as $grade)
                            <tr>
                                <td>{{ $grade->id }}</td>
                                <td>
                                    {{ $grade->student->name ?? 'N/A' }}
                                    <div class="small text-muted">
                                        {{ $grade->student->matricule ?? '' }}
                                    </div>
                                </td>
                                <td>
                                    {{ $grade->module->name ?? 'N/A' }}
                                    <div class="small text-muted">
                                        {{ $grade->module->code ?? '' }}
                                    </div>
                                </td>
                                <td class="text-end">
                                    {{ $grade->score_exam !== null ? number_format($grade->score_exam, 2) : '-' }}
                                </td>
                                <td class="text-end">
                                    {{ $grade->score_cc !== null ? number_format($grade->score_cc, 2) : '-' }}
                                </td>
                                <td class="text-end fw-semibold">
                                    {{ $grade->average !== null ? number_format($grade->average, 2) : '-' }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'pending'   => 'bg-secondary',
                                            'validated' => 'bg-success',
                                            'rejected'  => 'bg-danger',
                                        ][$grade->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($grade->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-outline-primary">
                                        Éditer
                                    </a>
                                    <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Supprimer cette note ?')"
                                        >
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Aucune note enregistrée pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($grades, 'links'))
                <div class="p-3">
                    {{ $grades->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
