@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nouvelle Importation</h1>
            <p class="text-gray-500 dark:text-gray-400">Numérisez, taguez et archivez les feuilles de notes.</p>
        </div>

        <div class="flex items-center justify-end space-x-4 text-sm font-medium text-gray-500 mb-2">
            <div class="flex items-center text-primary font-bold">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary text-white text-xs mr-2">1</span>
                Upload
            </div>
            <div class="w-12 h-px bg-gray-200 dark:bg-gray-700"></div>
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 text-xs mr-2">2</span>
                Détails
            </div>
            <div class="w-12 h-px bg-gray-200 dark:bg-gray-700"></div>
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 text-xs mr-2">3</span>
                Validation
            </div>
        </div>

        <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white dark:bg-[#1a2230] rounded-xl border-2 border-dashed border-blue-200 dark:border-gray-700 p-10 text-center hover:bg-blue-50/30 transition-colors relative group">
                        <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                        
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-primary mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">cloud_upload</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Glissez vos fichiers ici</h3>
                        <p class="text-blue-600 font-medium cursor-pointer hover:underline">ou cliquez pour parcourir votre ordinateur</p>
                        
                        <div class="mt-6 flex justify-center gap-2">
                            <span class="px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 dark:bg-gray-700 rounded uppercase">PDF</span>
                            <span class="px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 dark:bg-gray-700 rounded uppercase">JPG</span>
                            <span class="px-2 py-1 text-[10px] font-bold text-gray-500 bg-gray-100 dark:bg-gray-700 rounded uppercase">PNG</span>
                        </div>
                        <p class="mt-2 text-xs text-gray-400">Max 25 Mo par fichier</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Fichiers en attente (Exemple)</h4>
                        <div class="bg-white dark:bg-[#1a2230] rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden divide-y divide-gray-100 dark:divide-gray-700">
                            <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center">
                                        <span class="material-symbols-outlined">picture_as_pdf</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Notes_Exam_Algebre.pdf</p>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span>2.4 MB</span>
                                            <span class="text-green-600 flex items-center gap-1 font-medium bg-green-50 px-1.5 rounded"><span class="material-symbols-outlined text-[12px]">check</span> Prêt</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="text-gray-400 hover:text-red-500"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-white dark:bg-[#1a2230] rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm sticky top-6">
                        
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">tune</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Catégorisation</h2>
                                <p class="text-xs text-gray-500">Infos liées aux notes extraites.</p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-1.5">
                                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Département</label>
                                <select class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 text-sm focus:ring-primary focus:border-primary">
                                    <option>Département Informatique</option>
                                    <option>Département Mathématiques</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Filière</label>
                                    <select name="filiere_id" class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 text-sm focus:ring-primary focus:border-primary">
                                        <option value="">Sélectionner...</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Semestre</label>
                                    <select name="semester" class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 text-sm focus:ring-primary focus:border-primary">
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="S4">S4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Module</label>
                                <select name="module_id" class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 text-sm focus:ring-primary focus:border-primary">
                                    <option value="">Choisir un module...</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->code }} - {{ $module->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Date de l'examen</label>
                                <input type="date" name="exam_date" class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 text-sm focus:ring-primary focus:border-primary">
                            </div>

                            <div class="flex items-center gap-2 pt-2">
                                <input type="checkbox" id="apply_all" class="rounded text-primary focus:ring-primary border-gray-300">
                                <label for="apply_all" class="text-sm text-gray-600 dark:text-gray-400 font-medium">Appliquer ces infos à tous les fichiers</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 lg:left-72 bg-white dark:bg-[#1a2230] border-t border-gray-200 dark:border-gray-800 p-4 z-40 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
                <div class="max-w-7xl mx-auto flex items-center justify-between px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary animate-pulse">
                            <span class="material-symbols-outlined">auto_awesome</span>
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-bold text-gray-900 dark:text-white text-sm">Prêt à numériser</p>
                            <p class="text-xs text-gray-500">Vérifiez les infos avant validation</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-50 transition">Annuler</button>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-white font-bold text-sm shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition flex items-center gap-2 transform active:scale-95">
                            <span class="material-symbols-outlined">document_scanner</span>
                            Numériser et Enregistrer
                        </button>
                    </div>
                </div>
            </div>
            <div class="h-24"></div>
        </form>
    </div>

@endsection