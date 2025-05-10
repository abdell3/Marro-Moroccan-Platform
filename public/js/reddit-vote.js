/**
 * System de vote style Reddit
 * Ce script gère les interactions de vote pour upvote/downvote
 */

function submitVoteForm(action, postId) {
    const formId = action === 'upvote' ? `upvote-form-${postId}` : `downvote-form-${postId}`;
    const form = document.getElementById(formId);
    
    if (!form) {
        console.error(`Form ${formId} not found`);
        return;
    }
    
    // Récupérer le token CSRF
    const csrfToken = form.querySelector('input[name="_token"]').value;
    
    // Créer les données du formulaire
    const formData = new FormData(form);
    
    // Envoyer la requête AJAX
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Trouver le conteneur de vote
            const voteArea = form.closest('.vote-area');
            if (!voteArea) return;
            
            // Mettre à jour le compteur de votes
            const voteCount = voteArea.querySelector('.vote-count');
            if (voteCount) {
                voteCount.textContent = data.likes;
                
                // Réinitialiser les classes
                voteCount.classList.remove('upvoted', 'downvoted');
                
                // Ajouter la classe appropriée
                if (data.vote_type === 'upvote') {
                    voteCount.classList.add('upvoted');
                } else if (data.vote_type === 'downvote') {
                    voteCount.classList.add('downvoted');
                }
            }
            
            // Mettre à jour les boutons
            const upvoteButton = voteArea.querySelector('.upvote-button');
            const downvoteButton = voteArea.querySelector('.downvote-button');
            
            if (upvoteButton && downvoteButton) {
                // Réinitialiser les classes
                upvoteButton.classList.remove('upvoted');
                downvoteButton.classList.remove('downvoted');
                
                // Mettre à jour l'état des boutons
                if (data.vote_type === 'upvote') {
                    upvoteButton.classList.add('upvoted');
                } else if (data.vote_type === 'downvote') {
                    downvoteButton.classList.add('downvoted');
                }
            }
            
            // Mettre à jour l'attribut data-vote-state pour les référence futures
            voteArea.dataset.voteState = data.vote_type || 'none';
        }
    })
    .catch(error => {
        console.error('Error during vote:', error);
    });
}
