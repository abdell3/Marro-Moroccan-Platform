<div class="poll-creation-section mb-4" id="pollSection" style="display: none;">
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Créer un sondage</h3>
        
        <div class="mb-4">
            <label for="poll_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type de sondage</label>
            <select name="poll_type" id="poll_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="standard">Standard (Options 0-5)</option>
                <option value="etoiles">Étoiles (1-5)</option>
                <option value="pouces">Pouces (Haut/Bas)</option>
            </select>
        </div>
        
        <input type="hidden" name="create_poll" value="0" id="create_poll_input">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePollBtn = document.getElementById('togglePollBtn');
        const pollSection = document.getElementById('pollSection');
        const createPollInput = document.getElementById('create_poll_input');
        
        if (togglePollBtn && pollSection && createPollInput) {
            togglePollBtn.addEventListener('click', function() {
                if (pollSection.style.display === 'none') {
                    pollSection.style.display = 'block';
                    createPollInput.value = '1';
                    togglePollBtn.innerHTML = 'Annuler le sondage <svg class="h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                    togglePollBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    togglePollBtn.classList.add('bg-red-100', 'hover:bg-red-200', 'text-red-700');
                } else {
                    pollSection.style.display = 'none';
                    createPollInput.value = '0';
                    togglePollBtn.innerHTML = 'Ajouter un sondage <svg class="h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>';
                    togglePollBtn.classList.remove('bg-red-100', 'hover:bg-red-200', 'text-red-700');
                    togglePollBtn.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                }
            });
        }
    });
</script>