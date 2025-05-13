<x-layouts.app :title="'Modifier mon avatar | Administrateur'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <a href="{{ route('admin.profile.show') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour à mon profil
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier mon avatar</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Téléchargez une nouvelle image de profil</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
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

                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/3 mb-6 md:mb-0 md:pr-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Avatar actuel</h3>
                            <div class="relative mx-auto h-40 w-40 rounded-full overflow-hidden mb-4 bg-gray-200 dark:bg-gray-700">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->prenom }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-gray-300 dark:bg-gray-600 text-5xl font-bold text-white">
                                        {{ substr($user->prenom, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="w-full md:w-2/3 md:pl-6 md:border-l md:border-gray-200 md:dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Télécharger un nouvel avatar</h3>
                            
                            <form method="POST" action="{{ route('admin.profile.avatar.update') }}" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600" required accept="image/*">
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formats acceptés : JPG, PNG, GIF. Taille maximale : 2 Mo.</p>
                                </div>

                                <div class="pt-5">
                                    <div class="flex justify-end">
                                        <a href="{{ route('admin.profile.show') }}" class="py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Annuler
                                        </a>
                                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>