<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord parent') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h3>
                
                <div class="mb-6">
                    <h4 class="text-md font-semibold mb-2">Actions rapides</h4>
                    <a href="{{ route('parent.register-student') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        Inscrire un élève
                    </a>
                </div>

                <div class="mb-6">
                    <h4 class="text-md font-semibold mb-2">Mes enfants (élèves inscrits)</h4>
                    @forelse(auth()->user()->children as $child)
                        @php
                            $registration = $child->registrations->last();
                        @endphp
                        @if($registration)
                            <div class="mb-4 p-4 border rounded flex justify-between items-center">
                                <div>
                                    <p><strong>Nom :</strong> {{ $child->firstname }} {{ $child->lastname }}</p>
                                    <p><strong>Classe :</strong> {{ $registration->classroom->wording }} {{ $registration->classroom->serie->wording }}</p>
                                    <p><strong>Année scolaire :</strong> {{ $registration->schoolYear->wording }}</p>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <a href="{{ route('parent.registration-form', $registration->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Fiche d'inscription
                                    </a>
                                
                                    <a href="{{ route('parent.payment-form', $registration->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Paiement
                                    </a>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>Aucun élève inscrit pour le moment.</p>
                    @endforelse
                </div>

                <div>
                    <h4 class="text-md font-semibold mb-2">Notifications récentes</h4>
                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                        <div class="mb-2 p-2 {{ $notification->read_at ? 'bg-gray-100' : 'bg-yellow-100' }} rounded">
                            @if(isset($notification->data['message']))
                                <p>{{ $notification->data['message'] }}</p>
                            @else
                                <p>{{ $notification->type }}</p>
                            @endif
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p>Aucune notification récente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
