<x-layouts.app :title="'Signaler un contenu | Marro'">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Signaler un contenu</h2>
                    <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="mb-6">
                    <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Vous signalez :</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                        @if($reportableType == 'post')
                            <div class="flex items-center mb-2">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . ($reportable->auteur->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $reportable->auteur->nom ?? 'Auteur' }}">
                                </div>
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportable->auteur->prenom ?? '' }} {{ $reportable->auteur->nom ?? 'Utilisateur' }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $reportable->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-2">{{ $reportable->titre }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($reportable->contenu, 150) }}</p>
                        @elseif($reportableType == 'comment')
                            <div class="flex items-center mb-2">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . ($reportable->auteur->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $reportable->auteur->nom ?? 'Auteur' }}">
                                </div>
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportable->auteur->prenom ?? '' }} {{ $reportable->auteur->nom ?? 'Utilisateur' }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $reportable->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reportable->contenu }}</p>
                        @elseif($reportableType == 'community')
                            <div class="flex items-center mb-2">
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($reportable->theme_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportable->theme_name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $reportable->followers->count() }} membres</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($reportable->description, 150) }}</p>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    <input type="hidden" name="reportable_type" value="{{ get_class($reportable) }}">
                    <input type="hidden" name="reportable_id" value="{{ $reportable->id }}">
                    
                    <div class="mb-4">
                        <label for="type_report_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Type de signalement
                        </label>
                        <select id="type_report_id" name="type_report_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="" selected disabled>Sélectionner une raison</option>
                            @foreach($reportTypes as $reportType)
                                <option value="{{ $reportType->id }}">{{ $reportType->name }}</option>
                            @endforeach
                        </select>
                        @error('type_report_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="raison" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Détails supplémentaires
                        </label>
                        <textarea id="raison" name="raison" rows="4" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Veuillez expliquer pourquoi vous signalez ce contenu...">{{ old('raison') }}</textarea>
                        @error('raison')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ url()->previous() }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Envoyer le signalement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>