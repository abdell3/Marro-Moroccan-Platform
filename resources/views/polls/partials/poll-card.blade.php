<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4">
    <div class="flex justify-between items-start mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Sondage</h3>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            {{ $poll->created_at->diffForHumans() }}
        </div>
    </div>
    
    @php
        $results = app(App\Services\Interfaces\PollServiceInterface::class)->getPollResults($poll->id);
        $userVote = Auth::check() ? app(App\Services\Interfaces\PollServiceInterface::class)->getUserVote($poll->id, Auth::id()) : null;
    @endphp
    
    @if($userVote !== null)
        <div class="space-y-3 mb-4">
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
                            {{ $data['percentage'] }}%
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="flex justify-between items-center">
            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                Vous avez voté: 
                @if($poll->typeVote === 'etoiles')
                    {{ $userVote }} étoile{{ $userVote > 1 ? 's' : '' }}
                @elseif($poll->typeVote === 'pouces')
                    {{ $userVote == 1 ? 'Pouce en haut 👍' : 'Pouce en bas 👎' }}
                @else
                    Option {{ $userVote }}
                @endif
            </div>
            
            <button type="button" onclick="toggleVoteForm('poll-{{ $poll->id }}')" class="text-sm text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                Changer mon vote
            </button>
        </div>
        
        <form action="{{ route('polls.vote', $poll) }}" method="POST" id="poll-{{ $poll->id }}-form" class="mt-4" style="display: none;">
            @csrf
            <div class="space-y-4">
                @if($poll->typeVote === 'etoiles')
                    <div class="flex items-center justify-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="submit" name="vote_value" value="{{ $i }}" class="text-2xl focus:outline-none hover:text-yellow-400 transition {{ $userVote == $i ? 'text-yellow-400' : '' }}">
                                &#9733;
                            </button>
                        @endfor
                    </div>
                @elseif($poll->typeVote === 'pouces')
                    <div class="flex items-center justify-center space-x-8">
                        <button type="submit" name="vote_value" value="1" class="text-3xl focus:outline-none hover:text-green-500 transition {{ $userVote == 1 ? 'text-green-500' : '' }}">
                            👍
                        </button>
                        <button type="submit" name="vote_value" value="0" class="text-3xl focus:outline-none hover:text-red-500 transition {{ $userVote == 0 ? 'text-red-500' : '' }}">
                            👎
                        </button>
                    </div>
                @else
                    <div class="space-y-2">
                        @for($i = 0; $i <= 5; $i++)
                            <div class="flex items-center">
                                <input type="radio" id="poll-{{ $poll->id }}-option-{{ $i }}" name="vote_value" value="{{ $i }}" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" {{ $userVote == $i ? 'checked' : '' }}>
                                <label for="poll-{{ $poll->id }}-option-{{ $i }}" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                    Option {{ $i }}
                                </label>
                            </div>
                        @endfor
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Voter
                        </button>
                    </div>
                @endif
            </div>
        </form>
        
        <script>
            function toggleVoteForm(pollId) {
                const form = document.getElementById(pollId + '-form');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        </script>
    @else
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
                                <input type="radio" id="poll-{{ $poll->id }}-option-{{ $i }}" name="vote_value" value="{{ $i }}" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <label for="poll-{{ $poll->id }}-option-{{ $i }}" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                    Option {{ $i }}
                                </label>
                            </div>
                        @endfor
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Voter
                        </button>
                    </div>
                @endif
            </div>
        </form>
        
        @guest
            <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700">Connectez-vous</a> pour voter
            </div>
        @endguest
    @endif
    
    <div class="mt-4 text-right">
        <a href="{{ route('polls.results', $poll) }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
            Voir les résultats ({{ $results['total_votes'] }} vote{{ $results['total_votes'] > 1 ? 's' : '' }})
        </a>
    </div>
</div>