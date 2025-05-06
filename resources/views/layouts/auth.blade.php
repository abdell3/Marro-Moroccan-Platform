<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Marro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Page specific styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen auth-container">
        <!-- Particules d'arrière-plan -->
        <div id="particles-auth" class="particles-container"></div>
        
        <!-- Bulles flottantes décoratives -->
        <div class="floating-bubbles">
            @for ($i = 0; $i < 15; $i++)
                <div class="floating-bubble"></div>
            @endfor
        </div>
        
        <!-- Contenu principal -->
        <div class="relative z-10 w-full px-6">
            <!-- Logo Marro en haut de la page -->
            <div class="absolute top-6 left-6 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-10 h-10 mr-2">
                        <x-ui.logo />
                    </div>
                    <span class="font-bold text-xl text-white">Marro</span>
                </a>
            </div>
            
            <!-- Lien conditionnel pour basculer entre connexion et inscription -->
            <div class="absolute top-6 right-6">
                @if (Route::currentRouteName() === 'login')
                    <a href="{{ route('register') }}" class="text-white hover:text-purple-200 transition duration-200">
                        S'inscrire
                    </a>
                @elseif (Route::currentRouteName() === 'register')
                    <a href="{{ route('login') }}" class="text-white hover:text-purple-200 transition duration-200">
                        Se connecter
                    </a>
                @else
                    <a href="{{ route('home') }}" class="text-white hover:text-purple-200 transition duration-200">
                        Accueil
                    </a>
                @endif
            </div>
            
            <!-- Contenu principal -->
            <main>
                {{ $slot }}
            </main>
            
            <!-- Pied de page -->
            <div class="mt-8 text-center text-sm text-gray-300">
                <p>&copy; {{ date('Y') }} Marro. Tous droits réservés.</p>
                <div class="mt-2 space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white transition duration-200">Conditions d'utilisation</a>
                    <a href="#" class="text-gray-300 hover:text-white transition duration-200">Politique de confidentialité</a>
                    <a href="#" class="text-gray-300 hover:text-white transition duration-200">Contact</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Particle.js pour les effets de particules -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <!-- Alpine.js pour les composants interactifs -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP pour les animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <!-- Script d'initialisation des animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialiser les particules
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
            
            // Animer les bulles flottantes
            const bubbles = document.querySelectorAll('.floating-bubble');
            bubbles.forEach((bubble, index) => {
                const size = Math.random() * 40 + 20; // Taille entre 20 et 60px
                const duration = Math.random() * 20 + 10; // Durée entre 10 et 30s
                const startX = Math.random() * 40 - 20; // Position X entre -20 et 20
                const startY = Math.random() * 40 - 20; // Position Y entre -20 et 20
                
                gsap.set(bubble, {
                    width: size,
                    height: size,
                    borderRadius: '50%',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    position: 'absolute',
                    top: `${Math.random() * 100}%`,
                    left: `${Math.random() * 100}%`,
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
            
            // Animation du formulaire d'authentification
            gsap.from('.auth-card', {
                y: 30,
                opacity: 0,
                duration: 0.8,
                ease: 'power3.out'
            });
        });
    </script>

    <!-- Page specific scripts -->
    @stack('scripts')
</body>
</html>