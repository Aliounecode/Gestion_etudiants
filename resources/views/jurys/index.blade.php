@extends('layouts.export')

@section('title', 'Jurys')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Jurys</h1>
            <p class="text-muted mb-0">Gestion des jurys (promotion, semestre, session).</p>
        </div>
        <a href="{{ route('jurys.create') }}" class="btn btn-primary">
            + Nouveau jury
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
                            <th>Nom</th>
                            <th>Promotion</th>
                            <th>Semestre</th>
                            <th>Session</th>
                            <th>Date du jury</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurys as $jury)
                            <tr>
                                <td>{{ $jury->id }}</td>
                                <td>{{ $jury->name }}</td>
                                <td>{{ $jury->promotion ?? '-' }}</td>
                                <td>{{ $jury->semester ?? '-' }}</td>
                                <td>{{ $jury->session ?? '-' }}</td>
                                <td>
                                    {{ $jury->meeting_at ? $jury->meeting_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td>
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
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('jurys.show', $jury) }}" class="btn btn-sm btn-outline-secondary">
                                        Voir
                                    </a>
                                    <a href="{{ route('jurys.edit', $jury) }}" class="btn btn-sm btn-outline-primary">
                                        Éditer
                                    </a>
                                    <form action="{{ route('jurys.destroy', $jury) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Supprimer ce jury ?')"
                                        >
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Aucun jury enregistré pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($jurys, 'links'))
                <div class="p-3">
                    {{ $jurys->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
