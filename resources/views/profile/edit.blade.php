<x-layouts.app title="Modifier mon profil | Marro">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier mon profil</h1>
            <p class="text-gray-600 dark:text-gray-400">Mettez à jour vos informations personnelles</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', Auth::user()->nom) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prénom -->
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', Auth::user()->prenom) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Préférences -->
                <div class="mb-6">
                    <label for="preferences" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Préférences</label>
                    <textarea name="preferences" id="preferences" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('preferences', Auth::user()->preferences) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Partagez un peu plus sur vos centres d'intérêt et vos préférences</p>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('profile.show') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Avatar -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Photo de profil</h2>
                
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <img class="h-24 w-24 rounded-full" src="{{ asset(Auth::user()->avatar ?? 'avatars/default.png') }}" alt="{{ Auth::user()->nom }}">
                    </div>
                    <div class="ml-6">
                        <a href="{{ route('profile.avatar') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Changer d'avatar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sécurité -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Sécurité</h2>
                
                <p class="text-gray-600 dark:text-gray-400 mb-4">La fonctionnalité de changement de mot de passe sera disponible prochainement.</p>
                
                <button disabled class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500 dark:border-gray-600">
                    Changer de mot de passe
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>