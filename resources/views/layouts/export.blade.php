<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'GradeSecure')</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />

    @stack('styles')
</head>
<body class="bg-light">

<div class="d-flex flex-column vh-100">
    {{-- Navbar --}}
    <header class="d-flex align-items-center justify-content-between border-bottom bg-white px-3 py-2 shadow-sm">
        <div class="d-flex align-items-center gap-4">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width: 32px; height: 32px;">
                    <span class="text-primary fw-bold">G</span>
                </div>
                <h2 class="h5 m-0 fw-bold">GradeSecure</h2>
            </div>

            <nav class="d-none d-md-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-body">Tableau de bord</a>
                <a href="#" class="text-decoration-none text-body">Scolarité</a>
                <a href="#" class="text-decoration-none text-body">Examens</a>
                <a href="#" class="text-decoration-none text-primary fw-semibold">Rapports</a>
            </nav>
        </div>

        <div class="d-flex align-items-center gap-3">
            <form class="d-none d-sm-flex align-items-center">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0">🔍</span>
                    <input type="text" class="form-control border-0 bg-light" placeholder="Rechercher..." />
                </div>
            </form>

            <button class="btn btn-sm btn-light rounded-circle">🔔</button>

            <div class="rounded-circle border" style="width: 36px; height: 36px; background:#ccc;"></div>
        </div>
    </header>

    <div class="d-flex flex-grow-1 overflow-hidden">
        {{-- Sidebar --}}
        <aside class="d-none d-lg-flex flex-column flex-shrink-0 bg-white border-end p-3" style="width: 260px;">
            <div class="d-flex flex-column gap-1">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none text-body">
                    <span>🏠</span><span class="small">Accueil</span>
                </a>
                <a href="{{ route('students.index') }}" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none text-body">
                    <span>🎓</span><span class="small">Étudiants</span>
                </a>
                <a href="{{ route('grades.index') }}" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none text-body">
                    <span>✅</span><span class="small">Notes</span>
                </a>
                <a href="{{ route('jurys.index') }}" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none text-body">
                    <span>✅</span><span class="small">Jury</span>
                </a>
                <a href="#" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none bg-primary bg-opacity-10 text-primary fw-semibold">
                    <span>📊</span><span class="small">Rapports</span>
                </a>
            </div>

            <div class="mt-auto d-flex flex-column gap-1">
                <a href="#" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none text-body">
                    <span>⚙️</span><span class="small">Paramètres</span>
                </a>
                <hr class="my-2" />
                <a href="#" class="d-flex align-items-center gap-2 px-2 py-2 rounded text-decoration-none text-danger">
                    <span>🚪</span><span class="small fw-semibold">Déconnexion</span>
                </a>
            </div>
        </aside>

        {{-- Main (zone où tu veux voir la maquette) --}}
        <main class="flex-grow-1 overflow-auto p-3 p-md-4 bg-light">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
