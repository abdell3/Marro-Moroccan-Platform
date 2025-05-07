<x-layouts.auth 
    title="Connexion | Marro" 
    heading="Connexion à votre compte"
>
    <form method="POST" action="{{ route('login') }}" class="mt-6">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500"
                value="{{ old('email') }}" 
                required 
                autocomplete="email" 
                autofocus
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500"
                required 
                autocomplete="current-password"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center mb-4">
            <input 
                type="checkbox" 
                id="remember" 
                name="remember" 
                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                {{ old('remember') ? 'checked' : '' }}
            >
            <label for="remember" class="ml-2 block text-sm text-gray-700">
                Se souvenir de moi
            </label>
        </div>

        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
                Se connecter
            </button>
        </div>
    </form>
    
    <div class="mt-6 text-center text-sm text-gray-500">
        Pas encore de compte? <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">Inscrivez-vous</a>
    </div>
</x-layouts.auth>