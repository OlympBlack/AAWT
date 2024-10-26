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
                            <div class="mb-4 p-4 border rounded">
                                <p><strong>Nom :</strong> {{ $child->firstname }} {{ $child->lastname }}</p>
                                <p><strong>Classe :</strong> {{ $registration->classroom->wording }}</p>
                                <p><strong>Année scolaire :</strong> {{ $registration->schoolYear->wording }}</p>
                                <div class="mt-2">
                                    <a href="{{ route('parent.registration-form', $registration->id) }}" class="text-blue-600 hover:text-blue-800">Télécharger la fiche d'inscription</a>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('parent.payment-form', $registration->id) }}" class="text-green-600 hover:text-green-800">Effectuer un paiement</a>
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
