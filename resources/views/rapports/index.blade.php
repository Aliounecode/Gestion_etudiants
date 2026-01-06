@extends('layouts.export')

@section('title', 'Exportation des données')

@section('content')
@php
    $docType = request('doc_type');   // releve, jury, liste, raw
    $format  = request('format');     // pdf, xlsx, csv
@endphp

<div class="container-fluid">

    {{-- Breadcrumb + header de page --}}
    <nav class="mb-2 small text-muted">
        <a href="#" class="text-decoration-none text-muted">Accueil</a> /
        <a href="#" class="text-decoration-none text-muted">Gestion des Notes</a> /
        <span class="text-body">Exportation</span>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1 fw-bold">Exportation des Données</h1>
            <p class="text-muted mb-0">
                Générez et téléchargez les relevés de notes et rapports de jury.
            </p>
        </div>
        <a href="#" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <span class="material-symbols-outlined">history</span>
            Historique
        </a>
    </div>

    <div class="row">
        {{-- COLONNE GAUCHE : Configuration --}}
        <div class="col-xl-4 mb-4">
            <div class="card">
                <div class="card-body">

                    {{-- Titre config --}}
                    <div class="d-flex align-items-center mb-3">
                        <h2 class="h6 mb-0 fw-bold">Configuration de l’export</h2>
                    </div>

                    {{-- Type de document --}}
                    <p class="small text-muted mb-1">Type de document</p>
                    <div class="row g-2 mb-3">
                        {{-- Relevé de notes : reste sur la page rapports --}}
                        <div class="col-6">
                            <a href="{{ route('rapports.index', array_merge(request()->all(), ['doc_type' => 'releve'])) }}"
                               class="btn w-100 btn-sm {{ $docType === 'releve' ? 'btn-outline-primary' : 'btn-outline-secondary' }}">
                                <span class="d-block small">Relevé de notes</span>
                            </a>
                        </div>

                        {{-- Rapport Jury : vers jurys.index --}}
                        <div class="col-6">
                            <a href="{{ route('jurys.index', array_merge(request()->except('page'), ['doc_type' => 'jury'])) }}"
                               class="btn w-100 btn-sm {{ $docType === 'jury' ? 'btn-outline-primary' : 'btn-outline-secondary' }}">
                                <span class="d-block small">Rapport Jury</span>
                            </a>
                        </div>

                        {{-- Liste étudiants : vers students.index --}}
                        <div class="col-6">
                            <a href="{{ route('students.index', array_merge(request()->except('page'), ['doc_type' => 'liste'])) }}"
                               class="btn w-100 btn-sm {{ $docType === 'liste' ? 'btn-outline-primary' : 'btn-outline-secondary' }}">
                                <span class="d-block small">Liste étudiants</span>
                            </a>
                        </div>

                        {{-- Données brutes : reste sur rapports.index --}}
                        <div class="col-6">
                            <a href="{{ route('rapports.index', array_merge(request()->all(), ['doc_type' => 'raw'])) }}"
                               class="btn w-100 btn-sm {{ $docType === 'raw' ? 'btn-outline-primary' : 'btn-outline-secondary' }}">
                                <span class="d-block small">Données brutes</span>
                            </a>
                        </div>
                    </div>

                    {{-- Format de sortie --}}
                    <p class="small text-muted mb-1">Format de sortie</p>
                    <div class="btn-group w-100 mb-3">
                        <a href="{{ route('rapports.index', array_merge(request()->all(), ['format' => 'pdf'])) }}"
                           class="btn btn-sm {{ $format === 'pdf' ? 'btn-primary text-white' : 'btn-outline-secondary' }}">
                            PDF
                        </a>
                        <a href="{{ route('rapports.index', array_merge(request()->all(), ['format' => 'xlsx'])) }}"
                           class="btn btn-sm {{ $format === 'xlsx' ? 'btn-primary text-white' : 'btn-outline-secondary' }}">
                            Excel (.xlsx)
                        </a>
                        <a href="{{ route('rapports.index', array_merge(request()->all(), ['format' => 'csv'])) }}"
                           class="btn btn-sm {{ $format === 'csv' ? 'btn-primary text-white' : 'btn-outline-secondary' }}">
                            CSV
                        </a>
                    </div>

                    {{-- Formulaire d’aperçu (utilisé par ExportController@index) --}}
                    <form action="{{ route('rapports.index') }}" method="GET" class="row g-3 mb-3">
                        {{-- On garde les choix doc_type / format dans la query --}}
                        <input type="hidden" name="doc_type" value="{{ $docType }}">
                        <input type="hidden" name="format"   value="{{ $format }}">

                        <div class="col-12">
                            <label for="student_id" class="form-label small mb-1">Étudiant</label>
                            <select
                                name="student_id"
                                id="student_id"
                                class="form-select form-select-sm"
                                required
                            >
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($students as $st)
                                    <option
                                        value="{{ $st->id }}"
                                        @selected(request('student_id') == $st->id)
                                    >
                                        {{ $st->first_name }} {{ $st->last_name }}
                                        @if($st->matricule)
                                            ({{ $st->matricule }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                Aperçu
                            </button>
                        </div>
                    </form>

                    {{-- Champs à inclure (visuel) --}}
                    <p class="small text-muted mb-1">Champs à inclure</p>
                    <div class="border rounded-3 p-3 mb-3">
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" checked id="field-matricule">
                            <label class="form-check-label small" for="field-matricule">Matricule & Nom</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" checked id="field-average">
                            <label class="form-check-label small" for="field-average">Moyenne générale</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" checked id="field-ects">
                            <label class="form-check-label small" for="field-ects">Crédits ECTS</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" checked id="field-decision">
                            <label class="form-check-label small" for="field-decision">Décision du jury</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" id="field-ue">
                            <label class="form-check-label small" for="field-ue">Détail par UE</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="field-rank">
                            <label class="form-check-label small" for="field-rank">Classement</label>
                        </div>
                    </div>

                    {{-- Export sécurisé --}}
                    <div class="border rounded-3 p-3 bg-light mb-3 d-flex gap-2">
                        <div class="text-primary">
                            <span class="material-symbols-outlined">security</span>
                        </div>
                        <div>
                            <p class="mb-1 small fw-semibold text-primary">Export sécurisé</p>
                            <p class="mb-0 small text-muted">
                                Ce document contient des données sensibles. Un filigrane numérique sera ajouté automatiquement.
                            </p>
                        </div>
                    </div>

                    {{-- Bouton d’export PDF réel --}}
                    <form action="{{ route('rapports.export.pdf') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ request('student_id') }}">

                        <button type="submit" class="btn btn-primary w-100 btn-sm" {{ request('student_id') ? '' : 'disabled' }}>
                            Exporter le fichier (PDF)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : Aperçu du document --}}
        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-0 d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined">visibility</span>
                        Aperçu du document
                    </h2>
                    @if($student)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            Données à jour
                        </span>
                    @endif
                </div>

                <div class="card-body bg-light">
                    @if(!$student)
                        <p class="text-muted text-center my-5">
                            Sélectionnez un étudiant puis cliquez sur “Aperçu” pour afficher le relevé.
                        </p>
                    @else
                        <div class="bg-white shadow-sm p-4 mx-auto" style="max-width: 900px;">
                            {{-- En-tête du relevé --}}
                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <span class="material-symbols-outlined text-primary">school</span>
                                    </div>
                                    <div>
                                        <h3 class="h6 mb-1 text-uppercase fw-bold">UNIVERSITÉ DES SCIENCES</h3>
                                        <p class="mb-0 small text-muted">Département d'Informatique</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 small text-muted">
                                        Généré le {{ now()->format('d M Y') }}
                                    </p>
                                    <p class="mb-0 fw-bold">
                                        RELEVÉ DE NOTES
                                    </p>
                                    <p class="mb-0 small text-primary">
                                        Session Normale
                                    </p>
                                </div>
                            </div>

                            {{-- Bloc étudiant --}}
                            <div class="bg-light p-3 mb-3 rounded-3 border">
                                <p class="mb-1 small text-muted text-uppercase fw-semibold">Étudiant</p>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <p class="mb-0 fw-semibold">
                                            {{ $student->first_name }} {{ $student->last_name }}
                                        </p>
                                    </div>
                                    <div class="text-end small text-muted">
                                        Matricule :
                                        <span class="fw-monospace">
                                            {{ $student->matricule ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tableau des notes --}}
                            <table class="table table-sm align-middle mb-3">
                                <thead class="table-light">
                                    <tr>
                                        <th class="small text-muted">CODE</th>
                                        <th class="small text-muted">MATIÈRE</th>
                                        <th class="small text-muted text-end">COEFF.</th>
                                        <th class="small text-muted text-end">NOTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($grades as $grade)
                                        @php
                                            $note = $grade->average;
                                            $noteClass = $note !== null && $note < 10
                                                ? 'text-warning'
                                                : 'text-success';
                                        @endphp
                                        <tr>
                                            <td class="small text-muted">
                                                {{ $grade->module->code ?? '' }}
                                            </td>
                                            <td>
                                                {{ $grade->module->title ?? $grade->module->name ?? 'Matière' }}
                                            </td>
                                            <td class="text-end small">
                                                {{ $grade->module->coefficient ?? '-' }}
                                            </td>
                                            <td class="text-end fw-semibold {{ $noteClass }}">
                                                {{ $note !== null ? number_format($note, 2) : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Aucune note trouvée pour cet étudiant.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($average)
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="3" class="fw-semibold text-uppercase small">
                                                Moyenne générale
                                            </td>
                                            <td class="text-end fw-bold">
                                                {{ number_format($average, 2) }} / 20
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>

                            {{-- Pied de page du relevé --}}
                            <div class="d-flex justify-content-between pt-4 border-top">
                                <div class="text-center">
                                    <div style="height: 40px;"></div>
                                    <p class="small mb-0 text-muted">
                                        Le Chef de Département
                                    </p>
                                </div>
                                <div class="text-end" style="max-width: 260px;">
                                    <p class="small text-muted mb-0 fst-italic">
                                        Document généré automatiquement par GradeSecure.
                                        Tout changement manuel invalide ce document.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Barre d’actions bas (visuelle) --}}
                <div class="card-footer d-flex flex-wrap justify-content-between gap-2">
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" type="button">
                            Sauvegarder modèle
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="window.print()">
                            Imprimer
                        </button>
                    </div>
                    <form action="{{ route('rapports.export.pdf') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ request('student_id') }}">
                        <button type="submit" class="btn btn-primary btn-sm" {{ request('student_id') ? '' : 'disabled' }}>
                            Exporter le fichier (PDF)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
