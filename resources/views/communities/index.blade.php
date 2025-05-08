<x-layouts.app title="Communautés | Marro">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Communautés</h1>
        <p class="text-gray-600 dark:text-gray-400">Explorez et rejoignez des communautés qui vous intéressent</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Colonne principale (liste des communautés) -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Toutes les communautés</h2>
                            
                            <!-- Recherche -->
                            <form action="{{ route('communities.search') }}" method="GET" class="relative">
                                <input type="text" name="q" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-800 dark:text-white">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($communities as $community)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition duration-150 ease-in-out">
                                <a href="{{ route('communities.show', $community) }}" class="block">
                                    <div class="p-4">
                                        <div class="flex items-center mb-3">
                                            <div class="flex-shrink-0 w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-xl font-bold text-white">
                                                {{ substr($community->theme_name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $community->theme_name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $community->followers->count() }} membres</div>
                                            </div>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                            {{ Str::limit($community->description, 100) }}
                                        </p>
                                    </div>
                                </a>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-600">
                                    @auth
                                        @if(Auth::user()->communities->contains($community->id))
                                            <form action="{{ route('communities.unfollow', $community) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-500">
                                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Quitter
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('communities.follow', $community) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Rejoindre
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Se connecter pour rejoindre
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Aucune communauté trouvée.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre latérale -->
        <div>
            <!-- Créer une communauté -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Créer une communauté</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Vous avez une passion ou un intérêt à partager? Créez votre propre communauté!</p>
                    <a href="{{ route('communities.create') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Créer une communauté
                    </a>
                </div>
            </div>

            <!-- Communautés populaires -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Communautés populaires</h2>
                    <div class="space-y-4">
                        @forelse($populaires as $communaute)
                            <a href="{{ route('communities.show', $communaute) }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                <div class="flex-shrink-0 w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-lg font-bold text-white">
                                    {{ substr($communaute->theme_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $communaute->theme_name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $communaute->followers_count ?? 0 }} membres</div>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">Aucune communauté populaire trouvée.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Mes communautés -->
            @auth
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Mes communautés</h2>
                        <div class="space-y-4">
                            @forelse(Auth::user()->communities as $communaute)
                                <a href="{{ route('communities.show', $communaute) }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-lg font-bold text-white">
                                        {{ substr($communaute->theme_name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $communaute->theme_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $communaute->followers->count() }} membres</div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 text-center">Vous n'avez rejoint aucune communauté.</p>
                                <div class="text-center mt-3">
                                    <a href="{{ route('communities.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        Explorer les communautés
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endauth
        </div>