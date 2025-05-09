<x-layouts.app title="Créer un post | Marro">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Créer un post</h1>
            <p class="text-gray-600 dark:text-gray-400">Partagez du contenu avec la communauté</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Sélection de la communauté -->
                <div class="mb-4">
                    <label for="community_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Communauté</label>
                    <select name="community_id" id="community_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Sélectionner une communauté</option>
                        @foreach($communities as $community)
                            <option value="{{ $community->id }}" {{ old('community_id', $selectedCommunityId) == $community->id ? 'selected' : '' }}>
                                {{ $community->theme_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('community_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Titre du post -->
                <div class="mb-4">
                    <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                    <input type="text" name="titre" id="titre" value="{{ old('titre') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Un titre accrocheur">
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu du post -->
                <div class="mb-4">
                    <label for="contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
                    <textarea name="contenu" id="contenu" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Partagez vos pensées...">{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload de média -->
                <div class="mb-4">
                    <label for="media" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Média (optionnel)</label>
                    <input type="file" name="media" id="media" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, GIF, MP4, AVI (max 10MB)</p>
                    @error('media')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tags -->
                <div class="mb-6">
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags (séparés par des virgules)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="jeux, tech, musique">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Ajoutez des tags pour faciliter la découverte de votre post</p>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('posts.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Publier
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>