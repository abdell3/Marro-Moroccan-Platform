/**
 * Gestionnaire de sélection de tags sans création de nouveaux tags
 */
document.addEventListener('DOMContentLoaded', function() {
    const tagInput = document.getElementById('tags');
    if (!tagInput) return;
    
    // Récupérer les tags existants depuis l'élément data du DOM
    const existingTagsElement = document.getElementById('existing-tags-data');
    let existingTags = [];
    
    if (existingTagsElement && existingTagsElement.dataset.tags) {
        try {
            existingTags = JSON.parse(existingTagsElement.dataset.tags);
        } catch (error) {
            console.error('Erreur lors du parsing des tags:', error);
        }
    }
    
    // Créer le conteneur pour les tags sélectionnés
    const tagContainer = document.createElement('div');
    tagContainer.className = 'tag-container mt-2 flex flex-wrap gap-2';
    tagInput.parentNode.insertBefore(tagContainer, tagInput.nextSibling);
    
    // Créer un conteneur pour la liste déroulante d'autocomplétion
    const autocompleteContainer = document.createElement('div');
    autocompleteContainer.className = 'autocomplete-container absolute z-10 bg-white dark:bg-gray-800 shadow-lg rounded-md overflow-hidden w-full max-h-60 overflow-y-auto hidden';
    tagInput.parentNode.style.position = 'relative';
    tagInput.parentNode.appendChild(autocompleteContainer);
    
    // Créer un conteneur pour la liste des tags disponibles
    const availableTagsContainer = document.createElement('div');
    availableTagsContainer.className = 'available-tags-container mt-2';
    availableTagsContainer.innerHTML = `
        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tags disponibles :</div>
        <div class="available-tags flex flex-wrap gap-1"></div>
    `;
    tagInput.parentNode.appendChild(availableTagsContainer);
    
    const availableTags = availableTagsContainer.querySelector('.available-tags');
    
    // Remplir la liste des tags disponibles
    if (existingTags.length > 0) {
        existingTags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'available-tag inline-flex items-center bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-md cursor-pointer dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600';
            tagElement.textContent = tag.title;
            tagElement.dataset.id = tag.id;
            tagElement.title = tag.description || tag.title;
            
            tagElement.addEventListener('click', () => {
                addTag(tag.title, tag.id);
                tagInput.value = '';
                filterAvailableTags('');
            });
            
            availableTags.appendChild(tagElement);
        });
    }
    
    let selectedTags = [];
    
    // Initialiser des tags existants
    if (tagInput.value) {
        // On garde les tags déjà présents uniquement s'ils existent dans la liste
        const existingTagValues = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag);
        existingTagValues.forEach(tagTitle => {
            // Vérifier si ce tag existe dans la liste des tags disponibles
            const matchingTag = existingTags.find(tag => tag.title.toLowerCase() === tagTitle.toLowerCase());
            if (matchingTag) {
                addTag(matchingTag.title, matchingTag.id);
            }
        });
    }
    
    // Écouter les événements de saisie pour filtrer les tags disponibles
    tagInput.addEventListener('input', function() {
        const searchTerm = this.value.trim().toLowerCase();
        filterAvailableTags(searchTerm);
        
        // Si la valeur est vide ou ne contient que des espaces, on cache les résultats
        if (searchTerm === '') {
            autocompleteContainer.classList.add('hidden');
            return;
        }
        
        // Filtrer les tags qui correspondent au terme de recherche
        const matchingTags = existingTags.filter(tag => 
            tag.title.toLowerCase().includes(searchTerm) && 
            !selectedTags.some(selected => selected.id === tag.id)
        );
        
        if (matchingTags.length > 0) {
            renderAutocompleteResults(matchingTags);
        } else {
            autocompleteContainer.classList.add('hidden');
        }
    });
    
    tagInput.addEventListener('keydown', handleKeyDown);
    
    document.addEventListener('click', function(e) {
        if (!tagInput.contains(e.target) && !autocompleteContainer.contains(e.target)) {
            autocompleteContainer.classList.add('hidden');
        }
    });
    
    function renderAutocompleteResults(tags) {
        autocompleteContainer.innerHTML = '';
        
        if (tags.length === 0) {
            autocompleteContainer.classList.add('hidden');
            return;
        }
        
        tags.forEach(tag => {
            if (selectedTags.some(selected => selected.id === tag.id)) return;
            
            const item = document.createElement('div');
            item.className = 'autocomplete-item p-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer';
            item.textContent = tag.title;
            
            item.addEventListener('click', () => {
                addTag(tag.title, tag.id);
                tagInput.value = '';
                autocompleteContainer.classList.add('hidden');
                filterAvailableTags('');
            });
            
            autocompleteContainer.appendChild(item);
        });
        
        autocompleteContainer.classList.remove('hidden');
    }
    
    function filterAvailableTags(searchTerm) {
        const availableTagElements = availableTags.querySelectorAll('.available-tag');
        
        availableTagElements.forEach(tagElement => {
            const tagId = parseInt(tagElement.dataset.id);
            const tagName = tagElement.textContent.toLowerCase();
            const isSelected = selectedTags.some(tag => tag.id === tagId);
            
            if ((searchTerm === '' || tagName.includes(searchTerm)) && !isSelected) {
                tagElement.classList.remove('hidden');
            } else {
                tagElement.classList.add('hidden');
            }
        });
    }
    
    function addTag(tagName, tagId) {
        tagName = tagName.trim();
        if (!tagName || selectedTags.some(tag => tag.id === tagId)) return;
        
        // Vérifier si le tag existe dans la liste des tags disponibles
        const existingTag = existingTags.find(tag => tag.id === tagId || tag.title.toLowerCase() === tagName.toLowerCase());
        
        if (!existingTag) {
            showErrorMessage('Ce tag n\'existe pas. Veuillez sélectionner un tag dans la liste.');
            return;
        }
        
        selectedTags.push({
            id: existingTag.id,
            title: existingTag.title
        });
        
        const tagElement = document.createElement('span');
        tagElement.className = 'tag inline-flex items-center bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded-md dark:bg-red-900 dark:text-red-200';
        tagElement.innerHTML = `
            ${existingTag.title}
            <button type="button" class="tag-remove ml-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        `;
        
        tagContainer.appendChild(tagElement);
        updateHiddenInput();
        
        // Mettre à jour l'affichage des tags disponibles
        filterAvailableTags(tagInput.value.trim().toLowerCase());
        
        // Ajouter le gestionnaire de suppression
        const removeButton = tagElement.querySelector('.tag-remove');
        if (removeButton) {
            removeButton.addEventListener('click', () => {
                tagElement.remove();
                selectedTags = selectedTags.filter(tag => tag.id !== existingTag.id);
                updateHiddenInput();
                filterAvailableTags(tagInput.value.trim().toLowerCase());
            });
        }
    }
    
    function handleKeyDown(e) {
        if (e.key === 'Enter' && !autocompleteContainer.classList.contains('hidden')) {
            e.preventDefault();
            
            const firstItem = autocompleteContainer.querySelector('.autocomplete-item');
            if (firstItem) {
                firstItem.click();
            }
        } else if (e.key === 'Backspace' && tagInput.value === '') {
            // Supprimer le dernier tag ajouté quand on appuie sur Backspace avec un champ vide
            const lastTag = tagContainer.lastChild;
            if (lastTag) {
                lastTag.querySelector('.tag-remove').click();
            }
        } else if (e.key === ',') {
            // Empêcher la saisie de virgules car elles sont utilisées comme séparateur
            e.preventDefault();
        }
    }
    
    function updateHiddenInput() {
        tagInput.value = selectedTags.map(tag => tag.title).join(', ');
    }
    
    function showErrorMessage(message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'text-red-500 text-sm mt-1 mb-2 tag-error-message';
        errorElement.textContent = message;
        
        // Supprimer les messages d'erreur existants
        const existingErrors = document.querySelectorAll('.tag-error-message');
        existingErrors.forEach(elem => elem.remove());
        
        // Ajouter le nouveau message
        tagContainer.parentNode.insertBefore(errorElement, tagContainer.nextSibling);
        
        // Supprimer le message après 3 secondes
        setTimeout(() => {
            errorElement.remove();
        }, 3000);
    }
});
