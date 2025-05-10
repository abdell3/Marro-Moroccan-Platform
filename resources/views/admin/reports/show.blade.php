<x-layouts.admin :title="'Détails du signalement #' . $report->id . ' | Admin'">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la liste
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Détails du signalement -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                Signalement #{{ $report->id }}
                            </h2>
                            <span class="{{ $report->handled_at ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }} px-2 py-1 rounded-full text-xs font-medium">
                                {{ $report->handled_at ? 'Traité' : 'En attente' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type de signalement</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                    {{ $report->reportType->name }}
                                </dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Signalé par</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full mr-2" src="{{ asset('storage/' . ($report->user->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $report->user->nom }}">
                                        <span>{{ $report->user->prenom }} {{ $report->user->nom }}</span>
                                    </div>
                                </dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date du signalement</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                    {{ $report->created_at->format('d/m/Y à H:i') }}
                                </dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Raison</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                    {{ $report->raison }}
                                </dd>
                            </div>
                            @if($report->handled_at)
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Traité par</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-full mr-2" src="{{ asset('storage/' . ($report->admin->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $report->admin->nom }}">
                                            <span>{{ $report->admin->prenom }} {{ $report->admin->nom }}</span>
                                        </div>
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de traitement</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                        {{ $report->handled_at->format('d/m/Y à H:i') }}
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Action prise</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                        @if($report->action_taken === 'ignored')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                Ignoré
                                            </span>
                                        @elseif($report->action_taken === 'content_removed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Contenu supprimé
                                            </span>
                                        @elseif($report->action_taken === 'user_banned')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Utilisateur banni
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $report->action_taken }}
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                @if($report->admin_notes)
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes d'administration</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                            {{ $report->admin_notes }}
                                        </dd>
                                    </div>
                                @endif
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Contenu signalé -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                            Contenu signalé
                        </h2>
                    </div>
                    <div class="p-6">
                        @if ($report->reportable)
                            @if ($report->reportable_type === 'App\\Models\\Post')
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . ($report->reportable->auteur->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $report->reportable->auteur->nom ?? 'Auteur' }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $report->reportable->auteur->prenom ?? '' }} {{ $report->reportable->auteur->nom ?? 'Utilisateur' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Posté dans <a href="{{ route('communities.show', $report->reportable->community) }}" class="text-red-600 hover:text-red-700">{{ $report->reportable->community->theme_name }}</a> • {{ $report->reportable->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $report->reportable->titre }}</h3>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $report->reportable->contenu }}
                                    </div>
                                    @if($report->reportable->media_path)
                                        <div class="mt-2">
                                            @if(str_contains($report->reportable->media_type, 'image'))
                                                <img src="{{ asset('storage/' . $report->reportable->media_path) }}" alt="Image" class="max-w-full h-auto rounded-lg">
                                            @elseif(str_contains($report->reportable->media_type, 'video'))
                                                <video controls class="max-w-full h-auto rounded-lg">
                                                    <source src="{{ asset('storage/' . $report->reportable->media_path) }}" type="{{ $report->reportable->media_type }}">
                                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                                </video>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('posts.show', $report->reportable) }}" target="_blank" class="inline-flex items-center text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            Voir le post complet
                                            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @elseif ($report->reportable_type === 'App\\Models\\Comment')
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . ($report->reportable->auteur->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $report->reportable->auteur->nom ?? 'Auteur' }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $report->reportable->auteur->prenom ?? '' }} {{ $report->reportable->auteur->nom ?? 'Utilisateur' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $report->reportable->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        {{ $report->reportable->contenu }}
                                    </div>
                                    <div>
                                        <a href="{{ route('posts.show', $report->reportable->post_id) }}#comment-{{ $report->reportable->id }}" target="_blank" class="inline-flex items-center text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            Voir le commentaire dans son contexte
                                            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @elseif ($report->reportable_type === 'App\\Models\\Community')
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($report->reportable->theme_name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $report->reportable->theme_name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $report->reportable->followers->count() }} membres • Créée {{ $report->reportable->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $report->reportable->description }}
                                    </div>
                                    <div>
                                        <a href="{{ route('communities.show', $report->reportable) }}" target="_blank" class="inline-flex items-center text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            Voir la communauté
                                            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 text-sm text-gray-600 dark:text-gray-400">
                                Le contenu signalé n'existe plus ou a été supprimé.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Formulaire de traitement (si non traité) -->
            <div class="lg:col-span-1">
                @if(!$report->handled_at)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden sticky top-6">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                Traiter le signalement
                            </h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.reports.handle', $report) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="action_taken" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Action à prendre</label>
                                    <select id="action_taken" name="action_taken" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                        <option value="ignored">Ignorer le signalement</option>
                                        <option value="content_removed">Supprimer le contenu</option>
                                        <option value="user_banned">Bannir l'utilisateur</option>
                                        <option value="other">Autre action</option>
                                    </select>
                                    @error('action_taken')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (optionnel)</label>
                                    <textarea id="admin_notes" name="admin_notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ajoutez des notes ou des détails sur l'action prise..."></textarea>
                                    @error('admin_notes')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Soumettre
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden sticky top-6">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                Signalement traité
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                            Ce signalement a été traité par {{ $report->admin->prenom }} {{ $report->admin->nom }} le {{ $report->handled_at->format('d/m/Y \à H:i') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('admin.reports.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                    Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>