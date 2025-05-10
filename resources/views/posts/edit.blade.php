<x-layouts.app title="Modifier le post | Marro">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier le post</h1>
            <p class="text-gray-600 dark:text-gray-400">Mettez à jour votre contenu</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Sélection de la communauté -->
                <div class="mb-4">
                    <label for="community_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Communauté</label>
                    <select name="community_id" id="community_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Sélectionner une communauté</option>
                        @foreach($communities as $community)
                            <option value="{{ $community->id }}" {{ old('community_id', $post->community_id) == $community->id ? 'selected' : '' }}>
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
                    <input type="text" name="titre" id="titre" value="{{ old('titre', $post->titre) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Un titre accrocheur">
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu du post -->
                <div class="mb-4">
                    <label for="contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
                    <textarea name="contenu" id="contenu" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Partagez vos pensées...">{{ old('contenu', $post->contenu) }}</textarea>
                    @error('contenu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Si c'est un post de type média, afficher le média existant et option de le remplacer -->
                @if($post->typeContenu === 'image' || $post->typeContenu === 'video')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Média actuel</label>
                        @if($post->typeContenu === 'image')
                            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->titre }}" class="max-w-full h-auto rounded-lg mb-2 max-h-64">
                        @elseif($post->typeContenu === 'video')
                            <video controls class="max-w-full h-auto rounded-lg mb-2 max-h-64">
                                <source src="{{ asset('storage/' . $post->media_path) }}" type="{{ $post->media_type }}">
                                Votre navigateur ne supporte pas la lecture de vidéos.
                            </video>
                        @endif
                        
                        <div class="mt-2">
                            <label for="media" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remplacer le média (optionnel)</label>
                            <input type="file" name="media" id="media" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, GIF, MP4, AVI (max 10MB)</p>
                            @error('media')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Tags -->
                <div class="mb-6">
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags', $post->tags->pluck('title')->implode(', ')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Sélectionnez des tags existants" readonly>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Sélectionnez des tags existants pour faciliter la découverte de votre post</p>
                    <!-- Données des tags existants pour le JavaScript -->
                    <div id="existing-tags-data" data-tags='{{ json_encode($existingTags ?? []) }}' class="hidden"></div>
                    <div id="selected-tags" class="mt-2 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                        <span class="tag inline-flex items-center bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded-md dark:bg-red-900 dark:text-red-200">
                            {{ $tag->title }}
                            <button type="button" class="tag-remove ml-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" data-tag-id="{{ $tag->id }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </span>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tags disponibles :</p>
                        <div class="available-tags flex flex-wrap gap-2">
                            @foreach($existingTags as $tag)
                            <span class="tag-option cursor-pointer bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-md dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600" data-tag-id="{{ $tag->id }}" data-tag-title="{{ $tag->title }}">
                                {{ $tag->title }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('posts.show', $post) }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Gestionnaire de sélection de tags customisé (pour éviter la création manuelle)
        document.addEventListener('DOMContentLoaded', function() {
            const tagsInput = document.getElementById('tags');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const tagOptions = document.querySelectorAll('.tag-option');
            const tagRemoveButtons = document.querySelectorAll('.tag-remove');
            
            // Ensemble pour stocker les IDs des tags sélectionnés
            let selectedTagIds = new Set();
            
            // Initialiser l'ensemble avec les tags déjà sélectionnés
            document.querySelectorAll('#selected-tags .tag').forEach(tagElement => {
                const removeButton = tagElement.querySelector('.tag-remove');
                if (removeButton && removeButton.dataset.tagId) {
                    selectedTagIds.add(removeButton.dataset.tagId);
                }
            });
            
            // Mettre à jour le champ input avec les titres des tags sélectionnés
            const updateTagsInput = () => {
                const tagTitles = [];
                document.querySelectorAll('#selected-tags .tag').forEach(tag => {
                    tagTitles.push(tag.textContent.trim());
                });
                tagsInput.value = tagTitles.join(', ');
            };
            
            // Fonction pour gérer le clic sur un tag disponible
            const handleTagOptionClick = (e) => {
                const tagId = e.currentTarget.dataset.tagId;
                const tagTitle = e.currentTarget.dataset.tagTitle;
                
                // Vérifier si le tag est déjà sélectionné
                if (selectedTagIds.has(tagId)) return;
                
                // Ajouter le tag à la liste des sélectionnés
                selectedTagIds.add(tagId);
                
                // Créer l'élément tag
                const tagElement = document.createElement('span');
                tagElement.className = 'tag inline-flex items-center bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded-md dark:bg-red-900 dark:text-red-200';
                tagElement.innerHTML = `
                    ${tagTitle}
                    <button type="button" class="tag-remove ml-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" data-tag-id="${tagId}">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                `;
                
                // Ajouter le gestionnaire de suppression
                const removeButton = tagElement.querySelector('.tag-remove');
                if (removeButton) {
                    removeButton.addEventListener('click', handleTagRemove);
                }
                
                // Ajouter le tag à la liste
                selectedTagsContainer.appendChild(tagElement);
                
                // Mettre à jour le champ input
                updateTagsInput();
                
                // Masquer l'option de tag dans la liste disponible
                e.currentTarget.classList.add('hidden');
            };
            
            // Fonction pour gérer la suppression d'un tag
            const handleTagRemove = (e) => {
                const tagId = e.currentTarget.dataset.tagId;
                const tagElement = e.currentTarget.closest('.tag');
                
                // Supprimer le tag de la liste
                if (tagElement) {
                    tagElement.remove();
                }
                
                // Retirer le tag de l'ensemble
                selectedTagIds.delete(tagId);
                
                // Mettre à jour le champ input
                updateTagsInput();
                
                // Réafficher l'option de tag dans la liste disponible
                document.querySelectorAll('.tag-option').forEach(option => {
                    if (option.dataset.tagId === tagId) {
                        option.classList.remove('hidden');
                    }
                });
            };
            
            // Ajouter les gestionnaires d'événements
            tagOptions.forEach(option => {
                option.addEventListener('click', handleTagOptionClick);
                
                // Masquer les options déjà sélectionnées
                if (selectedTagIds.has(option.dataset.tagId)) {
                    option.classList.add('hidden');
                }
            });
            
            // Ajouter les gestionnaires de suppression pour les tags existants
            tagRemoveButtons.forEach(button => {
                button.addEventListener('click', handleTagRemove);
            });
            
            // Mettre à jour le champ input pour s'assurer que les tags sont bien enregistrés
            updateTagsInput();
        });
    </script>
</x-layouts.app>