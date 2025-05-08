<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4" id="comment-{{ $comment->id }}">
    <!-- En-tête du commentaire -->
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <img class="h-9 w-9 rounded-full" src="{{ asset($comment->auteur->avatar ?? 'avatars/default.png') }}" alt="{{ $comment->auteur->nom ?? 'Utilisateur' }}">
        </div>
        <div class="ml-3 flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->auteur->prenom }} {{ $comment->auteur->nom }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                
                <!-- Actions (modifier/supprimer) -->
                @can('update', $comment)
                    <div class="flex space-x-2">
                        <a href="{{ route('comments.edit', $comment) }}" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
            
            <!-- Contenu du commentaire -->
            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                <p>{{ $comment->contenu }}</p>
            </div>
            
            <!-- Actions (répondre) -->
            <div class="mt-3 flex items-center space-x-4">
                <button onclick="toggleReplyForm('{{ $comment->id }}')" class="text-xs text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                    Répondre
                </button>
            </div>
            
            <!-- Formulaire de réponse (caché par défaut) -->
            @auth
                <div id="reply-form-{{ $comment->id }}" class="mt-3" style="display: none;">
                    <form action="{{ route('comments.reply', $comment) }}" method="POST">
                        @csrf
                        <div class="flex">
                            <div class="flex-shrink-0 mr-2">
                                <img class="h-8 w-8 rounded-full" src="{{ asset(Auth::user()->avatar ?? 'avatars/default.png') }}" alt="{{ Auth::user()->nom }}">
                            </div>
                            <div class="flex-1">
                                <textarea name="contenu" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Écrire une réponse..."></textarea>
                                <div class="mt-2 flex justify-end space-x-2">
                                    <button type="button" onclick="toggleReplyForm('{{ $comment->id }}')" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                        Annuler
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Répondre
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth
            
            <!-- Réponses -->
            @if(isset($comment->replies) && $comment->replies->count() > 0)
                <div class="mt-4 ml-6 space-y-4">
                    @foreach($comment->replies as $reply)
                        <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full" src="{{ asset($reply->auteur->avatar ?? 'avatars/default.png') }}" alt="{{ $reply->auteur->nom ?? 'Utilisateur' }}">
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $reply->auteur->prenom }} {{ $reply->auteur->nom }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <!-- Actions (modifier/supprimer) -->
                                        @can('update', $reply)
                                            <div class="flex space-x-2">
                                                <a href="{{ route('comments.edit', $reply) }}" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                    
                                    <!-- Contenu de la réponse -->
                                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                        <p>{{ $reply->contenu }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@once
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form.style.display === 'none') {
            form.style.display = 'block';
            form.querySelector('textarea').focus();
        } else {
            form.style.display = 'none';
        }
    }
</script>
@endonce