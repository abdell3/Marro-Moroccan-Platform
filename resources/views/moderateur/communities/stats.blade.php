<x-layouts.app :title="$community->theme_name . ' - Statistiques | Modérateur'">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <a href="{{ route('moderator.communities') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 mr-3">
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
                    <a href="{{ route('moderator.community.members', $community) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
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
                        {{ $community->followers->count() }}
                    </dd>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Total des posts
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $community->posts->count() }}
                    </dd>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Nouveaux membres (30j)
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $membersPerDay->sum('total') }}
                    </dd>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                        Nouveaux posts (30j)
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $postsPerDay->sum('total') }}
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
                        <div class="mb-8">
                            <h4 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Nouveaux posts
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-5 gap-2">
                                @php
                                    $maxPostCount = $postsPerDay->max('total') > 0 ? $postsPerDay->max('total') : 1;
                                @endphp
                                @foreach($postsPerDay as $dayData)
                                    @php
                                        $height = ($dayData->total / $maxPostCount) * 100;
                                        $date = new \Carbon\Carbon($dayData->date);
                                    @endphp
                                    <div class="text-center">
                                        <div class="flex items-end justify-center h-32">
                                            <div class="bg-red-500 dark:bg-red-600 w-5 rounded-t" style="height: {{ $height }}%;"></div>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $date->format('d/m') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Nouveaux membres
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-5 gap-2">
                                @php
                                    $maxMemberCount = $membersPerDay->max('total') > 0 ? $membersPerDay->max('total') : 1;
                                @endphp
                                @foreach($membersPerDay as $dayData)
                                    @php
                                        $height = ($dayData->total / $maxMemberCount) * 100;
                                        $date = new \Carbon\Carbon($dayData->date);
                                    @endphp
                                    <div class="text-center">
                                        <div class="flex items-end justify-center h-32">
                                            <div class="bg-blue-500 dark:bg-blue-600 w-5 rounded-t" style="height: {{ $height }}%;"></div>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $date->format('d/m') }}
                                        </div>
                                    </div>
                                @endforeach
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