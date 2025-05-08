<x-layouts.app title="Posts sauvegardés | Marro">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Posts sauvegardés</h1>
        <p class="text-gray-600 dark:text-gray-400">Retrouvez tous les posts que vous avez sauvegardés</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="p-6">
            @php
                $savedPosts = Auth::user()->savedPosts()->with('post.auteur', 'post.community')->get();
            @endphp
            
            @forelse($savedPosts as $savedPost)
                @php
                    $post = $savedPost->post;
                @endphp
                @if($post)
                    @include('posts.partials.post-card', ['post' => $post])
                @endif
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Aucun post sauvegardé</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Vous n'avez pas encore sauvegardé de posts.</p>
                    <div class="mt-6">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Parcourir les posts
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>