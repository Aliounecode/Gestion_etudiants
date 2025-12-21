<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Gestion Académique')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap / ton CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .ga-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 32px;
        }
        .ga-brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        .ga-tabs {
            background: #f3f4ff;
            border-radius: 999px;
            padding: 4px;
        }
        .ga-tab {
            border-radius: 999px;
            padding: 8px 20px;
            font-size: 0.95rem;
            border: none;
            background: transparent;
            color: #6b7280;
            text-decoration: none;
        }
        .ga-tab-active {
            background: #ffffff;
            color: #2563eb;
            font-weight: 600;
            box-shadow: 0 0 0 1px rgba(148,163,184,.3);
        }
        .ga-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            overflow: hidden;
            background: #e5e7eb;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">

<header class="ga-topbar d-flex align-items-center justify-content-between">

    {{-- Bloc gauche : logo + titre --}}
    <div class="d-flex align-items-center">
        <div class="ga-brand-icon">
            {{-- Icône chapeau / diplôme (par ex. bootstrap icon) --}}
            🎓
        </div>
        <div>
            <div class="fw-semibold">Gestion Académique</div>
            <div class="text-muted small">Portail Administrateur</div>
        </div>
    </div>

    {{-- Onglets centraux --}}
    <div class="ga-tabs d-flex align-items-center gap-1">
        <a href="{{ route('dashboard') }}"
           class="ga-tab {{ request()->routeIs('dashboard') ? 'ga-tab-active' : '' }}">
            Tableau de bord
        </a>
        <a href="{{ route('filieres_modules') }}"
           class="ga-tab {{ request()->routeIs('filieres_modules') ? 'ga-tab-active' : '' }}">
            Filières &amp; Modules
        </a>
        <a href="{{ route('departments.index') }}"
           class="ga-tab {{ request()->routeIs('departments.index') ? 'ga-tab-active' : '' }}">
            Départements
        </a>
        <a href="{{ route('students.index') }}"
           class="ga-tab {{ request()->routeIs('students.*') ? 'ga-tab-active' : '' }}">
            Étudiants
        </a>
        <a href="#"
           class="ga-tab {{ request()->routeIs('settings.*') ? 'ga-tab-active' : '' }}">
            Paramètres
        </a>
    </div>

    {{-- Profil droite --}}
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-link text-muted position-relative">
            🔔
        </button>
        <div class="d-flex align-items-center gap-2">
            <div class="text-end">
                <div class="fw-semibold small">Amine El Idrissi</div>
                <div class="text-muted small">Chef de Département</div>
            </div>
            <div class="ga-user-avatar">
                {{-- <img src="{{ asset('images/user.png') }}" alt="Profil" class="w-100 h-100"> --}}
            </div>
        </div>
    </div>

</header>

<main class="p-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
