<x-layouts.app title="Marro - Partagez vos passions">
    <!-- Hero Section -->
    <div class="py-12 md:py-20 px-4 sm:px-6 lg:px-8 text-center bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-lg mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Bienvenue sur Marro</h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Rejoignez notre communauté et partagez vos passions avec le monde entier</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-md mx-auto">
            @guest
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-purple-700 font-medium rounded-lg shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-700">
                    S'inscrire
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3 border border-white text-white font-medium rounded-lg hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-700">
                    Se connecter
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-purple-700 font-medium rounded-lg shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-700">
                    Mon tableau de bord
                </a>
                <a href="{{ route('posts.create') }}" class="px-6 py-3 border border-white text-white font-medium rounded-lg hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-700">
                    Créer un post
                </a>
            @endguest
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Posts récents -->
        <div class="md:col-span-2 space-y-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Posts récents</h2>
                        <a href="{{ route('posts.index') }}" class="text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 font-medium">
                            Voir tous les posts
                        </a>
                    </div>
                    
                    <div class="space-y-6">
                        @forelse($recentPosts as $post)
                            @include('posts.partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Aucun post récent trouvé.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Communautés populaires -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Communautés populaires</h2>
                    <div class="space-y-4">
                        @forelse($popularCommunities as $community)
                            <a href="{{ route('communities.show', $community) }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                <div class="flex-shrink-0 w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-lg font-bold text-white">
                                    {{ substr($community->theme_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $community->theme_name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $community->followers_count }} membres</div>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">Aucune communauté trouvée.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('communities.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Explorer les communautés
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tags populaires -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tags populaires</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($popularTags as $tag)
                            <a href="{{ route('tags.show', $tag) }}" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">
                                #{{ $tag->title }}
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">Aucun tag populaire.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Pourquoi rejoindre Marro?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Communauté vibrante</h3>
                <p class="text-gray-600 dark:text-gray-400">Rejoignez des milliers d'utilisateurs partageant vos centres d'intérêt</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Discussions enrichissantes</h3>
                <p class="text-gray-600 dark:text-gray-400">Échangez des idées et participez à des conversations stimulantes</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Contenu diversifié</h3>
                <p class="text-gray-600 dark:text-gray-400">Découvrez un large éventail de sujets adaptés à vos intérêts</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-900 rounded-lg mt-12">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Prêt à rejoindre Marro?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">Rejoignez notre communauté grandissante et commencez à partager dès aujourd'hui!</p>
            
            @guest
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        S'inscrire gratuitement
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 border border-red-600 text-red-600 font-medium rounded-lg hover:bg-red-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Se connecter
                    </a>
                </div>
            @else
                <div>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Accéder à mon tableau de bord
                    </a>
                </div>
            @endguest
        </div>
    </div>
</x-layouts.app>