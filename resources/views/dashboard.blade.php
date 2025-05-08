<x-layouts.app title="Tableau de bord | Marro">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Flux d'actualités</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('dashboard', ['filter' => 'recent']) }}" class="inline-flex items-center px-3 py-1 border {{ $filter === 'recent' ? 'border-transparent text-white bg-red-600 hover:bg-red-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600' }} text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Récents
                            </a>
                            <a href="{{ route('dashboard', ['filter' => 'popular']) }}" class="inline-flex items-center px-3 py-1 border {{ $filter === 'popular' ? 'border-transparent text-white bg-red-600 hover:bg-red-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600' }} text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Populaires
                            </a>
                            <a href="{{ route('dashboard', ['filter' => 'following']) }}" class="inline-flex items-center px-3 py-1 border {{ $filter === 'following' ? 'border-transparent text-white bg-red-600 hover:bg-red-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600' }} text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Suivis
                            </a>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse($posts as $post)
                            @include('posts.partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">
                                    @if($filter === 'following')
                                        Vous ne suivez aucune communauté ou il n'y a pas de posts récents dans vos communautés.
                                    @else
                                        Aucun post trouvé.
                                    @endif
                                </p>
                                <div class="mt-4">
                                    @if($filter === 'following')
                                        <a href="{{ route('communities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Explorer les communautés
                                        </a>
                                    @else
                                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Créer un post
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre latérale -->
        <div>
            <!-- Section de bienvenue / profil -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-16 w-16 rounded-full" src="{{ asset(Auth::user()->avatar ?? 'avatars/default.png') }}" alt="{{ Auth::user()->nom }}">
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Bienvenue, {{ Auth::user()->prenom }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <a href="{{ route('profile.show') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil
                        </a>
                        <a href="{{ route('posts.create') }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Poster
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mes communautés -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mes communautés</h2>
                        <a href="{{ route('profile.communities') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                            Voir tout
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse(Auth::user()->communities->take(5) as $community)
                            <a href="{{ route('communities.show', $community) }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                <div class="flex-shrink-0 w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-lg font-bold text-white">
                                    {{ substr($community->theme_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $community->theme_name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $community->followers->count() }} membres</div>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">Vous n'avez pas encore rejoint de communautés.</p>
                            <div class="mt-3 text-center">
                                <a href="{{ route('communities.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    Explorer les communautés
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Posts sauvegardés -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Posts sauvegardés</h2>
                        <a href="{{ route('profile.saved-posts') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                            Voir tout
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($savedPosts->take(5) as $savedPost)
                            @if($savedPost->post)
                                <a href="{{ route('posts.show', $savedPost->post) }}" class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $savedPost->post->titre }}</h3>
                                    <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $savedPost->post->auteur->prenom }} {{ $savedPost->post->auteur->nom }}</span>
                                        <span class="mx-1">&bull;</span>
                                        <span>{{ $savedPost->post->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            @endif
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">Vous n'avez pas encore sauvegardé de posts.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>