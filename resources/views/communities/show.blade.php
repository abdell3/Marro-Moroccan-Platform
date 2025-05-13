<x-layouts.app :title="$community->theme_name . ' | Marro'">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-32 relative">
                    @if($community->icon)
                        <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->theme_name }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute -bottom-12 left-6">
                        <div class="w-24 h-24 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-3xl font-bold text-white border-4 border-white dark:border-gray-800">
                            {{ substr($community->theme_name, 0, 1) }}
                        </div>
                    </div>
                </div>
                
                <div class="p-6 pt-16">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $community->theme_name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $membersCount }} membres</p>
                        </div>
                        
                        @auth
                            <div>
                                @if($isFollowing)
                                    <form action="{{ route('communities.unfollow', $community) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-500">
                                            Quitter
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('communities.follow', $community) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Rejoindre
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Se connecter pour rejoindre
                            </a>
                        @endauth
                    </div>
                    
                    <div class="mt-4 prose dark:prose-invert max-w-none">
                        <p>{{ $community->description }}</p>
                    </div>
                    
                    @if($community->rules)
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-md p-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Règles de la communauté</h2>
                            <div class="prose dark:prose-invert prose-sm max-w-none">
                                <p>{{ $community->rules }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @can('update', $community)
                        <div class="mt-6 flex space-x-2">
                            <a href="{{ route('communities.edit', $community) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 bg-white text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier
                            </a>
                            
                            <form action="{{ route('communities.destroy', $community) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette communauté?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                    <div class="flex space-x-8">
                        <a href="#posts" class="border-b-2 border-red-500 text-gray-900 dark:text-white px-1 py-4 text-sm font-medium">
                            Posts
                        </a>
                        <a href="#threads" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-600 px-1 py-4 text-sm font-medium">
                            Discussions
                        </a>
                    </div>
                </div>
            </div>
            
            <div id="posts" class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Publications récentes</h2>
                        @auth
                            <a href="{{ route('posts.create', ['community_id' => $community->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Nouveau post
                            </a>
                        @endauth
                    </div>
                    
                    <div class="space-y-6">
                        @forelse($posts as $post)
                            @include('posts.partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Aucun post</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Soyez le premier à créer un post dans cette communauté.</p>
                                
                                @auth
                                    <div class="mt-6">
                                        <a href="{{ route('posts.create', ['community_id' => $community->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Créer un post
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-6">
                                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Se connecter pour poster
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                    
                    @if($posts->count() > 0 && method_exists($posts, 'links'))
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div id="threads" class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden" style="display: none;">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Discussions récentes</h2>
                        @auth
                            <a href="{{ route('threads.create', ['community_id' => $community->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Nouvelle discussion
                            </a>
                        @endauth
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($threads as $thread)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition duration-150 ease-in-out">
                                <a href="{{ route('threads.show', $thread) }}" class="block p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($thread->user && $thread->user->avatar)
                                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $thread->user->avatar) }}" alt="{{ $thread->user->nom ?? 'Utilisateur' }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-sm font-bold text-white">
                                                    {{ $thread->user ? substr($thread->user->prenom, 0, 1) : 'U' }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $thread->title }}</h3>
                                            <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <span>{{ $thread->user->prenom }} {{ $thread->user->nom }}</span>
                                                <span class="mx-1">&bull;</span>
                                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                                {{ Str::limit($thread->content, 150) }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Aucune discussion</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Soyez le premier à créer une discussion dans cette communauté.</p>
                                
                                @auth
                                    <div class="mt-6">
                                        <a href="{{ route('threads.create', ['community_id' => $community->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Créer une discussion
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-6">
                                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Se connecter pour participer
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                    
                    @if($threads->count() > 0 && method_exists($threads, 'links'))
                        <div class="mt-6">
                            {{ $threads->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">À propos</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Créée par</h3>
                            <div class="mt-1 flex items-center">
                                <div class="flex-shrink-0">
                                @if($community->creator && $community->creator->avatar)
                                        <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . $community->creator->avatar) }}" alt="{{ $community->creator->nom ?? 'Créateur' }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-sm font-bold text-white">
                                                {{ $community->creator ? substr($community->creator->prenom, 0, 1) : 'C' }}
                                            </div>
                                        @endif
                                    </div>
                                <div class="ml-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $community->creator->prenom }} {{ $community->creator->nom }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de création</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $community->created_at->format('d/m/Y') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Membres</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $membersCount }}</p>
                        </div>
                    </div>
                    
                    @auth
                        <div class="mt-6">
                            @if($isFollowing)
                                <form action="{{ route('communities.unfollow', $community) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-500">
                                        Quitter la communauté
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('communities.follow', $community) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Rejoindre la communauté
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="mt-6">
                            <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Se connecter pour rejoindre
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Posts populaires</h2>
                    <div class="space-y-4">
                        @forelse($posts->sortByDesc('like')->take(5) as $popularPost)
                            <a href="{{ route('posts.show', $popularPost) }}" class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $popularPost->titre }}</h3>
                                <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $popularPost->like }} likes</span>
                                    <span class="mx-1">&bull;</span>
                                    <span>{{ $popularPost->comments->count() }} commentaires</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">Aucun post populaire.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const postsTab = document.querySelector('a[href="#posts"]');
        const threadsTab = document.querySelector('a[href="#threads"]');
        const postsSection = document.getElementById('posts');
        const threadsSection = document.getElementById('threads');
        
        postsTab.addEventListener('click', function(e) {
            e.preventDefault();
            
            postsTab.classList.add('border-red-500', 'text-gray-900', 'dark:text-white');
            postsTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
            
            threadsTab.classList.remove('border-red-500', 'text-gray-900', 'dark:text-white');
            threadsTab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
            
            postsSection.style.display = 'block';
            threadsSection.style.display = 'none';
        });
        
        threadsTab.addEventListener('click', function(e) {
            e.preventDefault();
            
            threadsTab.classList.add('border-red-500', 'text-gray-900', 'dark:text-white');
            threadsTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
            
            postsTab.classList.remove('border-red-500', 'text-gray-900', 'dark:text-white');
            postsTab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300', 'dark:hover:border-gray-600');
            
            postsSection.style.display = 'none';
            threadsSection.style.display = 'block';
        });
    });
</script>