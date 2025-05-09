<x-layouts.app title="Sondage | Marro">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="mb-4">
                    <a href="{{ route('posts.show', $poll->post) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour au post
                    </a>
                </div>

                <div class="mb-6">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Sondage</h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Créé par {{ $poll->auteur->prenom }} {{ $poll->auteur->nom }} • {{ $poll->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Résultats</h2>
                    
                    @if($results['total_votes'] > 0)
                        <div class="space-y-4">
                            @foreach($results['results'] as $value => $data)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            @if($poll->typeVote === 'etoiles')
                                                {{ $value }} étoile{{ $value > 1 ? 's' : '' }}
                                            @elseif($poll->typeVote === 'pouces')
                                                {{ $value == 1 ? 'Pouce en haut' : 'Pouce en bas' }}
                                            @else
                                                Option {{ $value }}
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $data['count'] }} vote{{ $data['count'] > 1 ? 's' : '' }} ({{ $data['percentage'] }}%)
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                            Total: {{ $results['total_votes'] }} vote{{ $results['total_votes'] > 1 ? 's' : '' }}
                        </div>
                        
                        @auth
                            @php
                                $userVote = collect($poll->voters)->firstWhere('id', Auth::id());
                                $userVoteValue = $userVote ? $userVote->pivot->vote_value : null;
                            @endphp
                            
                            @if($userVoteValue !== null)
                                <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-md p-4">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            Vous avez voté: 
                                            @if($poll->typeVote === 'etoiles')
                                                {{ $userVoteValue }} étoile{{ $userVoteValue > 1 ? 's' : '' }}
                                            @elseif($poll->typeVote === 'pouces')
                                                {{ $userVoteValue == 1 ? 'Pouce en haut 👍' : 'Pouce en bas 👎' }}
                                            @else
                                                Option {{ $userVoteValue }}
                                            @endif
                                        </p>
                                        
                                        <button type="button" onclick="toggleVoteForm()" class="text-sm text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                                            Changer mon vote
                                        </button>
                                    </div>
                                    
                                    <form action="{{ route('polls.vote', $poll) }}" method="POST" id="vote-form" class="mt-4" style="display: none;">
                                        @csrf
                                        <div class="space-y-4">
                                            @if($poll->typeVote === 'etoiles')
                                                <div class="flex items-center justify-center space-x-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="submit" name="vote_value" value="{{ $i }}" class="text-2xl focus:outline-none hover:text-yellow-400 transition {{ $userVoteValue == $i ? 'text-yellow-400' : '' }}">
                                                            &#9733;
                                                        </button>
                                                    @endfor
                                                </div>
                                            @elseif($poll->typeVote === 'pouces')
                                                <div class="flex items-center justify-center space-x-8">
                                                    <button type="submit" name="vote_value" value="1" class="text-3xl focus:outline-none hover:text-green-500 transition {{ $userVoteValue == 1 ? 'text-green-500' : '' }}">
                                                        👍
                                                    </button>
                                                    <button type="submit" name="vote_value" value="0" class="text-3xl focus:outline-none hover:text-red-500 transition {{ $userVoteValue == 0 ? 'text-red-500' : '' }}">
                                                        👎
                                                    </button>
                                                </div>
                                            @else
                                                <div class="space-y-2">
                                                    @for($i = 0; $i <= 5; $i++)
                                                        <div class="flex items-center">
                                                            <input type="radio" id="option-{{ $i }}" name="vote_value" value="{{ $i }}" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" {{ $userVoteValue == $i ? 'checked' : '' }}>
                                                            <label for="option-{{ $i }}" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                                                Option {{ $i }}
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                                
                                                <div class="flex justify-end">
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        Voter
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                                
                                <script>
                                    function toggleVoteForm() {
                                        const form = document.getElementById('vote-form');
                                        form.style.display = form.style.display === 'none' ? 'block' : 'none';
                                    }
                                </script>
                            @endif
                        @endauth
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500 dark:text-gray-400">Aucun vote pour l'instant. Soyez le premier à voter!</p>
                        </div>
                    @endif
                </div>

                @auth
                    @if(!isset($userVote) || !$userVote)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Votez</h2>
                            
                            <form action="{{ route('polls.vote', $poll) }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    @if($poll->typeVote === 'etoiles')
                                        <div class="flex items-center justify-center space-x-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="submit" name="vote_value" value="{{ $i }}" class="text-2xl focus:outline-none hover:text-yellow-400 transition">
                                                    &#9733;
                                                </button>
                                            @endfor
                                        </div>
                                    @elseif($poll->typeVote === 'pouces')
                                        <div class="flex items-center justify-center space-x-8">
                                            <button type="submit" name="vote_value" value="1" class="text-3xl focus:outline-none hover:text-green-500 transition">
                                                👍
                                            </button>
                                            <button type="submit" name="vote_value" value="0" class="text-3xl focus:outline-none hover:text-red-500 transition">
                                                👎
                                            </button>
                                        </div>
                                    @else
                                        <div class="space-y-2">
                                            @for($i = 0; $i <= 5; $i++)
                                                <div class="flex items-center">
                                                    <input type="radio" id="option-{{ $i }}" name="vote_value" value="{{ $i }}" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                                    <label for="option-{{ $i }}" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                                        Option {{ $i }}
                                                    </label>
                                                </div>
                                            @endfor
                                        </div>
                                        
                                        <div class="flex justify-end">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Voter
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 text-center">
                        <p class="text-gray-700 dark:text-gray-300 mb-4">Vous devez être connecté pour voter</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Se connecter
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.app>