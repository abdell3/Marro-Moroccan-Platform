<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Marro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <!-- Page specific styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex justify-between items-center">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <div class="w-8 h-8 mr-2">
                                <x-ui.logo />
                            </div>
                            <span class="font-bold text-xl text-gray-900 dark:text-white">Marro</span>
                        </a>
                    </div>

                    <!-- Search -->
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

                    <!-- Right side nav items -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile search button -->
                        <button class="md:hidden text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        @auth
                            <!-- User menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                        <img src="{{ Auth::user()->avatar ?? asset('avatars/default.png') }}" alt="Avatar" class="h-full w-full object-cover">
                                    </div>
                                    <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->nom ?? 'Utilisateur' }}</span>
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- User dropdown -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Mon profil</a>
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
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                            <a href="{{ route('register') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Inscription
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 shadow">
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
        </footer>
    </div>

    <!-- Alpine.js for interactive elements -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animate header elements
            gsap.from('header', {
                y: -50,
                opacity: 0,
                duration: 0.6,
                ease: 'power3.out',
                clearProps: 'all'
            });
            
            // Content animation
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