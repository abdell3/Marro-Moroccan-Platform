<x-layouts.auth title="Connexion | Marro">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-purple-900 via-purple-800 to-blue-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-8">
                <x-ui.logo class="w-20 h-20" />
            </div>
            
            <h2 class="text-center text-2xl font-bold text-gray-900 dark:text-white mb-8">Connexion à Marro</h2>
            
            <!-- Session Status -->
            <x-ui.alert :message="session('status')" class="mb-4" />

            <!-- Validation Errors -->
            <x-ui.alert :message="$errors->first()" type="error" class="mb-4" />

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-ui.input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        placeholder="Email"
                        required
                        autofocus
                        icon="mail"
                    />
                </div>

                <!-- Password -->
                <div class="mt-4">
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

                <!-- Remember Me -->
                <div class="mt-4 flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <x-ui.checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                    </label>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-ui.button type="submit" class="w-full">
                        Se connecter
                    </x-ui.button>
                </div>
                
                <div class="flex items-center justify-center mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('register') }}">
                        Pas encore inscrit?
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>