<header class="bg-white shadow">
    <div class="mx-auto container px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img class="h-8 w-auto" src="{{ asset('images/logo.svg') }}" alt="Marro">
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden sm:ml-6 sm:flex items-center">
                    <div class="relative">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input 
                                    type="search" 
                                    name="q" 
                                    id="search" 
                                    class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6" 
                                    placeholder="Rechercher" 
                                    value="{{ request('q') }}"
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                @auth
                    <a href="{{ route('communities.index') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">Communautés</a>
                    
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <img class="h-8 w-8 rounded-full" src="{{ asset(auth()->user()->avatar ?? 'avatars/default.png') }}" alt="{{ auth()->user()->nom }}">
                            </button>
                        </div>

                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-10"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="display: none;"
                        >
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tableau de bord</a>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="{{ route('profile.saved-posts') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Posts sauvegardés</a>
                            
                            @if(auth()->user()->hasAnyRole(['Admin', 'Moderateur']))
                                <div class="border-t border-gray-100 my-1"></div>
                                @if(auth()->user()->hasRole('Admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Administration</a>
                                @endif
                                @if(auth()->user()->hasRole('Moderateur'))
                                    <a href="{{ route('moderator.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modération</a>
                                @endif
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('communities.index') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">Communautés</a>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Inscription
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" x-show="!open" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" x-show="open" style="display: none;" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" x-data="{ open: false }" x-show="open" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('communities.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Communautés</a>
            <form action="{{ route('search') }}" method="GET" class="px-3 py-2">
                <input type="search" name="q" placeholder="Rechercher" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </form>
        </div>

        <!-- Mobile profile links -->
        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ asset(auth()->user()->avatar ?? 'avatars/default.png') }}" alt="{{ auth()->user()->nom }}">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Tableau de bord</a>
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Profil</a>
                    <a href="{{ route('profile.saved-posts') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Posts sauvegardés</a>
                    
                    @if(auth()->user()->hasAnyRole(['Admin', 'Moderateur']))
                        @if(auth()->user()->hasRole('Admin'))
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Administration</a>
                        @endif
                        @if(auth()->user()->hasRole('Moderateur'))
                            <a href="{{ route('moderator.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Modération</a>
                        @endif
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="space-y-1 px-3">
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Connexion</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-red-600">Inscription</a>
                </div>
            </div>
        @endauth
    </div>
</header>