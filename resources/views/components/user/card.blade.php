@props(['user'])

<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-200">
                    <img src="{{ $user->avatar ?? asset('avatars/default.png') }}" alt="{{ $user->nom }}" class="h-full w-full object-cover">
                </div>
            </div>
            
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ $user->prenom }} {{ $user->nom }}
                </h3>
                
                <div class="flex items-center space-x-2">
                    @if($user->role)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $user->role->role_name }}
                        </span>
                    @endif
                    
                    <p class="text-sm text-gray-500">
                        Membre depuis {{ $user->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        </div>
        
        @if($user->bio)
            <div class="mt-4 text-sm text-gray-600">
                {{ $user->bio }}
            </div>
        @endif
        
        <div class="mt-4 flex space-x-3">
            <div class="text-center flex-1 px-2 py-1 bg-gray-50 rounded-md">
                <span class="text-sm font-medium text-gray-900">{{ $user->posts_count }}</span>
                <p class="text-xs text-gray-500">Posts</p>
            </div>
            
            <div class="text-center flex-1 px-2 py-1 bg-gray-50 rounded-md">
                <span class="text-sm font-medium text-gray-900">{{ $user->comments_count }}</span>
                <p class="text-xs text-gray-500">Commentaires</p>
            </div>
            
            <div class="text-center flex-1 px-2 py-1 bg-gray-50 rounded-md">
                <span class="text-sm font-medium text-gray-900">{{ $user->communities_count }}</span>
                <p class="text-xs text-gray-500">Communautés</p>
            </div>
        </div>
        
        <x-badges.user-badges :user="$user" />
        
        {{ $slot }}
    </div>
</div>