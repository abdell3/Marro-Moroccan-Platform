import './bootstrap';
import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Définir Alpine et GSAP globalement pour être utilisés dans les scripts blade
window.Alpine = Alpine;
window.gsap = gsap;

// Enregistrer les plugins GSAP
gsap.registerPlugin(ScrollTrigger);

// Initialiser Alpine.js
Alpine.start();

// Animations globales
document.addEventListener('DOMContentLoaded', () => {
    // Animation de base pour les éléments qui apparaissent
    const fadeInElements = document.querySelectorAll('.fade-in');
    if (fadeInElements.length > 0) {
        gsap.from(fadeInElements, {
            opacity: 0,
            y: 20,
            duration: 0.8,
            stagger: 0.1,
            ease: 'power2.out'
        });
    }

    // Animation pour les formulaires
    const formElements = document.querySelectorAll('form .form-element');
    if (formElements.length > 0) {
        gsap.from(formElements, {
            opacity: 0,
            y: 15,
            duration: 0.6,
            stagger: 0.1,
            delay: 0.2,
            ease: 'power2.out'
        });
    }

    // Animation pour les cartes
    const cards = document.querySelectorAll('.card-animate');
    if (cards.length > 0) {
        gsap.from(cards, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            stagger: 0.15,
            ease: 'power3.out'
        });
    }

    // Animation pour les notifications
    const notifications = document.querySelectorAll('.notification');
    if (notifications.length > 0) {
        gsap.from(notifications, {
            opacity: 0,
            x: 20,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out'
        });
    }
    
    // Effet de hover pour les boutons
    const buttons = document.querySelectorAll('button, .btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.2,
                ease: 'power1.out'
            });
        });
        
        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.2,
                ease: 'power1.in'
            });
        });
    });
});

// Animation des particules pour les pages d'authentification
export function initAuthParticles() {
    if (typeof particlesJS !== 'undefined' && document.getElementById('particles-auth')) {
        particlesJS('particles-auth', {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.2,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 0.6
                        }
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    }
}

// Animation des bulles flottantes
export function initFloatingBubbles() {
    const bubbles = document.querySelectorAll('.floating-bubble');
    if (bubbles.length > 0) {
        bubbles.forEach((bubble, index) => {
            const size = gsap.utils.random(20, 60);
            const duration = gsap.utils.random(10, 30);
            const startX = gsap.utils.random(-20, 20);
            const startY = gsap.utils.random(-20, 20);
            
            gsap.set(bubble, {
                width: size,
                height: size,
                borderRadius: '50%',
                backgroundColor: 'rgba(255, 255, 255, 0.1)',
                position: 'absolute',
                top: `${gsap.utils.random(0, 100)}%`,
                left: `${gsap.utils.random(0, 100)}%`,
            });
            
            gsap.to(bubble, {
                x: `+=${startX}`,
                y: `+=${startY}`,
                repeat: -1,
                duration: duration,
                ease: 'sine.inOut',
                yoyo: true,
                delay: index * 0.2,
            });
        });
    }
}

// Exporter des fonctions utilitaires pour les animations
export const animationUtils = {
    fadeIn: (element, delay = 0, duration = 0.8) => {
        gsap.from(element, {
            opacity: 0,
            y: 20,
            duration: duration,
            delay: delay,
            ease: 'power2.out'
        });
    },
    
    fadeInUp: (element, delay = 0, duration = 0.8) => {
        gsap.from(element, {
            opacity: 0,
            y: 50,
            duration: duration,
            delay: delay,
            ease: 'power3.out'
        });
    },
    
    slideIn: (element, fromDirection = 'left', delay = 0, duration = 0.8) => {
        const xValue = fromDirection === 'left' ? -50 : fromDirection === 'right' ? 50 : 0;
        const yValue = fromDirection === 'top' ? -50 : fromDirection === 'bottom' ? 50 : 0;
        
        gsap.from(element, {
            x: xValue,
            y: yValue,
            opacity: 0,
            duration: duration,
            delay: delay,
            ease: 'power2.out'
        });
    },
    
    pulse: (element, scale = 1.05, duration = 0.4) => {
        gsap.to(element, {
            scale: scale,
            duration: duration / 2,
            ease: 'power1.out',
            onComplete: () => {
                gsap.to(element, {
                    scale: 1,
                    duration: duration / 2,
                    ease: 'power1.in'
                });
            }
        });
    }
};