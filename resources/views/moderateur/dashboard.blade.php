<x-layouts.app :title="'Dashboard Modérateur | Marro'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Modérateur</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Bienvenue sur votre espace de modération</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('moderateur.communities.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Créer une nouvelle communauté
                    </a>
                </div>
            </div>

            <!-- Cartes de statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Communautés
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $totalCommunities }}
                        </dd>
                        <div class="mt-2">
                            <a href="{{ route('moderateur.communities') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Voir toutes →
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Total de membres
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $totalMembers }}
                        </dd>
                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Dans toutes vos communautés
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Total de posts
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $totalPosts }}
                        </dd>
                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Dans toutes vos communautés
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Signalements en attente
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $pendingReportsCount }}
                        </dd>
                        <div class="mt-2">
                            <a href="{{ route('moderateur.reports.index') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Traiter les signalements →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Vos communautés -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Vos communautés
                            </h3>
                            <a href="{{ route('moderateur.communities') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Voir tout
                            </a>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($communities as $community)
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center overflow-hidden">
                                                @if($community->icon_url)
                                                    <img src="{{ $community->icon_url }}" alt="{{ $community->theme_name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="bg-gray-300 dark:bg-gray-600 w-full h-full flex items-center justify-center text-white font-bold">
                                                        {{ substr($community->theme_name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('moderateur.communities.show', $community) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-red-600 dark:hover:text-red-400">
                                                    {{ $community->theme_name }}
                                                </a>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $community->followers_count }} membres • {{ $community->posts_count }} posts
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('moderateur.community.members', $community) }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                                Membres
                                            </a>
                                            <a href="{{ route('moderateur.community.stats', $community) }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                                Statistiques
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-5 sm:px-6 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Vous n'avez pas encore créé de communauté</p>
                                    <a href="{{ route('moderateur.communities.create') }}" class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Créer une communauté
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Derniers signalements -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Derniers signalements
                            </h3>
                            <a href="{{ route('moderateur.reports.index') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Voir tout
                            </a>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentReports as $report)
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="flex items-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    {{ $report->report_type_name }}
                                                </span>
                                                <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                Signalé par {{ $report->prenom }} {{ $report->nom }}
                                            </div>
                                        </div>
                                        <a href="{{ route('moderateur.reports.show', $report->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Traiter
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-5 sm:px-6 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucun signalement en attente</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
