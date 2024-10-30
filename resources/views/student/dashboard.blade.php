<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord étudiant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h3>
                
                <!-- Cartes statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <!-- Moyenne générale -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Moyenne Générale</h6>
                                <div class="flex items-center">
                                    <h5 class="text-xl font-semibold text-gray-400">Coming Soon</h5>
                                    <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                                </div>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/books.svg') }}" alt="moyenne" class="h-12 w-12 opacity-50">
                            </div>
                        </div>
                    </div>

                    <!-- Présence -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Taux de Présence</h6>
                                <div class="flex items-center">
                                    <h5 class="text-xl font-semibold text-gray-400">Coming Soon</h5>
                                    <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                                </div>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-01.svg') }}" alt="présence" class="h-12 w-12 opacity-50">
                            </div>
                        </div>
                    </div>

                    <!-- Devoirs à rendre -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Devoirs à rendre</h6>
                                <div class="flex items-center">
                                    <h5 class="text-xl font-semibold text-gray-400">Coming Soon</h5>
                                    <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                                </div>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-03.svg') }}" alt="devoirs" class="h-12 w-12 opacity-50">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sections principales -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Emploi du temps -->
                    <div class="bg-white p-4 rounded-lg shadow border">
                        <h4 class="text-lg font-semibold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Emploi du temps
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                        </h4>
                        <div class="text-gray-500 text-center py-8">
                            L'emploi du temps sera bientôt disponible
                        </div>
                    </div>

                    <!-- Notes récentes -->
                    <div class="bg-white p-4 rounded-lg shadow border">
                        <h4 class="text-lg font-semibold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Notes récentes
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                        </h4>
                        <div class="text-gray-500 text-center py-8">
                            Les notes seront bientôt disponibles
                        </div>
                    </div>

                    <!-- Devoirs à venir -->
                    <div class="bg-white p-4 rounded-lg shadow border">
                        <h4 class="text-lg font-semibold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Devoirs à venir
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                        </h4>
                        <div class="text-gray-500 text-center py-8">
                            La liste des devoirs sera bientôt disponible
                        </div>
                    </div>

                    <!-- Messagerie -->
                    <div class="bg-white p-4 rounded-lg shadow border">
                        <h4 class="text-lg font-semibold mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Messagerie
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Bientôt disponible</span>
                        </h4>
                        <div class="text-gray-500 text-center py-8">
                            La messagerie sera bientôt disponible
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>