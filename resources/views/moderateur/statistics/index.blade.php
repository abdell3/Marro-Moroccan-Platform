<x-layouts.app :title="'Statistiques de Modération | Marro'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Statistiques de modération</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Consultez les statistiques détaillées de vos communautés et des activités de modération
                </p>
            </div>

            <!-- Filtres de période -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
                <form action="{{ route('moderator.statistics') }}" method="GET" class="flex flex-wrap items-center gap-4">
                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Période</label>
                        <select id="period" name="period" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                            <option value="7" {{ request('period') == 7 ? 'selected' : '' }}>7 derniers jours</option>
                            <option value="30" {{ request('period') == 30 || request('period') == null ? 'selected' : '' }}>30 derniers jours</option>
                            <option value="90" {{ request('period') == 90 ? 'selected' : '' }}>90 derniers jours</option>
                            <option value="365" {{ request('period') == 365 ? 'selected' : '' }}>12 derniers mois</option>
                        </select>
                    </div>
                    <div>
                        <label for="community" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Communauté</label>
                        <select id="community" name="community_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                            <option value="">Toutes les communautés</option>
                            @foreach($communities as $community)
                                <option value="{{ $community->id }}" {{ request('community_id') == $community->id ? 'selected' : '' }}>
                                    {{ $community->theme_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-shrink-0 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistiques globales -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vue d'ensemble</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Total des nouveaux membres -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-md bg-blue-100 dark:bg-blue-900">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nouveaux membres</h3>
                                <div class="text-xl font-semibold text-gray-900 dark:text-white">{{ $newMembersCount }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Nouveaux posts -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-md bg-green-100 dark:bg-green-900">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nouveaux posts</h3>
                                <div class="text-xl font-semibold text-gray-900 dark:text-white">{{ $newPostsCount }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Signalements reçus -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-md bg-yellow-100 dark:bg-yellow-900">
                                <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Signalements reçus</h3>
                                <div class="text-xl font-semibold text-gray-900 dark:text-white">{{ $reportsReceivedCount }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Signalements traités -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-md bg-red-100 dark:bg-red-900">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Signalements traités</h3>
                                <div class="text-xl font-semibold text-gray-900 dark:text-white">{{ $reportsHandledCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Statistiques des communautés -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Statistiques par communauté</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Communauté
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Membres
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Posts
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Croissance
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($communityStats as $stat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ substr($stat->theme_name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $stat->theme_name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $stat->members_count }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                +{{ $stat->new_members_count }} nouveaux
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $stat->posts_count }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                +{{ $stat->new_posts_count }} nouveaux
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($stat->growth_rate > 0)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    +{{ number_format($stat->growth_rate, 1) }}%
                                                </span>
                                            @elseif($stat->growth_rate < 0)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    {{ number_format($stat->growth_rate, 1) }}%
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    0%
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($communityStats) === 0)
                        <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Aucune donnée disponible pour la période sélectionnée.
                        </div>
                    @endif
                </div>

                <!-- Statistiques des signalements -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Statistiques des signalements</h2>
                    </div>
                    <div class="px-6 py-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Par type de contenu</h3>
                        <div class="space-y-4">
                            <!-- Posts signalés -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Posts</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByContentType['post'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-red-500 rounded-full" style="width: {{ $reportsByContentTypePercentage['post'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByContentTypePercentage['post'] ?? 0 }}%</span>
                                </div>
                            </div>

                            <!-- Commentaires signalés -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Commentaires</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByContentType['comment'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-red-500 rounded-full" style="width: {{ $reportsByContentTypePercentage['comment'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByContentTypePercentage['comment'] ?? 0 }}%</span>
                                </div>
                            </div>

                            <!-- Communautés signalées -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Communautés</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByContentType['community'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-red-500 rounded-full" style="width: {{ $reportsByContentTypePercentage['community'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByContentTypePercentage['community'] ?? 0 }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Par résolution</h3>
                        <div class="space-y-4">
                            <!-- Ignorés -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-block w-3 h-3 rounded-full bg-gray-400 mr-2"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Ignorés</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByResolution['ignored'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-gray-400 rounded-full" style="width: {{ $reportsByResolutionPercentage['ignored'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByResolutionPercentage['ignored'] ?? 0 }}%</span>
                                </div>
                            </div>

                            <!-- Contenu supprimé -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-block w-3 h-3 rounded-full bg-yellow-400 mr-2"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Contenu supprimé</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByResolution['content_removed'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-yellow-400 rounded-full" style="width: {{ $reportsByResolutionPercentage['content_removed'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByResolutionPercentage['content_removed'] ?? 0 }}%</span>
                                </div>
                            </div>

                            <!-- Utilisateur banni -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-block w-3 h-3 rounded-full bg-red-400 mr-2"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Utilisateur banni</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByResolution['user_banned'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-red-400 rounded-full" style="width: {{ $reportsByResolutionPercentage['user_banned'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByResolutionPercentage['user_banned'] ?? 0 }}%</span>
                                </div>
                            </div>

                            <!-- Autre -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-block w-3 h-3 rounded-full bg-purple-400 mr-2"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Autre</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reportsByResolution['other'] ?? 0 }}</div>
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full ml-3">
                                        <div class="h-2 bg-purple-400 rounded-full" style="width: {{ $reportsByResolutionPercentage['other'] ?? 0 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $reportsByResolutionPercentage['other'] ?? 0 }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des derniers signalements -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Derniers signalements traités</h2>
                    <a href="{{ route('moderator.reports.index') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                        Voir tous les signalements
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Contenu
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Action prise
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Traité par
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentHandledReports as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $report->content_type == 'post' ? 'blue' : ($report->content_type == 'comment' ? 'green' : 'purple') }}-100 text-{{ $report->content_type == 'post' ? 'blue' : ($report->content_type == 'comment' ? 'green' : 'purple') }}-800 dark:bg-{{ $report->content_type == 'post' ? 'blue' : ($report->content_type == 'comment' ? 'green' : 'purple') }}-900 dark:text-{{ $report->content_type == 'post' ? 'blue' : ($report->content_type == 'comment' ? 'green' : 'purple') }}-200">
                                            {{ $report->report_type_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ Str::limit($report->content_excerpt, 30) }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $report->content_type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($report->created_at)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $report->action_taken == 'ignored' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}
                                            {{ $report->action_taken == 'content_removed' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                            {{ $report->action_taken == 'user_banned' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                            {{ $report->action_taken == 'other' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : '' }}
                                        ">
                                            {{ $report->action_taken == 'ignored' ? 'Ignoré' : '' }}
                                            {{ $report->action_taken == 'content_removed' ? 'Contenu supprimé' : '' }}
                                            {{ $report->action_taken == 'user_banned' ? 'Utilisateur banni' : '' }}
                                            {{ $report->action_taken == 'other' ? 'Autre' : '' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $report->handler_prenom }} {{ $report->handler_nom }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($recentHandledReports) === 0)
                    <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Aucun signalement traité pour la période sélectionnée.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
