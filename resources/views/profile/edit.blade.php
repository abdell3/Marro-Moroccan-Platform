<x-layouts.app title="Modifier le profil | Marro">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h2 class="text-xl font-medium text-gray-900">Modifier le profil</h2>
                    <p class="mt-1 text-sm text-gray-500">Mettez à jour vos informations personnelles</p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-form.input 
                                    name="prenom" 
                                    label="Prénom" 
                                    :value="auth()->user()->prenom" 
                                    required 
                                />
                            </div>
                            
                            <div>
                                <x-form.input 
                                    name="nom" 
                                    label="Nom" 
                                    :value="auth()->user()->nom" 
                                    required 
                                />
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-form.input 
                                    name="email" 
                                    type="email" 
                                    label="Adresse e-mail" 
                                    :value="auth()->user()->email" 
                                    required 
                                />
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-form.input 
                                    name="username" 
                                    label="Nom d'utilisateur" 
                                    :value="auth()->user()->username" 
                                    required 
                                />
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-form.textarea 
                                    name="bio" 
                                    label="Biographie" 
                                    :value="auth()->user()->bio" 
                                    help="Parlez un peu de vous (max. 200 caractères)"
                                />
                            </div>
                            
                            <div class="md:col-span-2 border-t border-gray-200 pt-5">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de notification</h3>
                                
                                <div class="space-y-4">
                                    <x-form.checkbox 
                                        name="notifications_email" 
                                        label="Recevoir des notifications par e-mail" 
                                        :checked="auth()->user()->notifications_email" 
                                    />
                                    
                                    <x-form.checkbox 
                                        name="notifications_posts" 
                                        label="Notifications pour les réponses à mes posts" 
                                        :checked="auth()->user()->notifications_posts" 
                                    />
                                    
                                    <x-form.checkbox 
                                        name="notifications_comments" 
                                        label="Notifications pour les réponses à mes commentaires" 
                                        :checked="auth()->user()->notifications_comments" 
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-5 flex justify-between">
                            <x-ui.button 
                                type="button" 
                                variant="outline" 
                                tag="a"
                                href="{{ route('profile.show') }}"
                            >
                                Annuler
                            </x-ui.button>
                            
                            <x-ui.button type="submit" variant="primary">
                                Enregistrer les modifications
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-8 bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h2 class="text-xl font-medium text-gray-900">Sécurité du compte</h2>
                    <p class="mt-1 text-sm text-gray-500">Mettez à jour votre mot de passe</p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <x-form.input 
                                name="current_password" 
                                type="password" 
                                label="Mot de passe actuel" 
                                required 
                            />
                            
                            <x-form.input 
                                name="password" 
                                type="password" 
                                label="Nouveau mot de passe" 
                                required 
                            />
                            
                            <x-form.input 
                                name="password_confirmation" 
                                type="password" 
                                label="Confirmez le nouveau mot de passe" 
                                required 
                            />
                        </div>
                        
                        <div class="mt-6">
                            <x-ui.button type="submit" variant="primary">
                                Mettre à jour le mot de passe
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>