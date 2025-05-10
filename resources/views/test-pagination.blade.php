<x-layouts.app title="Test Pagination | Marro">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Test de Pagination</h1>
        
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Informations de Pagination</h2>
            
            @if(isset($posts) && $posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-green-100 dark:bg-green-800 p-4 rounded-lg mb-6">
                    <h3 class="font-bold text-green-800 dark:text-green-200">Pagination détectée!</h3>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        <li>Nombre total d'éléments: {{ $posts->total() }}</li>
                        <li>Éléments par page: {{ $posts->perPage() }}</li>
                        <li>Page actuelle: {{ $posts->currentPage() }}</li>
                        <li>Nombre total de pages: {{ $posts->lastPage() }}</li>
                        <li>Premier élément sur cette page: {{ $posts->firstItem() }}</li>
                        <li>Dernier élément sur cette page: {{ $posts->lastItem() }}</li>
                    </ul>
                </div>
                
                <div class="space-y-4 mb-6">
                    @foreach($posts as $post)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="font-bold">{{ $post->titre }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $post->id }} | Date: {{ $post->created_at }}</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    <!-- Navigation de pagination -->
                    {{ $posts->links() }}
                </div>
            @else
                <div class="bg-red-100 dark:bg-red-800 p-4 rounded-lg mb-6">
                    <h3 class="font-bold text-red-800 dark:text-red-200">Aucune pagination détectée!</h3>
                    <p class="mt-2 text-sm">La variable $posts n'est pas une instance de LengthAwarePaginator.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>