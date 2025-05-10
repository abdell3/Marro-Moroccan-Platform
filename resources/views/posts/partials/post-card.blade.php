<div class="mb-6 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 hover:shadow-lg transition-all duration-200 ease-in-out post-card" style="opacity: 1; visibility: visible;">
    <div class="px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . ($post->auteur->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $post->auteur->nom ?? 'Auteur' }}">
            </div>
            <div class="ml-3">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->auteur->nom }} {{ $post->auteur->prenom }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Posté dans <a href="{{ route('communities.show', $post->community) }}" class="text-red-600 hover:text-red-700">{{ $post->community->theme_name }}</a> • {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 py-3">
        <a href="{{ route('posts.show', $post) }}" class="block group cursor-pointer">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">{{ $post->titre }}</h2>
            
            @if(strlen($post->contenu) > 300)
                <p class="text-gray-700 dark:text-gray-300 mb-2">{{ Str::limit($post->contenu, 300) }}</p>
                <span class="text-red-600 hover:text-red-700 text-sm inline-block border-b border-red-600 pb-0.5">Lire la suite</span>
            @else
                <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $post->contenu }}</p>
            @endif
            
            @if($post->polls && $post->polls->count() > 0)
                <div class="mt-3 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Sondage :</h3>
                    @foreach($post->polls as $poll)
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <a href="{{ route('posts.show', $post) }}" class="text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                                {{ $post->contenu ?? 'Voir le sondage et voter' }} <span class="text-xs">&rarr;</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </a>

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

    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-between">
        <div class="flex space-x-4">
            @php
                $userVoteType = Auth::check() ? $post->getUserVoteType(Auth::id()) : null;
            @endphp
            @include('posts.partials.reddit-vote', ['post' => $post, 'userVoteType' => $userVoteType])
            <a href="{{ route('posts.show', $post) }}#comments" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>{{ $post->comments->count() }}</span>
            </a>

            <button onclick="sharePost('{{ route('posts.show', $post) }}', '{{ $post->titre }}')" class="flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                <span>Partager</span>
            </button>
        </div>

        @auth
            <div class="save-post-container" data-post-id="{{ $post->id }}">
                @if(Auth::user()->savedPosts->contains($post->id))
                    <button type="button" onclick="unsavePost({{ $post->id }})" class="save-button saved flex items-center text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                        <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                        </svg>
                        <span>Sauvegardé</span>
                    </button>
                @else
                    <button type="button" onclick="savePost({{ $post->id }})" class="save-button unsaved flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        <span>Sauvegarder</span>
                    </button>
                @endif
            </div>
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
            navigator.clipboard.writeText(url).then(() => {
                alert('Lien copié dans le presse-papier!');
            }).catch(err => {
                console.error('Erreur lors de la copie:', err);
            });
        }
    }
    
    function savePost(postId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/posts/${postId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.querySelector(`.save-post-container[data-post-id="${postId}"]`);
                if (container) {
                    container.innerHTML = `
                        <button type="button" onclick="unsavePost(${postId})" class="save-button saved flex items-center text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                            </svg>
                            <span>Sauvegardé</span>
                        </button>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la sauvegarde:', error);
        });
    }
    
    function unsavePost(postId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/posts/${postId}/unsave`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-HTTP-Method-Override': 'DELETE'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.querySelector(`.save-post-container[data-post-id="${postId}"]`);
                if (container) {
                    container.innerHTML = `
                        <button type="button" onclick="savePost(${postId})" class="save-button unsaved flex items-center text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            <span>Sauvegarder</span>
                        </button>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la suppression de la sauvegarde:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const voteForms = document.querySelectorAll('form[action*="upvote"], form[action*="downvote"]');
        
        voteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const url = e.submitter ? e.submitter.formAction : form.action;
                
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const voteCount = form.querySelector('span');
                        if (voteCount) voteCount.textContent = data.likes;
                        
                        const upvoteBtn = form.querySelector('button:first-of-type');
                        const downvoteBtn = form.querySelector('button:last-of-type');
                        const upvoteIcon = upvoteBtn.querySelector('svg');
                        const downvoteIcon = downvoteBtn.querySelector('svg');
                        
                        upvoteBtn.className = upvoteBtn.className.replace(/text-orange-[45]00/g, 'text-gray-500 hover:text-orange-500');
                        downvoteBtn.className = downvoteBtn.className.replace(/text-blue-[45]00/g, 'text-gray-500 hover:text-blue-500');
                        upvoteIcon.setAttribute('fill', 'none');
                        downvoteIcon.setAttribute('fill', 'none');
                        
                        if (data.vote_type === 'upvote') {
                            upvoteBtn.className = upvoteBtn.className.replace(/text-gray-500 hover:text-orange-500/, 'text-orange-500');
                            upvoteIcon.setAttribute('fill', 'currentColor');
                        } else if (data.vote_type === 'downvote') {
                            downvoteBtn.className = downvoteBtn.className.replace(/text-gray-500 hover:text-blue-500/, 'text-blue-500');
                            downvoteIcon.setAttribute('fill', 'currentColor');
                        }
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du vote:', error);
                });
            });
        });
    });
</script>
@endonce