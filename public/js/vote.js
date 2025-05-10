document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les boutons de vote
    const voteButtons = document.querySelectorAll('.vote-button');
    
    voteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            const formData = new FormData(form);
            
            // Utiliser l'attribut formaction du bouton s'il existe, sinon utiliser l'action du formulaire
            const url = this.formAction || 
                      (this === form.querySelector('button:first-of-type') 
                      ? form.action 
                      : form.querySelector('button:last-of-type').getAttribute('formaction'));
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le compteur de votes
                    const voteCount = form.querySelector('.vote-count');
                    if (voteCount) voteCount.textContent = data.likes;
                    
                    // Obtenir les éléments nécessaires
                    const upvoteBtn = form.querySelector('button:first-of-type');
                    const downvoteBtn = form.querySelector('button:last-of-type');
                    const upvoteIcon = upvoteBtn.querySelector('svg');
                    const downvoteIcon = downvoteBtn.querySelector('svg');
                    
                    // Mettre à jour les couleurs du compteur de votes
                    if (data.vote_type === 'upvote') {
                        voteCount.className = voteCount.className.replace(/text-blue-[45]00|text-gray-[28]00/g, 'text-orange-500');
                    } else if (data.vote_type === 'downvote') {
                        voteCount.className = voteCount.className.replace(/text-orange-[45]00|text-gray-[28]00/g, 'text-blue-500');
                    } else {
                        voteCount.className = voteCount.className.replace(/text-orange-[45]00|text-blue-[45]00/g, 'text-gray-800');
                    }
                    
                    // Réinitialiser les styles des boutons
                    upvoteBtn.className = upvoteBtn.className.replace(/text-orange-[45]00/g, 'text-gray-400 hover:text-orange-500');
                    downvoteBtn.className = downvoteBtn.className.replace(/text-blue-[45]00/g, 'text-gray-400 hover:text-blue-500');
                    upvoteIcon.setAttribute('fill', 'none');
                    downvoteIcon.setAttribute('fill', 'none');
                    
                    // Appliquer le style en fonction du vote
                    if (data.vote_type === 'upvote') {
                        upvoteBtn.className = upvoteBtn.className.replace(/text-gray-400 hover:text-orange-500/, 'text-orange-500');
                        upvoteIcon.setAttribute('fill', 'currentColor');
                    } else if (data.vote_type === 'downvote') {
                        downvoteBtn.className = downvoteBtn.className.replace(/text-gray-400 hover:text-blue-500/, 'text-blue-500');
                        downvoteIcon.setAttribute('fill', 'currentColor');
                    }
                }
            })
            .catch(error => {
                console.error('Erreur lors du vote:', error);
            });
        });
    });
    
    // Ajouter des styles pour améliorer l'interaction
    const style = document.createElement('style');
    style.textContent = `
        .vote-button {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .vote-button:hover {
            transform: scale(1.2);
        }
    `;
    document.head.appendChild(style);
});