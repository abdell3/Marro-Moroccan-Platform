<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Marro') }}</title>

    <!-- Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Page specific styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased h-full bg-gray-100 text-gray-900">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-gray-100 to-gray-200">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-r from-purple-600 to-blue-500 flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5.69L17 10.19V18H15V12H9V18H7V10.19L12 5.69ZM12 3L2 12H5V20H11V14H13V20H19V12H22L12 3Z"/>
                    </svg>
                </div>
                <h1 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ $heading ?? 'Marro' }}</h1>
            </div>

            <!-- Main content -->
            {{ $slot }}

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Marro. Tous droits réservés.</p>
                <div class="mt-2 flex justify-center space-x-4">
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Conditions d'utilisation</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Politique de confidentialité</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Contact</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Page specific scripts -->
    @stack('scripts')
</body>
</html>