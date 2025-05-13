<x-layouts.app :title="$community->theme_name . ' | Marro'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $community->theme_name }}</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Créée le {{ $community->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.communities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Retour à la liste
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Informations de la communauté
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $community->theme_name }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $community->description }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre de membres</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $community->members_count }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre de posts</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $community->posts_count }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de création</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $community->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </dl>
                        
                        <div class="mt-6 flex space-x-3">
                            <a href="{{ route('admin.communities.edit', $community->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Modifier
                            </a>
                            
                            <a href="{{ route('communities.show', $community->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Visiter
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden lg:col-span-2">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Statistiques
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-indigo-100 dark:bg-indigo-900 rounded-lg p-4">
                                <div class="text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ $stats['posts_today'] }}</div>
                                <div class="text-sm text-indigo-700 dark:text-indigo-300">Posts aujourd'hui</div>
                            </div>
                            
                            <div class="bg-green-100 dark:bg-green-900 rounded-lg p-4">
                                <div class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $stats['posts_week'] }}</div>
                                <div class="text-sm text-green-700 dark:text-green-300">Posts cette semaine</div>
                            </div>
                            
                            <div class="bg-yellow-100 dark:bg-yellow-900 rounded-lg p-4">
                                <div class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ $stats['posts_month'] }}</div>
                                <div class="text-sm text-yellow-700 dark:text-yellow-300">Posts ce mois-ci</div>
                            </div>
                            
                            <div class="bg-red-100 dark:bg-red-900 rounded-lg p-4">
                                <div class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $stats['reports_count'] }}</div>
                                <div class="text-sm text-red-700 dark:text-red-300">Signalements</div>
                            </div>
                            
                            <div class="bg-purple-100 dark:bg-purple-900 rounded-lg p-4 md:col-span-2">
                                <div class="text-xl font-bold text-purple-900 dark:text-purple-100">{{ $community->theme_name }}</div>
                                <div class="text-sm text-purple-700 dark:text-purple-300 mt-1">{{ Str::limit($community->description, 100) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Membres récents
                        </h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                            {{ $community->members_count }} au total
                        </span>
                    </div>
                    <div class="p-0">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentMembers as $member)
                            <li class="px-4 py-3 flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $member->avatar ? asset('storage/' . $member->avatar) : asset('images/default-avatar.png') }}" alt="{{ $member->prenom }}">
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->prenom }} {{ $member->nom }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $member->email }}</div>
                                </div>
                                <div class="ml-auto flex-shrink-0">
                                    <a href="{{ route('admin.users.show', $member->id) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        Voir
                                    </a>
                                </div>
                            </li>
                            @empty
                            <li class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Aucun membre dans cette communauté.
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Posts récents
                        </h3>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                            {{ $community->posts_count }} au total
                        </span>
                    </div>
                    <div class="p-0">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentPosts as $post)
                            <li class="px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <div class="truncate">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $post->titre }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Par {{ $post->auteur->prenom }} {{ $post->auteur->nom }} · {{ $post->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-shrink-0">
                                        <a href="{{ route('posts.show', $post->id) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            Voir
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Aucun post dans cette communauté.
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mt-6">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                        Modérateurs de la communauté
                    </h3>
                </div>
                <div class="p-4">
                    @if($community->moderators->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($community->moderators as $moderator)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $moderator->avatar ? asset('storage/' . $moderator->avatar) : asset('images/default-avatar.png') }}" alt="{{ $moderator->prenom }}">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $moderator->prenom }} {{ $moderator->nom }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $moderator->email }}</div>
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-end">
                                    <a href="{{ route('admin.users.show', $moderator->id) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        Voir le profil
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Aucun modérateur assigné à cette communauté.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.communities.edit', $community->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Assigner des modérateurs
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>