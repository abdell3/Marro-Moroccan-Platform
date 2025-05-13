@props(['user'])

@if($user->badges && $user->badges->count() > 0)
    <div class="mt-4">
        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Badges</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($user->badges as $badge)
                <div class="group relative">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        {{ $badge->name }}
                    </span>
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 absolute bottom-full left-0 mb-2 p-2 bg-gray-800 text-white text-xs rounded shadow-lg w-48 pointer-events-none z-10">
                        <p class="font-semibold mb-1">{{ $badge->name }}</p>
                        @if($badge->description)
                            <p class="mb-1">{{ $badge->description }}</p>
                        @endif
                        <p class="text-gray-300 text-xs">Critère: {{ $badge->criteria }}</p>
                        @if(isset($badge->pivot))
                            <p class="text-gray-300 text-xs mt-1">Obtenu le: {{ $badge->pivot->earned_at ? date('d/m/Y', strtotime($badge->pivot->earned_at)) : 'Date inconnue' }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif