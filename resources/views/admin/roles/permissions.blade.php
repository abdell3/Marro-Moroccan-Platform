<x-layouts.app :title="'Permissions du rôle ' . $role->role_name . ' | Admin'">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <a href="{{ route('admin.roles.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour à la liste des rôles
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                        Gérer les permissions
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                        Attribuez des permissions au rôle {{ $role->role_name }}
                    </p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 dark:bg-red-900 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Veuillez corriger les erreurs suivantes:</h3>
                                    <ul class="mt-2 list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li class="text-sm text-red-700 dark:text-red-300">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.roles.permissions.update', $role) }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">Sélectionnez les permissions</h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cochez les permissions que vous souhaitez attribuer à ce rôle.</p>
                                
                                <div class="mt-4 flex justify-end mb-4">
                                    <button type="button" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" onclick="document.querySelectorAll('input[type=checkbox]').forEach(el => el.checked = true)">
                                        Sélectionner tout
                                    </button>
                                    <span class="mx-2 text-gray-500">|</span>
                                    <button type="button" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" onclick="document.querySelectorAll('input[type=checkbox]').forEach(el => el.checked = false)">
                                        Désélectionner tout
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id }}" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded" {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="permission_{{ $permission->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $permission->name }}</label>
                                                @if($permission->description)
                                                    <p class="text-gray-500 dark:text-gray-400">{{ $permission->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.roles.show', $role) }}" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Annuler
                                </a>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Enregistrer les permissions
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>