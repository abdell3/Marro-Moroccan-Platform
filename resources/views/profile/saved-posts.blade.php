<x-layouts.app title="Posts sauvegardés | Marro">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h2 class="text-xl font-medium text-gray-900">Posts sauvegardés</h2>
                <p class="mt-1 text-sm text-gray-500">Retrouvez ici tous les posts que vous avez sauvegardés</p>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                @if(count($savedPosts) > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($savedPosts as $post)
                            <div class="py-5 first:pt-0 last:pb-0">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="{{ $post->user->avatar ?? asset('avatars/default.png') }}" alt="{{ $post->user->nom }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $post->user->nom }} {{ $post->user->prenom }}</p>
                                            <span class="text-sm text-gray-500">&middot;</span>
                                            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                            <span class="text-sm text-gray-500">&middot;</span>
                                            <p class="text-sm text-gray-500">dans <a href="{{ route('communities.show', $post->community) }}" class="text-red-600 hover:text-red-500">{{ $post->community->name }}</a></p>
                                        </div>
                                        
                                        <h3 class="mt-1 text-base font-semibold text-gray-900">
                                            <a href="{{ route('posts.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
                                        </h3>
                                        
                                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $post->excerpt }}</p>
                                        
                                        <div class="mt-2 flex items-center space-x-4">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                </svg>
                                                {{ $post->likes_count }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                                {{ $post->comments_count }}
                                            </div>
                                            
                                            <form action="{{ route('posts.unsave', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                    </svg>
                                                    Retirer des favoris
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $savedPosts->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun post sauvegardé</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez à sauvegarder des posts pour les retrouver ici.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                Parcourir les posts
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>