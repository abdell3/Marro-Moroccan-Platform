<x-layouts.app title="Créer un post | Marro">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Créer un post</h1>
            <p class="text-gray-600 dark:text-gray-400">Partagez du contenu avec la communauté</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <!-- Onglets de type de post -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px">
                    <button type="button" id="tab-text" class="tab-button active py-4 px-6 border-b-2 border-red-500 text-red-600 font-medium text-sm">
                        Texte
                    </button>
                    <button type="button" id="tab-media" class="tab-button py-4 px-6 border-b-2 border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700 font-medium text-sm">
                        Images & Vidéo
                    </button>
                    <button type="button" id="tab-link" class="tab-button py-4 px-6 border-b-2 border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700 font-medium text-sm">
                        Lien
                    </button>
                    <button type="button" id="tab-poll" class="tab-button py-4 px-6 border-b-2 border-transparent hover:border-gray-300 text-gray-500 hover:text-gray-700 font-medium text-sm">
                        Sondage
                    </button>
                </nav>
            </div>
            
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

                <input type="hidden" name="post_type" id="post_type" value="text">
                
                <div id="section-text" class="post-section">
                    <div class="mb-4">
                        <label for="contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
                        <textarea name="contenu" id="contenu" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Partagez vos pensées...">{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div id="section-media" class="post-section hidden">
                    <div class="mb-4">
                        <label for="media" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image ou Vidéo</label>
                        <input type="file" name="media" id="media" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, GIF, MP4, AVI (max 10MB)</p>
                        @error('media')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="media_contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (optionnel)</label>
                        <textarea name="media_contenu" id="media_contenu" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ajoutez une description à votre image ou vidéo">{{ old('media_contenu') }}</textarea>
                    </div>
                </div>
                
                <div id="section-link" class="post-section hidden">
                    <div class="mb-4">
                        <label for="link_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL</label>
                        <input type="url" name="link_url" id="link_url" value="{{ old('link_url') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://exemple.com">
                        @error('link_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="link_contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (optionnel)</label>
                        <textarea name="link_contenu" id="link_contenu" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ajoutez une description au lien">{{ old('link_contenu') }}</textarea>
                    </div>
                </div>
                
                <div id="section-poll" class="post-section hidden">
                    <div class="poll-options mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de sondage</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="poll_type" value="standard" class="form-radio text-red-600" checked>
                                <span class="ml-2">Standard</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="poll_type" value="etoiles" class="form-radio text-red-600">
                                <span class="ml-2">Étoiles</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="poll_type" value="pouces" class="form-radio text-red-600">
                                <span class="ml-2">Pouces</span>
                            </label>
                        </div>
                    </div>
                    
                    <input type="hidden" name="create_poll" value="1" id="create_poll_input">
                    
                    <div class="mb-4">
                        <label for="poll_contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question du sondage</label>
                        <input type="text" name="question" id="poll_question" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Posez votre question ici">
                    </div>
                    
                    <div id="poll-options-section" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options du sondage</label>
                        <div id="poll-options-container" class="space-y-2 mb-2">
                            <!-- Les options seront ajoutées ici dynamiquement -->
                        </div>
                        <button type="button" id="add-option-button" class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Ajouter une option
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label for="poll_contenu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (optionnel)</label>
                        <textarea name="poll_contenu" id="poll_contenu" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Ajoutez du contexte à votre sondage">{{ old('poll_contenu') }}</textarea>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Sélectionnez des tags existants" readonly>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Sélectionnez des tags existants pour faciliter la découverte de votre post</p>
                    <!-- Données des tags existants pour le JavaScript -->
                    <div id="existing-tags-data" data-tags='{{ json_encode($existingTags) }}' class="hidden"></div>
                    <div id="selected-tags" class="mt-2 flex flex-wrap gap-2">
                        <!-- Les tags sélectionnés s'afficheront ici -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const postSections = document.querySelectorAll('.post-section');
            const postTypeInput = document.getElementById('post_type');
            
            function activateTab(tabId) {
                postSections.forEach(section => section.classList.add('hidden'));
                
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'border-red-500', 'text-red-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                
                const selectedTab = document.getElementById(tabId);
                selectedTab.classList.add('active', 'border-red-500', 'text-red-600');
                selectedTab.classList.remove('border-transparent', 'text-gray-500');
                
                const sectionId = tabId.replace('tab-', 'section-');
                document.getElementById(sectionId).classList.remove('hidden');
                
                postTypeInput.value = tabId.replace('tab-', '');
            }
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    activateTab(this.id);
                });
            });
        });
    </script>
    <script src="{{ asset('js/poll-options.js') }}"></script>
    <script>
        // Gestionnaire de sélection de tags customisé (pour éviter la création manuelle)
        document.addEventListener('DOMContentLoaded', function() {
            const tagsInput = document.getElementById('tags');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const tagOptions = document.querySelectorAll('.tag-option');
            
            // Ensemble pour stocker les IDs des tags sélectionnés
            let selectedTagIds = new Set();
            
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
            });
        });
    </script>
</x-layouts.app>