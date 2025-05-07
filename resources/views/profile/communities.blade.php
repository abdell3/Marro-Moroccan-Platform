<x-layouts.app title="Mes communautés | Marro">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-medium text-gray-900">Mes communautés</h2>
                    <p class="mt-1 text-sm text-gray-500">Les communautés que vous suivez</p>
                </div>
                
                <a href="{{ route('communities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Découvrir des communautés
                </a>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                @if(count($communities) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($communities as $community)
                            <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden">
                                <div class="h-24 bg-gradient-to-r from-red-500 to-purple-500 relative">
                                    @if($community->banner)
                                        <img src="{{ asset($community->banner) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                                    @endif
                                    
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2">
                                        <div class="bg-white rounded-full h-16 w-16 border-4 border-white shadow-sm flex items-center justify-center overflow-hidden">
                                            @if($community->avatar)
                                                <img src="{{ asset($community->avatar) }}" alt="{{ $community->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="bg-red-100 h-full w-full flex items-center justify-center">
                                                    <span class="text-red-600 font-bold text-xl">{{ substr($community->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="px-4 pt-10 pb-4 text-center">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <a href="{{ route('communities.show', $community) }}" class="hover:text-red-600">
                                            {{ $community->name }}
                                        </a>
                                    </h3>
                                    
                                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $community->description }}</p>
                                    
                                    <div class="mt-4 flex justify-between items-center px-2">
                                        <span class="text-xs text-gray-500">{{ $community->members_count }} membres</span>
                                        <span class="text-xs text-gray-500">{{ $community->posts_count }} posts</span>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between">
                                        <a href="{{ route('communities.show', $community) }}" class="text-sm font-medium text-red-600 hover:text-red-500">
                                            Voir
                                        </a>
                                        
                                        @if($community->user_id === auth()->id())
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Créateur</span>
                                        @else
                                            <form action="{{ route('communities.unfollow', $community) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-gray-600 hover:text-red-500">
                                                    Ne plus suivre
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $communities->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune communauté suivie</h3>
                        <p class="mt-1 text-sm text-gray-500">Rejoignez des communautés pour voir leur contenu dans votre fil.</p>
                        <div class="mt-6">
                            <a href="{{ route('communities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                Découvrir des communautés
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        @if(count($ownedCommunities) > 0)
            <div class="mt-8 bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-medium text-gray-900">Communautés que vous gérez</h2>
                        <p class="mt-1 text-sm text-gray-500">Les communautés dont vous êtes l'administrateur</p>
                    </div>
                    
                    <a href="{{ route('communities.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Créer une communauté
                    </a>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($ownedCommunities as $community)
                            <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden border-2 border-red-200">
                                <div class="h-24 bg-gradient-to-r from-red-500 to-purple-500 relative">
                                    @if($community->banner)
                                        <img src="{{ asset($community->banner) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                                    @endif
                                    
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2">
                                        <div class="bg-white rounded-full h-16 w-16 border-4 border-white shadow-sm flex items-center justify-center overflow-hidden">
                                            @if($community->avatar)
                                                <img src="{{ asset($community->avatar) }}" alt="{{ $community->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="bg-red-100 h-full w-full flex items-center justify-center">
                                                    <span class="text-red-600 font-bold text-xl">{{ substr($community->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="px-4 pt-10 pb-4 text-center">
                                    <div class="flex justify-center">
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Administrateur</span>
                                    </div>
                                    
                                    <h3 class="mt-2 text-lg font-medium text-gray-900">
                                        <a href="{{ route('communities.show', $community) }}" class="hover:text-red-600">
                                            {{ $community->name }}
                                        </a>
                                    </h3>
                                    
                                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $community->description }}</p>
                                    
                                    <div class="mt-4 flex justify-between items-center px-2">
                                        <span class="text-xs text-gray-500">{{ $community->members_count }} membres</span>
                                        <span class="text-xs text-gray-500">{{ $community->posts_count }} posts</span>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between">
                                        <a href="{{ route('communities.show', $community) }}" class="text-sm font-medium text-red-600 hover:text-red-500">
                                            Voir
                                        </a>
                                        
                                        <a href="{{ route('communities.edit', $community) }}" class="text-sm font-medium text-gray-600 hover:text-red-500">
                                            Gérer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>