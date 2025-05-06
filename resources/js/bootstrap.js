
import axios from 'axios';
window.axios = axios;

// Configuration du header CSRF pour toutes les requêtes
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Configuration de l'en-tête CSRF pour les requêtes Ajax.
 * Nous récupérons le token depuis le meta tag 'csrf-token'.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Configuration initiale du thème (clair/sombre)
 * Vérifie les préférences de l'utilisateur et applique le thème approprié
 */
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

/**
 * Fonction pour basculer entre les thèmes clair et sombre
 */
window.toggleDarkMode = function() {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
    } else {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
    }
};

/**
 * Détection des clics en dehors d'un élément
 * Utile pour fermer les menus déroulants, modales, etc.
 */
window.clickOutside = function(elementId, callback) {
    document.addEventListener('click', function(event) {
        const element = document.getElementById(elementId);
        if (element && !element.contains(event.target)) {
            callback();
        }
    });
};

/**
 * Pour les notifications flash et les alertes temporaires
 */
window.fadeOutElement = function(elementId, delay = 3000) {
    setTimeout(() => {
        const element = document.getElementById(elementId);
        if (element) {
            element.style.transition = 'opacity 0.5s ease-out';
            element.style.opacity = '0';
            setTimeout(() => {
                element.remove();
            }, 500);
        }
    }, delay);
};

/**
 * Initialisation d'éventuelles WebSockets via Laravel Echo
 * Décommentez ce code si vous avez besoin de fonctionnalités en temps réel
 */
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;
// 
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });