<x-layouts.app title="Tableau de bord | Marro">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Tableau de bord</h2>
            <p class="mt-1 text-sm text-gray-500">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- User Stats -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-base font-medium text-gray-900 mb-4">Vos statistiques</h3>
                    
                    <dl class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded-md">
                            <dt class="text-sm font-medium text-gray-500">Posts</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">0</dd>
                        </div>
                        
                        <div class="bg-white p-3 rounded-md">
                            <dt class="text-sm font-medium text-gray-500">Commentaires</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">0</dd>
                        </div>
                        
                        <div class="bg-white p-3 rounded-md">
                            <dt class="text-sm font-medium text-gray-500">Badge</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ auth()->user()->badge->name ?? 'Aucun' }}
                            </dd>
                        </div>
                        
                        <div class="bg-white p-3 rounded-md">
                            <dt class="text-sm font-medium text-gray-500">Inscription</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">
                                {{ auth()->user()->created_at->format('d/m/Y') }}
                            </dd>
                        </div>
                    </dl>
                    
                    <div class="mt-4">
                        <a href="{{ route('profile.show') }}" class="text-sm font-medium text-red-600 hover:text-red-500">
                            Voir votre profil →
                        </a>
                    </div>
                </div>
                
                <!-- Your Posts -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-base font-medium text-gray-900 mb-4">Vos posts récents</h3>
                    
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">Vous n'avez pas encore créé de posts.</p>
                        
                        <div>
                            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Créer un post
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Your Communities -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-base font-medium text-gray-900 mb-4">Vos communautés</h3>
                    
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">Vous n'avez pas encore rejoint de communautés.</p>
                        
                        <div>
                            <a href="{{ route('communities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                                Découvrir des communautés
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Activity Feed -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-base font-medium text-gray-900 mb-4">Activité récente</h3>
                    
                    <div class="overflow-hidden">
                        <p class="text-sm text-gray-500">Aucune activité récente pour le moment.</p>
                    </div>
                </div>
                
                <!-- Notifications -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-medium text-gray-900">Notifications</h3>
                        <a href="#" class="text-sm font-medium text-red-600 hover:text-red-500">
                            Tout marquer comme lu
                        </a>
                    </div>
                    
                    <div class="overflow-hidden">
                        <p class="text-sm text-gray-500">Aucune notification pour le moment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>