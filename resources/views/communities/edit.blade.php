<x-layouts.app :title="'Modifier ' . $community->theme_name . ' | Marro'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                @if(request()->is('moderator/*'))
                <a href="{{ route('moderator.communities.show', $community) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                @else
                <a href="{{ route('communities.show', $community) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                @endif
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour à la communauté
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier la communauté</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Mettez à jour les informations de votre communauté.</p>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Veuillez corriger les erreurs suivantes :</h3>
                                    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->is('moderator/*'))
                    <form method="POST" action="{{ route('moderator.communities.update', $community) }}" enctype="multipart/form-data" class="space-y-6">
                    @else
                    <form method="POST" action="{{ route('communities.update', $community) }}" enctype="multipart/form-data" class="space-y-6">
                    @endif
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="theme_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom de la communauté <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="theme_name" id="theme_name" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500" value="{{ old('theme_name', $community->theme_name) }}" required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Le nom doit être unique et descriptif (maximum 100 caractères).</p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description de la communauté</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="4" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('description', $community->description) }}</textarea>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Décrivez votre communauté en quelques phrases pour que les membres potentiels comprennent son but.</p>
                        </div>

                        <div>
                            <label for="rules" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Règles de la communauté</label>
                            <div class="mt-1">
                                <textarea id="rules" name="rules" rows="4" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('rules', $community->rules) }}</textarea>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Définissez les règles que les membres doivent suivre pour participer à votre communauté.</p>
                        </div>

                        <div>
                            <label for="icon_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icône de la communauté</label>
                            <div class="mt-1 flex items-center">
                                @if($community->icon)
                                    <img src="{{ asset($community->icon) }}" alt="{{ $community->theme_name }}" class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700">
                                        <svg class="h-full w-full text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                @endif
                                <input type="file" name="icon_file" id="icon_file" class="ml-5 py-2 px-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Téléchargez une nouvelle image pour remplacer l'icône actuelle. Laissez vide pour conserver l'icône actuelle.</p>
                        </div>

                        <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-end">
                                @if(request()->is('moderator/*'))
                                <a href="{{ route('moderator.communities.show', $community) }}" class="py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                @else
                                <a href="{{ route('communities.show', $community) }}" class="py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                @endif
                                    Annuler
                                </a>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
