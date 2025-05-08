<div class="mb-6 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 fade-in card-animate">
    <!-- En-tête du post -->
    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-8 w-8 rounded-full" src="{{ asset($post->auteur->avatar ?? 'avatars/default.png') }}" alt="{{ $post->auteur->nom ?? 'Auteur' }}">
            </div>
            <div class="ml-3">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->auteur->nom }} {{ $post->auteur->prenom }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Posté dans <a href="{{ route('communities.show', $post->community) }}" class="text-red-600 hover:text-red-700">{{ $post->community->theme_name }}</a> • {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu du post -->
    <div class="px-4 py-3">
        <a href="{{ route('posts.show', $post) }}" class="block">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $post->titre }}</h2>
            
            @if(strlen($post->contenu) > 300)
                <p class="text-gray-700 dark:text-gray-300 mb-2">{{ Str::limit($post->contenu, 300) }}</p>
                <a href="{{ route('posts.show', $post) }}" class="text-red-600 hover:text-red-700 text-sm">Lire la suite</a>
            @else
                <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $post->contenu }}</p>
            @endif
        </a>

        <!-- Média -->
        @if($post->media_path)
            <div class="mt-3 mb-2">
                @if($post->typeContenu === 'image')
                    <a href="{{ route('posts.show', $post) }}" class="block">
                        <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->titre }}" class="max-w-full h-auto rounded-lg">
                    </a>
                @elseif($post->typeContenu === 'video')
                    <video controls class="max-w-full h-auto rounded-lg">
                        <source src="{{ asset('storage/' . $post->media_path) }}" type="{{ $post->media_type }}">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                @endif
            </div>
        @endif

        <!-- Tags -->
        @if($post->tags && $post->tags->count() > 0)
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag) }}" class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        #{{ $tag->title }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-between">
        <div class="flex space-x-4">
            <!-- Like button -->
            <form action="{{ route('posts.like', $post) }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                    </svg>
                    <span>{{ $post->like }}</span>
                </button>
            </form>

            <!-- Comments -->
            <a href="{{ route('posts.show', $post) }}#comments" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>{{ $post->comments->count() }}</span>
            </a>

            <!-- Share -->
            <button onclick="sharePost('{{ route('posts.show', $post) }}', '{{ $post->titre }}')" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                <span>Partager</span>
            </button>
        </div>

        <!-- Save/unsave button -->
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
        @endauth
    </div>
</div>

@once
<script>
    function sharePost(url, title) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).then(() => {
                console.log('Post partagé avec succès!');
            }).catch(err => {
                console.error('Erreur lors du partage:', err);
            });
        } else {
            // Fallback
            navigator.clipboard.writeText(url).then(() => {
                alert('Lien copié dans le presse-papier!');
            }).catch(err => {
                console.error('Erreur lors de la copie:', err);
            });
        }
    }
</script>
@endonce