<x-layouts.auth 
    title="Inscription | Marro" 
    heading="Créer un compte"
>
    <form method="POST" action="{{ route('register') }}" class="mt-6">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input 
                type="text" 
                id="nom" 
                name="nom" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500"
                value="{{ old('nom') }}" 
                required 
                autocomplete="family-name" 
                autofocus
            >
            @error('nom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
            <input 
                type="text" 
                id="prenom" 
                name="prenom" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500"
                value="{{ old('prenom') }}" 
                required 
                autocomplete="given-name"
            >
            @error('prenom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

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
                autocomplete="new-password"
            >
            <p class="mt-1 text-xs text-gray-500">8 caractères minimum</p>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500"
                required 
                autocomplete="new-password"
            >
        </div>

        <div class="mb-6">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                        required
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-700">
                        J'accepte les <a href="#" class="text-red-600 hover:text-red-500">conditions d'utilisation</a> et la <a href="#" class="text-red-600 hover:text-red-500">politique de confidentialité</a>
                    </label>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
                S'inscrire
            </button>
        </div>
    </form>
    
    <div class="mt-6 text-center text-sm text-gray-500">
        Vous avez déjà un compte? <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">Se connecter</a>
    </div>
</x-layouts.auth>