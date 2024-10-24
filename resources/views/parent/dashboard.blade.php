<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord parental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Contenu du tableau de bord utilisateur personnalisé -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }} !</h3>
                    <!-- Ajoutez ici le contenu spécifique pour les utilisateurs non-administrateurs -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>