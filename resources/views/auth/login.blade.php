<x-guest-layout>
    <div class="w-full flex items-center justify-center">
        <div class="shadow-2xl flex flex-col md:flex-row w-full md:w-3/4 mx-auto" style="min-height: 90vh; margin: 5vh 0;">
            <div class="hidden md:flex md:w-1/2 fd-bg-secondary justify-center items-center login-image">
                <img src="{{ asset('images/login.png')}}" alt="Image enfant" class="w-full h-full rounded-lg">
            </div>
            <div class="w-full md:w-1/2 bg-white px-8 md:px-12 py-8 rounded-lg">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/myschoologos.png')}}" alt="Logo MySchoolManager" class="mx-auto mb-4 logo-image">
                    <h2 class="text-2xl font-semibold">Connexion à MySchoolManager</h2>
                    <p class="text-gray-600">Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="text-blue-500">S'inscrire</a></p>
                </div>

                <x-validation-errors class="mb-2" />

                {{-- @if (session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif --}}

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Mot de passe') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-4 text-center">
                        <x-button class="fd-bg-secondary w-full flex items-center justify-center">
                            {{ __('Se connecter') }}
                        </x-button>
                    </div>
                </form>

                <div class="flex items-center justify-center my-3">
                    <span class="w-full border-t"></span>
                    <span class="px-4 text-gray-500">OU</span>
                    <span class="w-full border-t"></span>
                </div>

                <div class="flex flex-wrap gap-3 justify-center mt-3">
                    <div><i class="mdi mdi-google-plus bg-gray-200 py-1 px-2 border border-gray-300 rounded-lg shadow"></i></div>
                    <div><i class="mdi mdi-facebook bg-gray-200 py-1 px-2 border border-gray-300 rounded-lg shadow"></i></div>
                    <div><i class="mdi mdi-twitter bg-gray-200 py-1 px-2 border border-gray-300 rounded-lg shadow"></i></div>
                    <div><i class="mdi mdi-instagram bg-gray-200 py-1 px-2 border border-gray-300 rounded-lg shadow"></i></div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
