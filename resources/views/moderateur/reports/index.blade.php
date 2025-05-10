<x-layouts.app :title="'Modération des signalements | Marro'">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modération des signalements</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gérez les signalements de contenu inapproprié</p>
        </div>

        <!-- Navigation des signalements -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <a href="{{ route('moderator.reports.index') }}" class="px-6 py-3 text-center text-sm font-medium {{ request()->routeIs('moderator.reports.index') ? 'text-red-600 border-b-2 border-red-600 dark:text-red-500 dark:border-red-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Tous les signalements
                </a>
                <a href="{{ route('moderator.reports.posts') }}" class="px-6 py-3 text-center text-sm font-medium {{ request()->routeIs('moderator.reports.posts') ? 'text-red-600 border-b-2 border-red-600 dark:text-red-500 dark:border-red-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Posts
                </a>
                <a href="{{ route('moderator.reports.comments') }}" class="px-6 py-3 text-center text-sm font-medium {{ request()->routeIs('moderator.reports.comments') ? 'text-red-600 border-b-2 border-red-600 dark:text-red-500 dark:border-red-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Commentaires
                </a>
                <a href="{{ route('moderator.reports.communities') }}" class="px-6 py-3 text-center text-sm font-medium {{ request()->routeIs('moderator.reports.communities') ? 'text-red-600 border-b-2 border-red-600 dark:text-red-500 dark:border-red-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Communautés
                </a>
            </div>
        </div>

        <!-- Liste des signalements -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Signalements en attente
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    {{ $reports->total() }} signalements trouvés
                </p>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Contenu signalé
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Signalé par
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($reports as $report)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ $report->reportType->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($report->reportable_type === 'App\\Models\\Post')
                                                    <span class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-0.5 rounded-full mr-1">Post</span>
                                                    {{ Str::limit($report->reportable->titre ?? 'Contenu supprimé', 30) }}
                                                @elseif($report->reportable_type === 'App\\Models\\Comment')
                                                    <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-0.5 rounded-full mr-1">Commentaire</span>
                                                    {{ Str::limit($report->reportable->contenu ?? 'Contenu supprimé', 30) }}
                                                @elseif($report->reportable_type === 'App\\Models\\Community')
                                                    <span class="text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-2 py-0.5 rounded-full mr-1">Communauté</span>
                                                    {{ $report->reportable->theme_name ?? 'Contenu supprimé' }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $report->user->prenom }} {{ $report->user->nom }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $report->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('moderator.reports.show', $report) }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    Détails
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                                Aucun signalement non traité trouvé
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>