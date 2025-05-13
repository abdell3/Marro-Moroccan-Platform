<x-layouts.app :title="$community->theme_name . ' | Espace Modérateur'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <a href="{{ route('moderateur.communities') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour aux communautés
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $community->theme_name }}</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Créée le {{ $community->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('moderateur.communities.edit', $community) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Modifier
                        </a>
                        <a href="{{ route('moderateur.community.stats', $community) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Statistiques
                        </a>
                        <a href="{{ route('moderateur.community.members', $community) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Membres
                        </a>
                    </div>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Description</h2>
                            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                {{ $community->description ?? 'Aucune description disponible.' }}
                            </div>

                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-3">Règles</h2>
                            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                {{ $community->rules ?? 'Aucune règle définie.' }}
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Informations</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Membres</h3>
                                    <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $community->followers()->count() }}
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Publications</h3>
                                    <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $community->posts()->count() }}
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Discussions</h3>
                                    <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $community->threads()->count() }}
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de création</h3>
                                    <p class="mt-1 text-gray-900 dark:text-white">
                                        {{ $community->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Publications récentes</h2>
                        
                        @php
                            // Utilisez la variable posts qui est passée depuis le contrôleur
                            // ou récupérez tous les posts de la communauté si non disponible
                            $recentPosts = $posts ?? $community->posts()->with('auteur')->orderBy('created_at', 'desc')->get();
                        @endphp
                        
                        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @if(count($recentPosts) > 0)
                                    @foreach($recentPosts as $post)
                                        <li>
                                            <a href="{{ route('moderateur.posts.show', $post->id) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <div class="px-4 py-4 sm:px-6">
                                                    <div class="flex items-center justify-between">
                                                        <p class="text-sm font-medium text-red-600 dark:text-red-400 truncate">
                                                            {{ $post->titre }}
                                                        </p>
                                                        <div class="ml-2 flex-shrink-0 flex">
                                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                                {{ $post->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 sm:flex sm:justify-between">
                                                        <div class="sm:flex flex-col">
                                                            <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                                {{ Str::limit($post->contenu, 100) }}
                                                            </p>
                                                            @if($post->media_path)
                                                                <div class="mt-2">
                                                                    @if(Str::contains($post->media_type, 'image'))
                                                                        <img src="{{ asset('storage/' . $post->media_path) }}" alt="Media" class="max-w-full h-auto rounded-lg" style="max-height: 150px;">
                                                                    @elseif(Str::contains($post->media_type, 'video'))
                                                                        <video src="{{ asset('storage/' . $post->media_path) }}" controls class="max-w-full h-auto rounded-lg" style="max-height: 150px;"></video>
                                                                    @else
                                                                        <a href="{{ asset('storage/' . $post->media_path) }}" class="text-red-600 dark:text-red-400 hover:underline">Fichier attaché</a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                                            <p>
                                                                Par {{ $post->auteur->nom ?? 'Auteur inconnu' }} {{ $post->auteur->prenom ?? '' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="px-4 py-5 sm:px-6 text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Aucune publication pour le moment.</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
