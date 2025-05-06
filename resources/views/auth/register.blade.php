<x-layouts.auth title="Inscription | Marro">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-purple-900 via-purple-800 to-blue-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-6">
                <x-ui.logo class="w-20 h-20" />
            </div>
            
            <h2 class="text-center text-2xl font-bold text-gray-900 dark:text-white mb-6">Créez votre compte Marro</h2>

            <!-- Validation Errors -->
            <x-ui.alert :message="$errors->first()" type="error" class="mb-4" />

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf

                <!-- Nom -->
                <div>
                    <x-ui.input
                        id="nom"
                        type="text"
                        name="nom"
                        :value="old('nom')"
                        placeholder="Nom"
                        required
                        autofocus
                        icon="user"
                    />
                </div>

                <!-- Prénom -->
                <div>
                    <x-ui.input
                        id="prenom"
                        type="text"
                        name="prenom"
                        :value="old('prenom')"
                        placeholder="Prénom"
                        required
                        icon="user"
                    />
                </div>

                <!-- Email Address -->
                <div>
                    <x-ui.input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        placeholder="Email"
                        required
                        icon="mail"
                    />
                </div>

                <!-- Password -->
                <div>
                    <x-ui.input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Mot de passe"
                        required
                        icon="lock"
                        togglePassword
                    />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-ui.input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirmer le mot de passe"
                        required
                        icon="lock"
                        togglePassword
                    />
                </div>

                <!-- Terms and Conditions -->
                <div>
                    <label for="terms" class="inline-flex items-center">
                        <x-ui.checkbox id="terms" name="terms" :checked="old('terms')" required />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            J'accepte les <a href="#" class="underline text-purple-600 dark:text-blue-400 hover:text-purple-800 dark:hover:text-blue-500">conditions d'utilisation</a> et la <a href="#" class="underline text-purple-600 dark:text-blue-400 hover:text-purple-800 dark:hover:text-blue-500">politique de confidentialité</a>
                        </span>
                    </label>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-ui.button type="submit" class="w-full">
                        S'inscrire
                    </x-ui.button>
                </div>
                
                <div class="flex items-center justify-center mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                        Déjà inscrit?
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ajout d'animations spécifiques à la page d'inscription
            gsap.from('#nom, #prenom, #email, #password, #password_confirmation, #terms', {
                y: 20,
                opacity: 0,
                stagger: 0.1,
                duration: 0.6,
                delay: 0.5,
                ease: 'power2.out'
            });
        });
    </script>
    @endpush
</x-layouts.auth>