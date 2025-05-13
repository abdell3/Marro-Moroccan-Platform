<x-layouts.app :title="$community->theme_name . ' - Statistiques | Modérateur'">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <a href="{{ route('moderateur.communities') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 mr-3">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 mr-2 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($community->theme_name, 0, 1) }}
                        </div>
                        {{ $community->theme_name }} - Statistiques
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Consultez les statistiques et l'activité de votre communauté
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <a href="{{ route('communities.show', $community) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Voir la communauté
                    </a>
                    <a href="{{ route('moderateur.community.members', $community) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Membres
                    </a>
                </div>
            </div>
        </div>

        <!-- Résumé des statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Total des membres
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $membersCount }}
                    </dd>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Total des posts
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $postsCount }}
                    </dd>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Nouveaux membres (30j)
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $newMembersCount }}
                    </dd>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Nouveaux posts (30j)
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $recentPostsCount }}
                    </dd>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Activité des membres -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Activité récente
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                            Activité des 30 derniers jours
                        </p>
                    </div>
                    <div class="p-6">
                        <!-- Informations d'activité simplifiées -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">
                                    Résumé de l'activité (30 derniers jours)
                                </h4>
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                    <span class="font-medium">{{ $recentPostsCount }}</span> nouveaux posts
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                    <span class="font-medium">{{ $newMembersCount }}</span> nouveaux membres
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">
                                    Taux d'engagement
                                </h4>
                            </div>
                            @php
                                $engagementRate = $membersCount > 0 ? ($recentPostsCount / $membersCount) * 100 : 0;
                            @endphp
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Taux d'engagement</span>
                                    <span class="text-sm font-medium">{{ number_format($engagementRate, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-300 dark:bg-gray-600 rounded-full h-2.5 mt-2">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ min($engagementRate, 100) }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    Basé sur le nombre de posts par rapport au nombre de membres
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membres les plus actifs -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Membres les plus actifs
                        </h3>
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($topMembers as $member)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . ($member->avatar ?? 'avatars/default-avatar.png')) }}" alt="{{ $member->nom }}">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $member->prenom }} {{ $member->nom }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $member->posts_count }} posts
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-5 text-center text-sm text-gray-500 dark:text-gray-400">
                                Aucun membre actif trouvé
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>