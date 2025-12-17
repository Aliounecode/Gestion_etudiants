<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GradeScanner Pro') }}</title>
    
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f8f9fc",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Lexend", "Noto Sans", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-white transition-colors duration-200">
    <div class="relative flex h-screen w-full flex-col overflow-hidden">
        
        @include('layouts.navigation')

        <div class="flex flex-1 overflow-hidden">
            <aside class="hidden lg:flex flex-col w-72 bg-white dark:bg-[#1a2230] border-r border-[#e7ebf3] dark:border-gray-800 shrink-0 h-full overflow-y-auto">
                <div class="flex flex-col p-6 h-full justify-between">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-[#0d121b] dark:text-white text-lg font-bold leading-normal">Menu Principal</h1>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary/10 border-l-4 border-primary text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-[#4c669a] dark:text-gray-400' }}" href="{{ route('dashboard') }}">
                                <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'fill' : '' }}">dashboard</span>
                                <p class="text-sm font-bold leading-normal">Tableau de bord</p>
                            </a>
                            
                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('modules.*') ? 'bg-primary/10 border-l-4 border-primary text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-[#4c669a] dark:text-gray-400' }}" href="{{ route('modules.index') }}">
                                <span class="material-symbols-outlined">school</span>
                                <p class="text-sm font-medium leading-normal">Modules & Filières</p>
                            </a>

                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('import.*') ? 'bg-primary/10 border-l-4 border-primary text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-[#4c669a] dark:text-gray-400' }}" href="{{ route('import.index') }}">
                                <span class="material-symbols-outlined">upload_file</span>
                                <p class="text-sm font-medium leading-normal">Import / Scan</p>
                            </a>

                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('grades.*') ? 'bg-primary/10 border-l-4 border-primary text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-[#4c669a] dark:text-gray-400' }}" href="{{ route('grades.index') }}">
                                <span class="material-symbols-outlined">check_circle</span>
                                <p class="text-sm font-medium leading-normal">Validation Notes</p>
                            </a>

                             <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('export.*') ? 'bg-primary/10 border-l-4 border-primary text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-[#4c669a] dark:text-gray-400' }}" href="{{ route('export.index') }}">
                                <span class="material-symbols-outlined">print</span>
                                <p class="text-sm font-medium leading-normal">Exportation</p>
                            </a>

                            <div class="h-px bg-gray-200 dark:bg-gray-700 my-2"></div>

                            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-primary/10 border-l-4 border-primary text-primary' : 'hover:bg-gray-50 dark:hover:bg-gray-800 text-[#4c669a] dark:text-gray-400' }}" href="{{ route('profile.edit') }}">
                                <span class="material-symbols-outlined">person</span>
                                <p class="text-sm font-medium leading-normal">Mon Profil</p>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-4 lg:p-10 scroll-smooth">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>