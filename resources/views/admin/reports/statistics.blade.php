<x-layouts.app :title="'Statistiques de modération | Marro'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Statistiques de modération</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Analyse des activités de modération de la plateforme</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Voir les signalements
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Total des signalements
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $statistics['total'] ?? 0 }}
                        </dd>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Signalements en attente
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-red-600 dark:text-red-400">
                            {{ $statistics['pending'] ?? 0 }}
                        </dd>
                        <div class="mt-1">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $statistics['pending'] > 0 ? number_format(($statistics['pending'] / $statistics['total']) * 100, 1) : 0 }}% du total
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Signalements traités
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-green-600 dark:text-green-400">
                            {{ $statistics['handled'] ?? 0 }}
                        </dd>
                        <div class="mt-1">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $statistics['handled'] > 0 ? number_format(($statistics['handled'] / $statistics['total']) * 100, 1) : 0 }}% du total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Répartition par type de signalement
                        </h3>
                    </div>
                    <div class="p-6">
                        @if(isset($statistics['by_type']) && count($statistics['by_type']) > 0)
                            <div class="relative" style="height: 300px;">
                                <canvas id="reportTypeChart"></canvas>
                            </div>
                        @else
                            <div class="flex justify-center items-center h-64">
                                <p class="text-gray-500 dark:text-gray-400 text-center">
                                    Aucune donnée disponible pour générer le graphique.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Évolution des signalements (30 derniers jours)
                        </h3>
                    </div>
                    <div class="p-6">
                        @if(isset($statistics['recent_daily']) && count($statistics['recent_daily']) > 0)
                            <div class="relative" style="height: 300px;">
                                <canvas id="reportTimelineChart"></canvas>
                            </div>
                        @else
                            <div class="flex justify-center items-center h-64">
                                <p class="text-gray-500 dark:text-gray-400 text-center">
                                    Aucune donnée disponible pour générer le graphique.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Tendances des signalements
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type de rapport</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pourcentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @if(isset($statistics['by_type']) && count($statistics['by_type']) > 0)
                                        @foreach($statistics['by_type'] as $type)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $type->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $type->total }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ number_format(($type->total / $statistics['total']) * 100, 1) }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                                Aucune donnée disponible.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDarkMode = document.documentElement.classList.contains('dark');
                const textColor = isDarkMode ? '#E5E7EB' : '#374151';
                const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

                const commonOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: textColor,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: textColor
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: textColor
                            }
                        }
                    }
                };

                // Graphique de répartition par type
                const typeChartEl = document.getElementById('reportTypeChart');
                if (typeChartEl) {
                    @if(isset($statistics['by_type']) && count($statistics['by_type']) > 0)
                        const typeLabels = @json($statistics['by_type']->pluck('name'));
                        const typeData = @json($statistics['by_type']->pluck('total'));
                        
                        new Chart(typeChartEl, {
                            type: 'pie',
                            data: {
                                labels: typeLabels,
                                datasets: [{
                                    data: typeData,
                                    backgroundColor: [
                                        '#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                                        '#EC4899', '#06B6D4', '#84CC16', '#F97316', '#6366F1'
                                    ]
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        position: 'right',
                                        labels: {
                                            color: textColor,
                                            font: {
                                                size: 12
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    @endif
                }

                // Graphique d'évolution temporelle
                const timelineChartEl = document.getElementById('reportTimelineChart');
                if (timelineChartEl) {
                    @if(isset($statistics['recent_daily']) && count($statistics['recent_daily']) > 0)
                        const timelineLabels = @json($statistics['recent_daily']->pluck('date'));
                        const timelineData = @json($statistics['recent_daily']->pluck('total'));
                        
                        new Chart(timelineChartEl, {
                            type: 'line',
                            data: {
                                labels: timelineLabels,
                                datasets: [{
                                    label: 'Nombre de signalements',
                                    data: timelineData,
                                    borderColor: '#4F46E5',
                                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                    tension: 0.3,
                                    fill: true
                                }]
                            },
                            options: commonOptions
                        });
                    @endif
                }
            });
        </script>
    @endpush
</x-layouts.app>