<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Marro - Explorez, Partagez, Discutez</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>
<body class="antialiased font-sans">
    <!-- Hero Section -->
    <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-purple-900 via-purple-800 to-blue-900">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div id="particles-js" class="absolute inset-0"></div>
            <div class="floating-circles">
                @for ($i = 0; $i < 10; $i++)
                    <div class="floating-circle"></div>
                @endfor
            </div>
        </div>
        
        <!-- Navigation -->
        <header class="relative z-10">
            <nav class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10">
                            <x-ui.logo />
                        </div>
                        <span class="ml-3 text-2xl font-bold text-white">Marro</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center space-x-8">
                            <a href="#features" class="text-gray-200 hover:text-white transition-colors duration-300">Fonctionnalités</a>
                            <a href="#communities" class="text-gray-200 hover:text-white transition-colors duration-300">Communautés</a>
                            <a href="#about" class="text-gray-200 hover:text-white transition-colors duration-300">À propos</a>
                            
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors duration-300">Tableau de bord</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-200 hover:text-white transition-colors duration-300">Connexion</a>
                                    <a href="{{ route('register') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors duration-300">Inscription</a>
                                @endauth
                            @endif
                        </div>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="block md:hidden">
                        <button id="mobile-menu-button" class="text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="hidden md:hidden mt-4 border-t border-gray-700 pt-4">
                    <div class="flex flex-col space-y-4">
                        <a href="#features" class="text-gray-200 hover:text-white transition-colors duration-300">Fonctionnalités</a>
                        <a href="#communities" class="text-gray-200 hover:text-white transition-colors duration-300">Communautés</a>
                        <a href="#about" class="text-gray-200 hover:text-white transition-colors duration-300">À propos</a>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors duration-300 inline-block text-center">Tableau de bord</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-200 hover:text-white transition-colors duration-300">Connexion</a>
                                <a href="{{ route('register') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors duration-300 inline-block text-center">Inscription</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>
        </header>
        
        <!-- Hero Content -->
        <main class="relative z-10 container mx-auto px-6 py-12 flex flex-col items-center">
            <h1 class="text-white text-4xl md:text-6xl font-bold text-center leading-tight mt-8 reveal-text">
                Explorez, partagez et <br class="hidden md:block"><span class="text-gradient">connectez-vous</span> sur Marro
            </h1>
            <p class="text-gray-200 text-xl md:text-2xl text-center mt-6 max-w-2xl fade-in">
                La plateforme communautaire où vous pouvez découvrir, créer et participer à des discussions passionnantes.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 fade-in-up">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-purple-600 hover:bg-gray-100 rounded-lg font-medium text-lg transition-colors duration-300 text-center transform hover:scale-105">
                    Commencer maintenant
                </a>
                <a href="#features" class="px-8 py-4 border border-white text-white hover:bg-white hover:bg-opacity-10 rounded-lg font-medium text-lg transition-colors duration-300 text-center">
                    En savoir plus
                </a>
            </div>
            
            <!-- Mockup -->
            <div class="mt-16 w-full max-w-4xl mx-auto fade-in-up">
                <div class="relative">
                    <div class="bg-gray-800 rounded-lg shadow-2xl overflow-hidden border border-gray-700">
                        <div class="flex items-center justify-start px-4 py-2 bg-gray-900">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="ml-4 text-gray-400 text-sm">Marro - Explorez le web social</div>
                        </div>
                        <div class="p-4">
                            <div class="flex">
                                <div class="w-1/4 pr-4">
                                    <div class="bg-gray-700 rounded-lg p-3 mb-3">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-purple-500 rounded-full"></div>
                                            <div>
                                                <div class="h-3 w-24 bg-gray-600 rounded"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-700 rounded-lg p-3">
                                        <div class="h-3 w-full bg-gray-600 rounded mb-2"></div>
                                        <div class="h-3 w-3/4 bg-gray-600 rounded mb-2"></div>
                                        <div class="h-3 w-5/6 bg-gray-600 rounded"></div>
                                    </div>
                                </div>
                                <div class="w-3/4">
                                    <div class="bg-gray-700 rounded-lg p-4 mb-4">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-blue-500 rounded-full"></div>
                                            <div class="ml-3">
                                                <div class="h-3 w-32 bg-gray-600 rounded mb-1"></div>
                                                <div class="h-2 w-24 bg-gray-600 rounded"></div>
                                            </div>
                                        </div>
                                        <div class="h-4 w-full bg-gray-600 rounded mb-2"></div>
                                        <div class="h-4 w-full bg-gray-600 rounded mb-2"></div>
                                        <div class="h-4 w-3/4 bg-gray-600 rounded mb-4"></div>
                                        <div class="flex justify-between">
                                            <div class="flex space-x-2">
                                                <div class="h-8 w-8 bg-gray-600 rounded"></div>
                                                <div class="h-8 w-8 bg-gray-600 rounded"></div>
                                                <div class="h-8 w-8 bg-gray-600 rounded"></div>
                                            </div>
                                            <div class="h-8 w-20 bg-purple-600 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-700 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-green-500 rounded-full"></div>
                                            <div class="ml-3">
                                                <div class="h-3 w-36 bg-gray-600 rounded mb-1"></div>
                                                <div class="h-2 w-24 bg-gray-600 rounded"></div>
                                            </div>
                                        </div>
                                        <div class="h-4 w-full bg-gray-600 rounded mb-2"></div>
                                        <div class="h-4 w-2/3 bg-gray-600 rounded mb-4"></div>
                                        <div class="flex justify-between">
                                            <div class="flex space-x-2">
                                                <div class="h-8 w-8 bg-gray-600 rounded"></div>
                                                <div class="h-8 w-8 bg-gray-600 rounded"></div>
                                                <div class="h-8 w-8 bg-gray-600 rounded"></div>
                                            </div>
                                            <div class="h-8 w-20 bg-purple-600 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-gray-800 rounded-full border border-gray-700"></div>
                </div>
            </div>
        </main>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10">
            <a href="#features" class="flex flex-col items-center text-white opacity-70 hover:opacity-100 transition-opacity duration-300">
                <span class="mb-2 text-sm">Découvrir</span>
                <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">
                    <div class="w-1 h-2 bg-white rounded-full mt-2 animate-bounce-slow"></div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 text-gray-800">Ce que Marro vous offre</h2>
            
            <div class="grid md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow-lg p-8 feature-card">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Communautés personnalisées</h3>
                    <p class="text-gray-600">Créez ou rejoignez des communautés autour de vos passions, centres d'intérêt ou projets.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow-lg p-8 feature-card">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Discussions enrichissantes</h3>
                    <p class="text-gray-600">Participez à des conversations, débats et échanges d'idées avec des personnes partageant vos intérêts.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow-lg p-8 feature-card">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Contenu varié</h3>
                    <p class="text-gray-600">Partagez du texte, des images, des liens et des sondages. Votez pour mettre en avant le contenu de qualité.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Communities Section -->
    <section id="communities" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 text-gray-800">Communautés populaires</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Community 1 -->
                <div class="bg-gradient-to-r from-purple-600 to-blue-500 rounded-lg shadow-lg overflow-hidden group community-card">
                    <div class="h-32 bg-purple-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Technologie</h3>
                        <p class="text-gray-600 mb-4">Discussions sur les dernières technologies, gadgets et innovations.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>3.2K membres</span>
                            <span class="mx-2">•</span>
                            <span>56 discussions actives</span>
                        </div>
                    </div>
                </div>
                
                <!-- Community 2 -->
                <div class="bg-gradient-to-r from-green-600 to-teal-500 rounded-lg shadow-lg overflow-hidden group community-card">
                    <div class="h-32 bg-green-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Voyage</h3>
                        <p class="text-gray-600 mb-4">Partagez vos expériences de voyage, conseils et destinations favorites.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>2.5K membres</span>
                            <span class="mx-2">•</span>
                            <span>42 discussions actives</span>
                        </div>
                    </div>
                </div>
                
                <!-- Community 3 -->
                <div class="bg-gradient-to-r from-red-600 to-orange-500 rounded-lg shadow-lg overflow-hidden group community-card">
                    <div class="h-32 bg-red-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Livres & Littérature</h3>
                        <p class="text-gray-600 mb-4">Discussions sur les livres, recommandations et critiques littéraires.</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>1.8K membres</span>
                            <span class="mx-2">•</span>
                            <span>37 discussions actives</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg font-medium text-lg transition-transform duration-300 transform hover:scale-105 hover:shadow-lg">
                    Explorer toutes les communautés
                </a>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-gray-800">À propos de Marro</h2>
                <p class="text-xl text-gray-600 mb-10">Marro est une plateforme communautaire inspirée par Reddit, conçue pour créer des espaces de discussion et de partage autour de thématiques variées. Notre objectif est de faciliter les échanges d'idées et de connaissances dans un environnement respectueux et enrichissant.</p>
                
                <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg font-medium text-lg transition-transform duration-300 transform hover:scale-105">
                        Rejoindre la communauté
                    </a>
                    <a href="#" class="px-8 py-4 border border-gray-400 text-gray-700 hover:bg-gray-200 rounded-lg font-medium text-lg transition-colors duration-300">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-8 md:mb-0">
                    <div class="flex items-center">
                        <div class="w-10 h-10">
                            <x-ui.logo />
                        </div>
                        <span class="ml-3 text-xl font-bold">Marro</span>
                    </div>
                    <p class="mt-4 max-w-md text-gray-400">Explorez, partagez et connectez-vous avec des personnes partageant les mêmes intérêts dans une communauté dynamique.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Accueil</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-white transition-colors duration-300">Fonctionnalités</a></li>
                            <li><a href="#communities" class="text-gray-400 hover:text-white transition-colors duration-300">Communautés</a></li>
                            <li><a href="#about" class="text-gray-400 hover:text-white transition-colors duration-300">À propos</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Légal</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Conditions d'utilisation</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Politique de confidentialité</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Cookies</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Marro. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Particle.js for background -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Initialize particle.js
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.6
                            }
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });
            
            // Initialize GSAP animations
            gsap.registerPlugin(ScrollTrigger);
            
            // Floating circles animation
            document.querySelectorAll('.floating-circle').forEach((circle, index) => {
                const size = gsap.utils.random(5, 20);
                const speed = gsap.utils.random(20, 40);
                const xPos = gsap.utils.random(0, 100);
                
                circle.style.width = `${size}px`;
                circle.style.height = `${size}px`;
                circle.style.backgroundColor = `rgba(255, 255, 255, ${gsap.utils.random(0.1, 0.3)})`;
                circle.style.borderRadius = '50%';
                circle.style.position = 'absolute';
                circle.style.top = '0';
                circle.style.left = `${xPos}%`;
                
                gsap.to(circle, {
                    y: '100vh',
                    duration: speed,
                    repeat: -1,
                    ease: 'none',
                    delay: index * 0.2
                });
            });
            
            // Animate feature cards on scroll
            gsap.utils.toArray('.feature-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top bottom-=100',
                        toggleActions: 'play none none none'
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    delay: i * 0.2,
                    ease: 'power3.out'
                });
            });
            
            // Animate community cards on scroll
            gsap.utils.toArray('.community-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top bottom-=100',
                        toggleActions: 'play none none none'
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    delay: i * 0.2,
                    ease: 'power3.out'
                });
            });
            
            // Text reveal animation
            const textElements = document.querySelectorAll('.reveal-text');
            textElements.forEach(element => {
                const text = element.textContent;
                element.textContent = '';
                
                for (let i = 0; i < text.length; i++) {
                    const span = document.createElement('span');
                    span.textContent = text[i] === ' ' ? ' ' : text[i];
                    span.style.opacity = '0';
                    span.style.display = 'inline-block';
                    span.style.transform = 'translateY(20px)';
                    element.appendChild(span);
                    
                    gsap.to(span, {
                        opacity: 1,
                        y: 0,
                        duration: 0.1,
                        delay: 0.3 + (i * 0.03),
                        ease: 'power3.out'
                    });
                }
            });
            
            // Fade in animations
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach(element => {
                gsap.fromTo(element, 
                    { opacity: 0 }, 
                    { opacity: 1, duration: 1, delay: 0.8, ease: 'power2.out' }
                );
            });
            
            // Fade in up animations
            const fadeInUpElements = document.querySelectorAll('.fade-in-up');
            fadeInUpElements.forEach((element, index) => {
                gsap.fromTo(element, 
                    { opacity: 0, y: 30 }, 
                    { opacity: 1, y: 0, duration: 1, delay: 1 + (index * 0.2), ease: 'power3.out' }
                );
            });
        });
    </script>
    
    <style>
        /* Text gradient */
        .text-gradient {
            background: linear-gradient(90deg, #8A2BE2, #4169E1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }
        
        /* Floating circles container */
        .floating-circles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        /* Custom animation for the scroll indicator */
        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
    </style>
</body>
</html>