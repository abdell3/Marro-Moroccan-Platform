<x-layouts.app :title="$post->titre . ' | Marro'">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <div class="mb-4">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour aux posts
                        </a>
                    </div>

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . ($post->auteur->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $post->auteur->nom ?? 'Auteur' }}">
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->auteur->nom }} {{ $post->auteur->prenom }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                Posté dans <a href="{{ route('communities.show', $post->community) }}" class="text-red-600 hover:text-red-700">{{ $post->community->theme_name }}</a> • {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->titre }}</h1>

                    <div class="prose dark:prose-invert max-w-none mb-6">
                        <p>{{ $post->contenu }}</p>
                    </div>

                    @if($post->media_path)
                        <div class="mt-4 mb-6">
                            @if($post->typeContenu === 'image')
                                <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->titre }}" class="max-w-full h-auto rounded-lg">
                            @elseif($post->typeContenu === 'video')
                                <video controls class="max-w-full h-auto rounded-lg">
                                    <source src="{{ asset('storage/' . $post->media_path) }}" type="{{ $post->media_type }}">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                            @endif
                        </div>
                    @endif

                    @if($post->tags && $post->tags->count() > 0)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                    #{{ $tag->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            @php
                                $userVoteType = Auth::check() ? $post->getUserVoteType(Auth::id()) : null;
                            @endphp
                            @include('posts.partials.reddit-vote', ['post' => $post, 'userVoteType' => $userVoteType])

                            <a href="#comments" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>{{ $post->comments->count() }}</span>
                            </a>

                            @auth
                                @if(Auth::user()->savedPosts->contains($post->id))
                                    <form action="{{ route('posts.unsave', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                                            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                            </svg>
                                            <span>Sauvegardé</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('posts.save', $post) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                            <span>Sauvegarder</span>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Bouton Signaler -->
                                <a href="{{ route('reports.post.create', $post) }}" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21a2 2 0 012 2v7.5l-1 1-5.5-5.5M7 21h10a2 2 0 002-2v-4"></path>
                                    </svg>
                                    <span>Signaler</span>
                                </a>
                            @endauth
                        </div>

                        @can('update', $post)
                            <div class="flex space-x-2">
                                <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 bg-white text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Modifier
                                </a>

                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post?')">
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
                </div>

                @if($post->polls && $post->polls->count() > 0)
                    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Sondages</h2>
                        @foreach($post->polls as $poll)
                            @include('polls.partials.poll-card', ['poll' => $poll])
                        @endforeach
                    </div>
                @endif

                <div id="comments" class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Commentaires ({{ $post->comments->count() }})</h2>

                    @auth
                        <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="mb-3">
                                <textarea name="contenu" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Ajouter un commentaire..."></textarea>
                                @error('contenu')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Commenter
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 mb-6">
                            <p class="text-gray-700 dark:text-gray-300">Vous devez être <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700">connecté</a> pour commenter.</p>
                        </div>
                    @endauth

                    <div class="space-y-6">
                        @forelse($post->comments->where('parent_id', null) as $comment)
                            @include('comments.partials.comment-card', ['comment' => $comment])
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Aucun commentaire pour l'instant. Soyez le premier à commenter!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">À propos de la communauté</h2>
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-xl font-bold text-white">
                            {{ substr($post->community->theme_name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $post->community->theme_name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $post->community->followers->count() }} membres</div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $post->community->description }}</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('communities.show', $post->community) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Voir la communauté
                        </a>
                        @auth
                            @if(!Auth::user()->communities->contains($post->community->id))
                                <form action="{{ route('communities.follow', $post->community) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                        Rejoindre
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('communities.unfollow', $post->community) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-500">
                                        Quitter
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Posts similaires</h2>
                    <div class="space-y-4">
                        @forelse($post->community->posts->where('id', '!=', $post->id)->take(5) as $similarPost)
                            <a href="{{ route('posts.show', $similarPost) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $similarPost->titre }}</h3>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $similarPost->created_at->diffForHumans() }} • {{ $similarPost->comments->count() }} commentaires
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">Aucun post similaire trouvé.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/vote.js') }}"></script>
</x-layouts.app>