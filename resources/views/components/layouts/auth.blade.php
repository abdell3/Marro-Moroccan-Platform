@props(['title' => 'Authentification | Marro', 'heading' => 'Marro'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles personnalisés -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
        .auth-page {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }
        .auth-container {
            width: 100%;
            max-width: 460px;
            margin: 0 auto;
        }
        .auth-card {
            position: relative;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-top: 3rem;
        }
        .logo-circle {
            position: absolute;
            top: -2.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #8854d0 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .logo-circle svg {
            width: 2.5rem;
            height: 2.5rem;
            color: white;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- En-tête -->
        <header class="bg-white shadow-sm">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-8 h-8 mr-2">
                        <x-ui.logo />
                    </div>
                    <span class="font-bold text-xl text-gray-900">Marro</span>
                </a>
                
                <div>
                    @if (Route::currentRouteName() === 'login')
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Inscription
                        </a>
                    @elseif (Route::currentRouteName() === 'register')
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Connexion
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">
                            Accueil
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="auth-page">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="logo-circle">
                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5.69L17 10.19V18H15V12H9V18H7V10.19L12 5.69ZM12 3L2 12H5V20H11V14H13V20H19V12H22L12 3Z"/>
                        </svg>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-center mt-6 mb-6">{{ $heading }}</h1>
                    
                    {{ $slot }}
                </div>
            </div>
        </main>
        
        <!-- Pied de page -->
        <footer class="bg-white py-4 mt-auto border-t border-gray-200">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Marro. Tous droits réservés.</p>
                    <div class="mt-2 flex justify-center space-x-4">
                        <a href="#" class="text-xs text-gray-500 hover:text-gray-700">Conditions d'utilisation</a>
                        <a href="#" class="text-xs text-gray-500 hover:text-gray-700">Politique de confidentialité</a>
                        <a href="#" class="text-xs text-gray-500 hover:text-gray-700">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Alpine.js pour les composants interactifs -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>