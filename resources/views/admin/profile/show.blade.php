<x-layouts.app :title="'Mon Profil | Administrateur'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour au tableau de bord
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mon Profil</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Vos informations personnelles</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Modifier mon profil
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mx-4 my-4 p-4 bg-green-50 dark:bg-green-900 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="border-t border-gray-200 dark:border-gray-700">
                    <div class="flex border-gray-200 dark:border-gray-700">
                        <div class="w-full md:w-1/3 border-r border-gray-200 dark:border-gray-700 p-6">
                            <div class="text-center">
                                <div class="relative mx-auto h-40 w-40 rounded-full overflow-hidden mb-4 bg-gray-200 dark:bg-gray-700">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->prenom }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-gray-300 dark:bg-gray-600 text-5xl font-bold text-white">
                                            {{ substr($user->prenom, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('admin.profile.avatar') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                    Modifier avatar
                                </a>
                            </div>
                        </div>
                        <div class="w-full md:w-2/3 p-6">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                                <div class="py-4 sm:py-5 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white sm:mt-0">{{ $user->nom }}</dd>
                                </div>
                                <div class="py-4 sm:py-5 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Prénom</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white sm:mt-0">{{ $user->prenom }}</dd>
                                </div>
                                <div class="py-4 sm:py-5 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adresse e-mail</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white sm:mt-0">{{ $user->email }}</dd>
                                </div>
                                <div class="py-4 sm:py-5 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rôle</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white sm:mt-0">
                                        @if($user->role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                {{ $user->role->role_name }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">Aucun rôle assigné</span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="py-4 sm:py-5 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Membre depuis</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white sm:mt-0">{{ $user->created_at->format('d/m/Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>