<x-layouts.app title="Tableau de bord | Marro">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Left Sidebar -->
            <div class="md:col-span-3">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-purple-100 dark:bg-purple-900 mb-4">
                                <img src="{{ Auth::user()->avatar ?? asset('avatars/default.png') }}" alt="Profile" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ Auth::user()->prenom ?? '' }} {{ Auth::user()->nom ?? 'Utilisateur' }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">@{{ Auth::user()->email ?? 'utilisateur' }}</p>
                            
                            <div class="flex space-x-2 mb-4">
                                @if(isset(Auth::user()->badge_id) && Auth::user()->badge_id)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Badge Welcome
                                </span>
                                @endif
                            </div>
                            
                            <a href="#" class="w-full bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out text-center">
                                Éditer le profil
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Mes communautés</h3>
                        
                        <div class="space-y-3">
                            <a href="#" class="flex items-center p-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white mr-3">T</div>
                                <span class="text-gray-900 dark:text-white">Technologie</span>
                            </a>
                            
                            <a href="#" class="flex items-center p-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white mr-3">P</div>
                                <span class="text-gray-900 dark:text-white">Programmation</span>
                            </a>
                            
                            <a href="#" class="flex items-center p-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white mr-3">V</div>
                                <span class="text-gray-900 dark:text-white">Voyages</span>
                            </a>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="#" class="text-purple-600 dark:text-blue-400 hover:underline text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Créer une communauté
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="md:col-span-6">
                <!-- Create Post -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <form action="#" method="POST" class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full overflow-hidden">
                                        <img src="{{ Auth::user()->avatar ?? asset('avatars/default.png') }}" alt="Profile" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden focus-within:border-purple-500 dark:focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-purple-500 dark:focus-within:ring-blue-500">
                                        <label for="post-content" class="sr-only">Quoi de neuf?</label>
                                        <textarea id="post-content" name="content" rows="3" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" placeholder="Quoi de neuf?"></textarea>
                                        
                                        <div class="py-2 px-3 border-t border-gray-200 dark:border-gray-700">
                                            <div class="flex justify-between items-center">
                                                <div class="flex space-x-5">
                                                    <button type="button" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-blue-500">
                                                    Publier
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Feed -->
                <div class="space-y-6">
                    <!-- Post 1 -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg post-card">
                        <div class="p-6">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white">T</div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        <a href="#" class="hover:underline">Technologie</a>
                                        <span class="text-gray-500 dark:text-gray-400 font-normal"> • Publié par </span>
                                        <a href="#" class="hover:underline">Marie Dupont</a>
                                        <span class="text-gray-500 dark:text-gray-400 font-normal"> • Il y a 2 heures</span>
                                    </p>
                                    <h3 class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                        Les dernières tendances en intelligence artificielle
                                    </h3>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                <p>L'intelligence artificielle continue d'évoluer à un rythme impressionnant. Voici quelques-unes des tendances les plus récentes qui façonnent le domaine :</p>
                                <p>- Les modèles de langage de plus en plus sophistiqués</p>
                                <p>- L'IA générative qui crée des images et du contenu</p>
                                <p>- Les applications d'IA dans le domaine médical</p>
                                <p>- L'utilisation de l'IA pour résoudre des problèmes environnementaux</p>
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <div class="flex space-x-4">
                                    <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <span>128</span>
                                    </button>
                                    <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <span>12</span>
                                    </button>
                                    <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        <span>45 commentaires</span>
                                    </button>
                                </div>
                                <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                    <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    <span>Sauvegarder</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Post 2 -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg post-card">
                        <div class="p-6">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white">V</div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        <a href="#" class="hover:underline">Voyages</a>
                                        <span class="text-gray-500 dark:text-gray-400 font-normal"> • Publié par </span>
                                        <a href="#" class="hover:underline">Thomas Martin</a>
                                        <span class="text-gray-500 dark:text-gray-400 font-normal"> • Il y a 5 heures</span>
                                    </p>
                                    <h3 class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                        Les 5 destinations incontournables pour 2025
                                    </h3>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 space-y-4">
                                <p>Après avoir exploré de nombreux pays au cours de l'année dernière, voici mes recommandations pour les meilleures destinations de voyage en 2025 :</p>
                                
                                <div class="aspect-w-16 aspect-h-9 mt-4 rounded-lg overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Destination" class="object-cover">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <div class="flex space-x-4">
                                    <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <span>83</span>
                                    </button>
                                    <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <span>5</span>
                                    </button>
                                    <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        <span>27 commentaires</span>
                                    </button>
                                </div>
                                <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                    <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    <span>Sauvegarder</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar -->
            <div class="md:col-span-3">
                <!-- Trending -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">En tendance</h3>
                        
                        <div class="space-y-4">
                            <a href="#" class="block hover:bg-gray-50 dark:hover:bg-gray-700 -m-2 p-2 rounded-lg transition duration-150 ease-in-out">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Technologie • En tendance</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">L'impact de l'intelligence artificielle sur nos vies quotidiennes</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">254 discussions</p>
                            </a>
                            
                            <a href="#" class="block hover:bg-gray-50 dark:hover:bg-gray-700 -m-2 p-2 rounded-lg transition duration-150 ease-in-out">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Science • En tendance</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">Nouvelle découverte en astrophysique bouleverse notre compréhension</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">178 discussions</p>
                            </a>
                            
                            <a href="#" class="block hover:bg-gray-50 dark:hover:bg-gray-700 -m-2 p-2 rounded-lg transition duration-150 ease-in-out">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Cuisine • En tendance</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">Les meilleures recettes végétariennes pour débutants</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">132 discussions</p>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Communities to join -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Communautés suggérées</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center text-white">C</div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Cuisine</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">5.2K membres</p>
                                </div>
                                <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Rejoindre
                                </button>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center text-white">P</div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Photographie</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">3.8K membres</p>
                                </div>
                                <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Rejoindre
                                </button>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">L</div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Littérature</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">2.4K membres</p>
                                </div>
                                <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Rejoindre
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="#" class="text-purple-600 dark:text-blue-400 hover:underline text-sm">
                                Découvrir plus de communautés
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animate post cards on page load
            gsap.from('.post-card', {
                opacity: 0,
                y: 20,
                stagger: 0.2,
                duration: 0.8,
                ease: 'power3.out',
                clearProps: 'all'
            });
        });
    </script>
    @endpush
</x-layouts.app>