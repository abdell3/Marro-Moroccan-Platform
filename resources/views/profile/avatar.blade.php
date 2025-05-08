<x-layouts.app title="Changer d'avatar | Marro">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Changer d'avatar</h1>
            <p class="text-gray-600 dark:text-gray-400">Téléchargez une nouvelle photo de profil</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Avatar actuel</label>
                    <div class="flex justify-center">
                        <img class="h-32 w-32 rounded-full" src="{{ asset(Auth::user()->avatar ?? 'avatars/default.png') }}" alt="{{ Auth::user()->nom }}">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nouvel avatar</label>
                    <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, GIF (max 2MB)</p>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('profile.edit') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>