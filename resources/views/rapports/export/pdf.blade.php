{{-- resources/views/rapports/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }
        .page {
            width: 100%;
        }
        h1, h2, h3, h4, h5 {
            margin: 0;
            padding: 0;
        }
        .header, .footer {
            width: 100%;
        }
        .header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .student-box {
            background: #f3f4f6;
            padding: 8px;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #f9fafb;
            font-weight: bold;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .small {
            font-size: 11px;
        }
    </style>
</head>
<body>
<div class="page">
    {{-- En-tête --}}
    <div class="header">
        <table class="header">
            <tr>
                <td>
                    <h3 style="text-transform: uppercase;">Université des Sciences</h3>
                    <p class="small">Département d'Informatique</p>
                </td>
                <td class="text-right">
                    <p class="small">
                        Généré le {{ $generated_at->format('d/m/Y') }}
                    </p>
                    <h4>RELEVÉ DE NOTES</h4>
                </td>
            </tr>
        </table>
    </div>

    {{-- Étudiant --}}
    <div class="student-box">
        <p class="small" style="text-transform: uppercase; font-weight: bold;">
            Étudiant
        </p>
        <table>
            <tr>
                <td>
                    {{ $student->first_name ?? '' }} {{ $student->last_name ?? $student->name }}
                </td>
                <td class="text-right small">
                    Matricule :
                    <span style="font-family: monospace;">
                        {{ $student->matricule ?? '-' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    {{-- Tableau des notes --}}
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Matière</th>
                <th class="text-right">Examen</th>
                <th class="text-right">CC</th>
                <th class="text-right">Moyenne</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $grade)
                <tr>
                    <td class="small">
                        {{ $grade->module->code ?? '' }}
                    </td>
                    <td>
                        {{ $grade->module->name ?? 'Matière' }}
                    </td>
                    <td class="text-right">
                        {{ $grade->score_exam !== null ? number_format($grade->score_exam, 2) : '-' }}
                    </td>
                    <td class="text-right">
                        {{ $grade->score_cc !== null ? number_format($grade->score_cc, 2) : '-' }}
                    </td>
                    <td class="text-right">
                        {{ $grade->average !== null ? number_format($grade->average, 2) : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-right small">
                        Aucune note trouvée.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($average)
            <tfoot>
                <tr>
                    <td colspan="4" class="small" style="text-transform: uppercase; font-weight: bold;">
                        Moyenne générale
                    </td>
                    <td class="text-right" style="font-weight: bold;">
                        {{ number_format($average, 2) }} / 20
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>

    {{-- Pied de page --}}
    <div class="footer">
        <table class="footer">
            <tr>
                <td class="small" style="padding-top: 20px;">
                    Le Chef de Département
                </td>
                <td class="text-right small" style="font-style: italic;">
                    Document généré automatiquement. Tout changement manuel invalide ce document.
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
