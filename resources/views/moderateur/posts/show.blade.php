<x-layouts.app :title="$post->titre . ' | Espace Modérateur'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                @if($post->community)
                <a href="{{ route('moderator.communities.show', $post->community_id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la communauté {{ $post->community->theme_name }}
                </a>
                @else
                <a href="{{ route('moderator.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour au tableau de bord
                </a>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $post->titre }}</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Publié le {{ $post->created_at->format('d/m/Y à H:i') }} par {{ $post->auteur->prenom }} {{ $post->auteur->nom }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <form action="{{ route('moderator.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <!-- Contenu du post -->
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        {!! nl2br(e($post->contenu)) !!}
                    </div>

                    @if($post->media_path)
                        <div class="mt-4">
                            @if(Str::contains($post->media_type, 'image'))
                                <img src="{{ asset('storage/' . $post->media_path) }}" alt="Media" class="max-w-full h-auto rounded-lg">
                            @elseif(Str::contains($post->media_type, 'video'))
                                <video src="{{ asset('storage/' . $post->media_path) }}" controls class="max-w-full h-auto rounded-lg"></video>
                            @else
                                <a href="{{ asset('storage/' . $post->media_path) }}" class="text-red-600 dark:text-red-400 hover:underline">Télécharger le fichier</a>
                            @endif
                        </div>
                    @endif

                    <!-- Informations supplémentaires -->
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex flex-wrap gap-2 items-center text-sm text-gray-600 dark:text-gray-400">
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                {{ $post->like }} likes
                            </span>
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                {{ $post->comments->count() }} commentaires
                            </span>
                            @if($post->community)
                                <span class="inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Communauté : <a href="{{ route('moderator.communities.show', $post->community_id) }}" class="text-red-600 dark:text-red-400 hover:underline">{{ $post->community->theme_name }}</a>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Commentaires -->
                    <div class="mt-8">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Commentaires ({{ count($comments) }})</h2>
                        
                        <div class="space-y-4">
                            @forelse($comments as $comment)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center">
                                        @if($comment->auteur && $comment->auteur->avatar)
                                            <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . $comment->auteur->avatar) }}" alt="{{ $comment->auteur->nom }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-sm font-bold text-white">
                                                {{ substr(($comment->auteur ? $comment->auteur->prenom : 'U'), 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $comment->auteur ? $comment->auteur->prenom . ' ' . $comment->auteur->nom : 'Utilisateur supprimé' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $comment->created_at->format('d/m/Y à H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                        {!! nl2br(e($comment->content)) !!}
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 text-center">Aucun commentaire pour le moment.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
