/**
 * Gestionnaire d'options de sondage dynamiques
 */
document.addEventListener('DOMContentLoaded', function() {
    const pollOptionsContainer = document.getElementById('poll-options-container');
    const addOptionButton = document.getElementById('add-option-button');
    const minOptions = 2;
    let optionCount = document.querySelectorAll('.poll-option-input').length || minOptions;
    
    // Ajouter les options minimales au démarrage s'il n'y en a pas
    if (optionCount === 0) {
        for (let i = 0; i < minOptions; i++) {
            addOption();
        }
    }
    
    // Gestionnaire pour ajouter une option
    if (addOptionButton) {
        addOptionButton.addEventListener('click', function() {
            addOption();
        });
    }
    
    // Ajouter un gestionnaire global pour les boutons de suppression
    if (pollOptionsContainer) {
        pollOptionsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option-button') || 
                e.target.closest('.remove-option-button')) {
                
                const optionWrapper = e.target.closest('.poll-option-wrapper');
                if (optionWrapper) {
                    // Vérifier qu'il reste plus de 2 options avant de supprimer
                    const currentOptions = document.querySelectorAll('.poll-option-input');
                    if (currentOptions.length > minOptions) {
                        optionWrapper.remove();
                    } else {
                        // Afficher un message d'erreur
                        showErrorMessage('Un sondage doit avoir au moins 2 options');
                    }
                }
            }
        });
    }
    
    // Fonction pour ajouter une nouvelle option
    function addOption() {
        const newOption = document.createElement('div');
        newOption.className = 'poll-option-wrapper flex items-center space-x-2 mb-2';
        newOption.innerHTML = `
            <input type="text" name="poll_options[]" class="poll-option-input flex-grow rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Option ${optionCount + 1}">
            <button type="button" class="remove-option-button inline-flex items-center p-1 text-sm text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        `;
        
        pollOptionsContainer.appendChild(newOption);
        optionCount++;
        
        // Focus sur le nouveau champ
        const newInput = newOption.querySelector('input');
        if (newInput) {
            newInput.focus();
        }
    }
    
    // Fonction pour afficher un message d'erreur
    function showErrorMessage(message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'text-red-500 text-sm mt-1 mb-2 poll-error-message';
        errorElement.textContent = message;
        
        // Supprimer les messages d'erreur existants
        const existingErrors = document.querySelectorAll('.poll-error-message');
        existingErrors.forEach(elem => elem.remove());
        
        // Ajouter le nouveau message
        pollOptionsContainer.parentNode.insertBefore(errorElement, pollOptionsContainer.nextSibling);
        
        // Supprimer le message après 3 secondes
        setTimeout(() => {
            errorElement.remove();
        }, 3000);
    }
    
    // Afficher ou masquer les options selon le type de sondage
    const pollTypeRadios = document.querySelectorAll('input[name="poll_type"]');
    const pollOptionsSection = document.getElementById('poll-options-section');
    
    if (pollTypeRadios.length && pollOptionsSection) {
        pollTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'standard') {
                    pollOptionsSection.classList.remove('hidden');
                } else {
                    pollOptionsSection.classList.add('hidden');
                }
            });
        });
        
        // Initialiser l'état au chargement
        const checkedType = document.querySelector('input[name="poll_type"]:checked');
        if (checkedType && checkedType.value !== 'standard') {
            pollOptionsSection.classList.add('hidden');
        }
    }
});
