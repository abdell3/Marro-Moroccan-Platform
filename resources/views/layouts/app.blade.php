<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Marro') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    
    @stack('styles')
</head>
<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white dark:bg-gray-800 shadow">
            <nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <div class="w-8 h-8 mr-2">
                                <x-ui.logo />
                            </div>
                            <span class="font-bold text-xl text-gray-900 dark:text-white">Marro</span>
                        </a>
                    </div>

                    <div class="flex-1 max-w-xl mx-4 hidden md:block">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md leading-5 bg-white dark:bg-gray-900 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 dark:focus:placeholder-gray-600 focus:ring-1 focus:ring-purple-500 dark:focus:ring-blue-500 focus:border-purple-500 dark:focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" type="search" placeholder="Rechercher sur Marro">
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button class="md:hidden text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        @if(isset($isAuthenticated) ? $isAuthenticated : Auth::check())
                        <a href="{{ route('posts.create') }}" class="hidden md:flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Créer
                        </a>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800"></span>
                            </button>

                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                                <div class="py-1" role="menu" aria-orientation="vertical">
                                    <div class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700">
                                        <div class="font-bold">Notifications</div>
                                    </div>
                                    
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    Marie a aimé votre publication
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Il y a 5 minutes
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    Nouveau commentaire sur votre post
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Il y a 30 minutes
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <div class="px-4 py-2 text-sm text-center">
                                        <a href="#" class="text-purple-600 dark:text-blue-400 hover:underline">Voir toutes les notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('storage/' . ((isset($user) ? $user->avatar : (Auth::user() ? Auth::user()->avatar : '')) ?? 'avatars/default-avatar.png')) }}" alt="Avatar" class="h-full w-full object-cover">
                                </div>
                                <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-300">{{ (isset($user) ? $user->nom : (Auth::user() ? Auth::user()->nom : '')) ?? 'Utilisateur' }}</span>
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                                <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700">Créer un post</a>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Mon profil</a>
                                <a href="{{ route('profile.communities') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Mes communautés</a>
                                <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Paramètres</a>
                                <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 px-3 py-2 rounded-md">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md">
                                Inscription
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div class="py-6">
                @if (session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{ $slot }}
            </div>
        </main>
        
        <x-partials.footer class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Marro. Tous droits réservés.
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            Conditions d'utilisation
                        </a>
                        <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            Politique de confidentialité
                        </a>
                    </div>
                </div>
            </div>
        </x-partials.footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.from('header', {
                y: -50,
                opacity: 0,
                duration: 0.6,
                ease: 'power3.out',
                clearProps: 'all'
            });
            
            gsap.from('main', {
                opacity: 0,
                y: 20,
                duration: 0.8,
                delay: 0.2,
                ease: 'power2.out',
                clearProps: 'all'
            });
        });
    </script>

    @stack('scripts')
</body>
</html>