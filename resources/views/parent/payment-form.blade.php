<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulaire de paiement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>
            
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                @if($canPay)
                    <form method="POST" action="{{ route('parent.process-payment', $registration->id) }}">
                        @csrf
                        <div class="mb-4">
                            <p>Montant total de la scolarité : {{ $registration->classroom->costs }} FCFA</p>
                            <p>Montant restant à payer : {{ $remainingAmount }} FCFA</p>
                        </div>
                        <div class="mb-4">
                            <label for="payment_mode" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
                            <select name="payment_mode" id="payment_mode" class="mt-1 block w-full" required>
                                <option value="total">Paiement total</option>
                                <option value="tranche">Paiement par tranches</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Montant</label>
                            <input type="number" name="amount" id="amount" class="mt-1 block w-full" readonly required value="{{ $remainingAmount }}">
                            
                        </div>
                        <div class="mb-4">
                            <label for="payment_type_id" class="block text-sm font-medium text-gray-700">Type de paiement</label>
                            <select name="payment_type_id" id="payment_type_id" class="mt-1 block w-full" required>
                                @foreach($paymentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->wording }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="payment_mode_id" class="block text-sm font-medium text-gray-700">Moyen de paiement</label>
                            <select name="payment_mode_id" id="payment_mode_id" class="mt-1 block w-full" required>
                                @foreach($paymentModes as $mode)
                                    <option value="{{ $mode->id }}">{{ $mode->wording }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Effectuer le paiement') }}
                            </x-button>
                        </div>
                    </form>
                @else
                    <p>La scolarité a été entièrement payée. Aucun paiement supplémentaire n'est nécessaire.</p>
                @endif
            </div>
        </div>
    </div>


</x-app-layout>
