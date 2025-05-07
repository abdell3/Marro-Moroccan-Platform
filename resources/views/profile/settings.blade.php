<x-layouts.app title="Préférences | Marro">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h2 class="text-xl font-medium text-gray-900">Préférences</h2>
                    <p class="mt-1 text-sm text-gray-500">Personnalisez votre expérience sur Marro</p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('profile.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Apparence -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Apparence</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="theme" class="block text-sm font-medium text-gray-700 mb-1">Thème</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <label class="flex items-center justify-center border-2 rounded-md p-3 cursor-pointer {{ auth()->user()->theme === 'light' ? 'bg-red-50 border-red-500' : 'border-gray-300' }}">
                                            <input type="radio" name="theme" value="light" class="sr-only" {{ auth()->user()->theme === 'light' ? 'checked' : '' }}>
                                            <div class="text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <span class="block mt-1 text-sm font-medium text-gray-700">Clair</span>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center justify-center border-2 rounded-md p-3 cursor-pointer {{ auth()->user()->theme === 'dark' ? 'bg-red-50 border-red-500' : 'border-gray-300' }}">
                                            <input type="radio" name="theme" value="dark" class="sr-only" {{ auth()->user()->theme === 'dark' ? 'checked' : '' }}>
                                            <div class="text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                                </svg>
                                                <span class="block mt-1 text-sm font-medium text-gray-700">Sombre</span>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center justify-center border-2 rounded-md p-3 cursor-pointer {{ auth()->user()->theme === 'system' ? 'bg-red-50 border-red-500' : 'border-gray-300' }}">
                                            <input type="radio" name="theme" value="system" class="sr-only" {{ auth()->user()->theme === 'system' ? 'checked' : '' }}>
                                            <div class="text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="block mt-1 text-sm font-medium text-gray-700">Système</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="mb-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Notifications</h3>
                            
                            <div class="space-y-4">
                                <x-form.checkbox 
                                    name="notifications_email" 
                                    label="Recevoir des notifications par e-mail" 
                                    :checked="auth()->user()->notifications_email" 
                                />
                                
                                <x-form.checkbox 
                                    name="notifications_posts" 
                                    label="Me notifier pour les réponses à mes posts" 
                                    :checked="auth()->user()->notifications_posts" 
                                />
                                
                                <x-form.checkbox 
                                    name="notifications_comments" 
                                    label="Me notifier pour les réponses à mes commentaires" 
                                    :checked="auth()->user()->notifications_comments" 
                                />
                                
                                <x-form.checkbox 
                                    name="notifications_follows" 
                                    label="Me notifier lorsque quelqu'un me suit" 
                                    :checked="auth()->user()->notifications_follows" 
                                />
                            </div>
                        </div>
                        
                        <!-- Langue -->
                        <div class="mb-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Langue</h3>
                            
                            <div class="max-w-xs">
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Langue préférée</label>
                                <select name="language" id="language" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                                    <option value="fr" {{ auth()->user()->language === 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ auth()->user()->language === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="es" {{ auth()->user()->language === 'es' ? 'selected' : '' }}>Español</option>
                                    <option value="de" {{ auth()->user()->language === 'de' ? 'selected' : '' }}>Deutsch</option>
                                    <option value="it" {{ auth()->user()->language === 'it' ? 'selected' : '' }}>Italiano</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Confidentialité -->
                        <div class="mb-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Confidentialité</h3>
                            
                            <div class="space-y-4">
                                <x-form.checkbox 
                                    name="privacy_profile" 
                                    label="Autoriser d'autres utilisateurs à voir mon profil" 
                                    :checked="auth()->user()->privacy_profile" 
                                />
                                
                                <x-form.checkbox 
                                    name="privacy_activity" 
                                    label="Afficher mon activité aux autres utilisateurs" 
                                    :checked="auth()->user()->privacy_activity" 
                                />
                                
                                <x-form.checkbox 
                                    name="privacy_online" 
                                    label="Afficher mon statut en ligne" 
                                    :checked="auth()->user()->privacy_online" 
                                />
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-5 border-t border-gray-200 flex justify-between">
                            <x-ui.button 
                                type="button" 
                                variant="outline" 
                                tag="a"
                                href="{{ route('profile.show') }}"
                            >
                                Annuler
                            </x-ui.button>
                            
                            <x-ui.button type="submit" variant="primary">
                                Enregistrer les préférences
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>