<x-layouts.app title="Mon Profil | Marro">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-medium text-gray-900">Mon Profil</h2>
                    <p class="mt-1 text-sm text-gray-500">Informations personnelles et paramètres du compte</p>
                </div>
                <x-ui.button variant="primary" size="sm" tag="a" href="{{ route('profile.edit') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Modifier le profil
                </x-ui.button>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Informations du profil -->
                    <div class="col-span-1">
                        <div class="flex flex-col items-center">
                            <div class="bg-gray-200 rounded-full w-32 h-32 flex items-center justify-center overflow-hidden border-4 border-white shadow mb-4">
                                <img src="{{ auth()->user()->avatar ?? asset('avatars/default.png') }}" alt="Avatar de {{ auth()->user()->nom }}" class="h-full w-full object-cover">
                            </div>
                            
                            <h3 class="text-lg font-medium text-gray-900">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h3>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                            
                            <div class="mt-4">
                                <x-ui.button variant="outline" size="sm" tag="a" href="{{ route('profile.avatar') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Changer l'avatar
                                </x-ui.button>
                            </div>
                        </div>
                        
                        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Badge</h4>
                            <div class="flex items-center justify-center">
                                @if(auth()->user()->badge)
                                    <div class="bg-{{ auth()->user()->badge->color }}-100 text-{{ auth()->user()->badge->color }}-800 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                        {{ auth()->user()->badge->name }}
                                    </div>
                                @else
                                    <div class="text-gray-500 text-sm">Aucun badge pour le moment</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Membre depuis</h4>
                            <div class="text-center text-gray-600">
                                {{ auth()->user()->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Statistiques -->
                    <div class="col-span-2">
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-base font-medium text-gray-900 mb-4">Statistiques</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-md shadow-sm">
                                    <p class="text-sm font-medium text-gray-500">Posts</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ auth()->user()->posts()->count() }}</p>
                                </div>
                                
                                <div class="bg-white p-4 rounded-md shadow-sm">
                                    <p class="text-sm font-medium text-gray-500">Commentaires</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ auth()->user()->comments()->count() }}</p>
                                </div>
                                
                                <div class="bg-white p-4 rounded-md shadow-sm">
                                    <p class="text-sm font-medium text-gray-500">Communautés</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ auth()->user()->communities()->count() }}</p>
                                </div>
                                
                                <div class="bg-white p-4 rounded-md shadow-sm">
                                    <p class="text-sm font-medium text-gray-500">Posts sauvegardés</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ auth()->user()->savedPosts()->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dernière activité -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-base font-medium text-gray-900">Dernière activité</h3>
                            </div>
                            
                            @if(count(auth()->user()->recentActivity()) > 0)
                                <div class="space-y-4">
                                    @foreach(auth()->user()->recentActivity() as $activity)
                                        <div class="flex items-start space-x-3 bg-white p-3 rounded-lg shadow-sm">
                                            <div class="flex-shrink-0">
                                                @if($activity->type === 'post')
                                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </div>
                                                @elseif($activity->type === 'comment')
                                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $activity->description }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-500 text-sm">Aucune activité récente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>