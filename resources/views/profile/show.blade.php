<x-layouts.app title="Profil | Marro">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-32 relative">
                <div class="absolute -bottom-16 left-6">
                    <div class="h-32 w-32 rounded-full bg-white dark:bg-gray-800 border-4 border-white dark:border-gray-800 overflow-hidden">
                        <img src="{{ asset('storage/' . (Auth::user()->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ Auth::user()->nom }}" class="h-full w-full object-cover">
                    </div>
                </div>
            </div>
            
            <div class="pt-20 px-6 pb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Membre depuis {{ Auth::user()->created_at->format('F Y') }}</p>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Modifier le profil
                    </a>
                </div>
                
                @if(Auth::user()->badge)
                    <div class="mt-2 mb-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                            {{ Auth::user()->badge->name }}
                        </span>
                    </div>
                @endif
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->posts->count() }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Posts</div>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->comments->count() }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Commentaires</div>
                    </div>
                    
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->communities->count() }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Communautés</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Onglets -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px" x-data="{ activeTab: 'posts' }">
                    <button @click="activeTab = 'posts'" :class="activeTab === 'posts' ? 'border-red-500 text-red-600 dark:text-red-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600'" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Mes posts
                    </button>
                    <button @click="activeTab = 'comments'" :class="activeTab === 'comments' ? 'border-red-500 text-red-600 dark:text-red-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600'" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Mes commentaires
                    </button>
                    <button @click="activeTab = 'communities'" :class="activeTab === 'communities' ? 'border-red-500 text-red-600 dark:text-red-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600'" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Mes communautés
                    </button>
                </nav>
            </div>
            
            <div class="p-6">
                <!-- Contenu des onglets -->
                <div x-show="activeTab === 'posts'">
                    <div class="space-y-6">
                        @forelse(Auth::user()->posts->sortByDesc('created_at')->take(5) as $post)
                            @include('posts.partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore créé de posts.</p>
                                <a href="{{ route('posts.create') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Créer un post
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div x-show="activeTab === 'comments'" style="display: none;">
                    <div class="space-y-4">
                        @forelse(Auth::user()->comments->sortByDesc('created_at')->take(10) as $comment)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <a href="{{ route('posts.show', $comment->post) }}" class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">{{ $comment->post->titre }}</a>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                            <p>{{ $comment->contenu }}</p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('posts.show', $comment->post) }}#comment-{{ $comment->id }}" class="text-xs text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                                Voir dans le contexte
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore commenté de posts.</p>
                                <a href="{{ route('posts.index') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Parcourir les posts
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div x-show="activeTab === 'communities'" style="display: none;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse(Auth::user()->communities as $community)
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
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore rejoint de communautés.</p>
                                <a href="{{ route('communities.index') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Explorer les communautés
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>