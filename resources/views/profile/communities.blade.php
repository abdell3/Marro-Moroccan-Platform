<x-layouts.app title="Mes communautés | Marro">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mes communautés</h1>
        <p class="text-gray-600 dark:text-gray-400">Gérez les communautés que vous avez rejointes</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Communautés rejointes -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Communautés rejointes</h2>
                    
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
                                
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-600">
                                    <form action="{{ route('communities.unfollow', $community) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-500">
                                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Quitter
                                        </button>
                                    </form>
                                </div>
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

        <!-- Barre latérale -->
        <div>
            <!-- Communautés populaires -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Communautés populaires</h2>
                    <div class="space-y-4">
                        @foreach(App\Models\Community::withCount('followers')->orderBy('followers_count', 'desc')->take(5)->get() as $popularCommunity)
                            @if(!Auth::user()->communities->contains($popularCommunity->id))
                                <a href="{{ route('communities.show', $popularCommunity) }}" class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-lg font-bold text-white">
                                        {{ substr($popularCommunity->theme_name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $popularCommunity->theme_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $popularCommunity->followers_count }} membres</div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('communities.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Voir toutes les communautés
                        </a>
                    </div>
                </div>
            </div>

            <!-- Créer une communauté -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Créer une communauté</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Vous avez une passion ou un intérêt à partager? Créez votre propre communauté!</p>
                    <a href="{{ route('communities.create') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Créer une communauté
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>