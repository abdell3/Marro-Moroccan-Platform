<x-layouts.app title="Changer d'avatar | Marro">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-md mx-auto">
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h2 class="text-xl font-medium text-gray-900">Changer d'avatar</h2>
                    <p class="mt-1 text-sm text-gray-500">Téléchargez une nouvelle photo de profil</p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-center mb-6">
                        <div class="bg-gray-200 rounded-full w-32 h-32 flex items-center justify-center overflow-hidden border-4 border-white shadow">
                            <img src="{{ auth()->user()->avatar ?? asset('avatars/default.png') }}" alt="Avatar actuel" class="h-full w-full object-cover" id="avatar-preview">
                        </div>
                    </div>
                    
                    <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                                Nouvel avatar
                            </label>
                            
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="avatar" class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                                            <span>Télécharger un fichier</span>
                                            <input id="avatar" name="avatar" type="file" class="sr-only" accept="image/*" onchange="previewAvatar(this)">
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF jusqu'à 2 Mo
                                    </p>
                                </div>
                            </div>
                            
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4 justify-between">
                            <x-ui.button 
                                type="button" 
                                variant="outline" 
                                tag="a"
                                href="{{ route('profile.show') }}"
                            >
                                Annuler
                            </x-ui.button>
                            
                            <div class="flex space-x-3">
                                @if(auth()->user()->avatar)
                                    <x-ui.button 
                                        type="button" 
                                        variant="danger"
                                        onclick="document.getElementById('delete-avatar-form').submit();"
                                    >
                                        Supprimer l'avatar
                                    </x-ui.button>
                                @endif
                                
                                <x-ui.button type="submit" variant="primary">
                                    Enregistrer
                                </x-ui.button>
                            </div>
                        </div>
                    </form>
                    
                    @if(auth()->user()->avatar)
                        <form id="delete-avatar-form" action="{{ route('profile.avatar.delete') }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
            
            <div class="mt-8 bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h2 class="text-xl font-medium text-gray-900">Avatars prédéfinis</h2>
                    <p class="mt-1 text-sm text-gray-500">Choisissez parmi notre collection</p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('profile.avatar.preset') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-4 gap-4">
                            @foreach(['default1.png', 'default2.png', 'default3.png', 'default4.png', 'default5.png', 'default6.png', 'default7.png', 'default8.png'] as $preset)
                                <label class="relative cursor-pointer rounded-full overflow-hidden border-4 hover:border-red-500 @if(auth()->user()->avatar === 'avatars/' . $preset) border-red-500 @else border-white @endif shadow">
                                    <input type="radio" name="preset" value="{{ $preset }}" class="sr-only" @if(auth()->user()->avatar === 'avatars/' . $preset) checked @endif>
                                    <img src="{{ asset('avatars/' . $preset) }}" alt="Avatar prédéfini" class="h-full w-full object-cover">
                                </label>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex justify-center">
                            <x-ui.button type="submit" variant="primary" size="sm">
                                Utiliser sélectionné
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layouts.app>