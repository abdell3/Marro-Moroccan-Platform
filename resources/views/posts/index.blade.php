<x-layouts.app title="Posts | Marro">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Posts</h1>
        <p class="text-gray-600 dark:text-gray-400">Découvrez les derniers posts de la communauté Marro</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Colonne principale (flux de posts) -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="mb-6 space-x-1">
                        <a href="{{ route('posts.index', ['filter' => 'recent']) }}" 
                           class="inline-flex items-center px-3 py-1 border {{ request()->get('filter', 'recent') === 'recent' ? 'border-transparent text-white bg-red-600 hover:bg-red-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600' }} text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Récents
                        </a>
                        <a href="{{ route('posts.index', ['filter' => 'popular']) }}" 
                           class="inline-flex items-center px-3 py-1 border {{ request()->get('filter') === 'popular' ? 'border-transparent text-white bg-red-600 hover:bg-red-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600' }} text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Populaires
                        </a>
                    </div>

                    @forelse($posts as $post)
                        @include('posts.partials.post-card-with-vote', ['post' => $post])
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Aucun post trouvé.</p>
                            <a href="{{ route('posts.create') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Créer un post
                            </a>
                        </div>
                    @endforelse

                    @if($posts->count() > 0 && method_exists($posts, 'links'))
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Barre latérale -->
        <div>
            <!-- Section de création de post -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Créer un post</h2>
                    <a href="{{ route('posts.create') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Nouveau post
                    </a>
                </div>
            </div>

            <!-- Section des communautés populaires -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Communautés populaires</h2>
                    <div class="space-y-4">
                        @forelse($communautesPopulaires ?? [] as $communaute)
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
                            <p class="text-gray-500 dark:text-gray-400 text-center">Aucune communauté trouvée.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('communities.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Voir toutes les communautés
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>