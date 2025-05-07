<x-app>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-red-600 to-orange-500 rounded-lg shadow mb-6 p-8 text-white">
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-4">
                    Bienvenue sur Marro
                </h1>
                <p class="text-lg sm:text-xl mb-6">
                    Rejoignez la communauté pour discuter, partager et découvrir avec d'autres personnes partageant vos intérêts.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-red-600 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-600 focus:ring-white">
                        Créer un compte
                    </a>
                    
                </div>
            </div>

            <!-- Pourquoi rejoindre Marro section -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Pourquoi rejoindre Marro ?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Communautés diverses</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Rejoignez des communautés spécifiques à vos centres d'intérêt ou créez la vôtre.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Discussions enrichissantes</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Participez à des échanges constructifs et enrichissants avec d'autres membres.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Système de badges</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Gagnez des badges en participant activement et en contribuant à la communauté.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Environnement sécurisé</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Une modération active pour assurer des échanges respectueux et constructifs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <!-- Communautés populaires -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Communautés populaires</h2>
                
                <div class="space-y-4">
                    <p class="text-gray-500">Aucune communauté disponible pour le moment.</p>
                </div>
            </div>
            
            <!-- Activité récente -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Activité récente</h2>
                
                <div class="space-y-4">
                    <p class="text-gray-500">Aucune activité récente pour le moment.</p>
                </div>
            </div>
            
            <!-- À propos de Marro -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-3">À propos de Marro</h2>
                <p class="text-gray-600 mb-4">
                    Marro est une plateforme de discussion communautaire où vous pouvez partager vos idées, découvrir des contenus intéressants et participer à des débats sur divers sujets.
                </p>
                <div class="flex justify-between text-sm">
                    <div class="text-center">
                        <div class="font-bold text-lg">0</div>
                        <div class="text-gray-500">Posts</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-lg">0</div>
                        <div class="text-gray-500">Communautés</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-lg">2025</div>
                        <div class="text-gray-500">Depuis</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>