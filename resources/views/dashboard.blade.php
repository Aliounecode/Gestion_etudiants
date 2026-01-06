@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between px-6 py-4 border-b border-[#e7ebf3] dark:border-gray-800 bg-white dark:bg-[#1a2230]">
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#0d121b] dark:text-white tracking-tight">
            Bonjour, {{ Auth::user()->name }}
        </h1>
        <p class="text-[#4c669a] dark:text-gray-400 text-sm">
            Voici ce qui se passe dans votre département aujourd'hui.
        </p>
    </div>
    
    <div class="hidden sm:flex">
        <a href="{{route('import.index') }}"
           class="flex items-center justify-center gap-2 rounded-lg bg-primary h-10 px-6 text-white text-sm font-bold shadow-sm hover:bg-blue-700 transition-colors">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>Nouveau Scan</span>
        </a>
    </div>
</div>

<div class="p-6 space-y-8">
    
    {{-- Cartes stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="flex flex-col gap-4 rounded-xl p-5 bg-white dark:bg-[#1a2230] border border-[#e7ebf3] dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-primary">
                    <span class="material-symbols-outlined">description</span>
                </div>
            </div>
            <div>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium">Feuilles Scannées</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-bold mt-1">{{ $stats['scans_count'] }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-4 rounded-xl p-5 bg-white dark:bg-[#1a2230] border border-[#e7ebf3] dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600">
                    <span class="material-symbols-outlined">view_module</span>
                </div>
            </div>
            <div>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium">Modules Actifs</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-bold mt-1">{{ $stats['modules_active'] }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-4 rounded-xl p-5 bg-white dark:bg-[#1a2230] border border-[#e7ebf3] dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg text-orange-600">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                @if($stats['pending_grades'] > 0)
                    <span class="text-xs font-medium px-2 py-1 bg-orange-50 text-orange-700 rounded-full flex items-center gap-1">
                        {{ $stats['pending_grades'] }} en attente
                    </span>
                @endif
            </div>
            <div>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium">Validations Requises</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-bold mt-1">{{ $stats['pending_grades'] }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-4 rounded-xl p-5 bg-white dark:bg-[#1a2230] border border-[#e7ebf3] dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-600">
                    <span class="material-symbols-outlined">groups</span>
                </div>
            </div>
            <div>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium">Total Étudiants</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-bold mt-1">{{ $stats['students_count'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        {{-- Activités récentes --}}
        <div class="xl:col-span-2 space-y-8">
            <div class="flex flex-col gap-4 bg-white dark:bg-[#1a2230] rounded-xl border border-[#e7ebf3] dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-[#e7ebf3] dark:border-gray-800">
                    <h3 class="text-lg font-bold text-[#0d121b] dark:text-white">Activités Récentes</h3>
                    <button class="text-sm font-medium text-primary hover:text-blue-700 transition">
                        Tout voir
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#f8f9fc] dark:bg-gray-800/50 text-[#4c669a] dark:text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-medium">Module</th>
                                <th class="px-6 py-4 font-medium">Professeur</th>
                                <th class="px-6 py-4 font-medium">Date</th>
                                <th class="px-6 py-4 font-medium">Statut</th>
                                <th class="px-6 py-4 font-medium text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e7ebf3] dark:divide-gray-800">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-primary font-bold text-xs">
                                            CS
                                        </div>
                                        <span class="text-sm font-medium text-[#0d121b] dark:text-white">
                                            Computer Science 101
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">
                                    Aujourd'hui
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="size-1.5 rounded-full bg-green-600"></span>
                                        Sécurisé
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-primary transition">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="hidden p-8 text-center text-gray-500">
                        Aucune activité récente.
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions rapides + encart sécurité --}}
        <div class="space-y-8">
            <div class="flex flex-col gap-4">
                <h3 class="text-lg font-bold text-[#0d121b] dark:text-white px-1">
                    Actions Rapides
                </h3>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{route('import.index') }}"
                       class="group flex items-center p-4 bg-primary text-white rounded-xl shadow-lg shadow-blue-200 dark:shadow-none hover:shadow-xl hover:bg-blue-700 transition-all">
                        <div class="bg-white/20 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[24px]">add_a_photo</span>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-lg leading-tight">Nouveau Scan</p>
                            <p class="text-blue-100 text-xs mt-0.5">Démarrer numérisation</p>
                        </div>
                        <span class="material-symbols-outlined ml-auto opacity-70">arrow_forward</span>
                    </a>

                    <a href="{{ route('filieres_modules') }}"
                       class="group flex items-center p-4 bg-white dark:bg-[#1a2230] border border-[#e7ebf3] dark:border-gray-800 rounded-xl hover:border-primary/50 dark:hover:border-primary/50 transition-all text-[#0d121b] dark:text-white">
                        <div class="bg-purple-50 dark:bg-purple-900/20 text-purple-600 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[24px]">school</span>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-base leading-tight">Gérer Modules</p>
                            <p class="text-[#4c669a] dark:text-gray-400 text-xs mt-0.5">Créer ou modifier</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="relative rounded-xl overflow-hidden h-40 group cursor-pointer border border-gray-200 dark:border-gray-700">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                     style='background-image: url("https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&q=80&w=1000");'>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <p class="font-bold text-lg">Sécurité Renforcée</p>
                    <p class="text-xs text-gray-300 w-4/5">Tous les documents sont chiffrés.</p>
                </div>
                <div class="absolute top-3 right-3 bg-white/20 backdrop-blur-sm p-1.5 rounded-lg text-white">
                    <span class="material-symbols-outlined text-[18px]">lock</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
