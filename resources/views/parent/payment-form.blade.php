<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulaire de paiement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($canPay)
                    <form method="POST" action="{{ route('parent.process-payment', $registration->id) }}">
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
                        @csrf
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Récapitulatif</h3>
                            <p class="text-gray-600">Montant total de la scolarité : <span class="font-semibold">{{ number_format($registration->classroom->costs, 0, ',', ' ') }} FCFA</span></p>
                            <p class="text-gray-600">Montant restant à payer : <span class="font-semibold">{{ number_format($remainingAmount, 0, ',', ' ') }} FCFA</span></p>
                        </div>

                        <div class="mb-4">
                            <label for="payment_mode" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
                            <select name="payment_type_id" id="payment_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="1">Paiement total</option>
                                <option value="2">Paiement par tranches</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Montant à payer</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="amount" id="amount" class="block w-full pr-12 border-gray-300 rounded-md" readonly>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">FCFA</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="payment_mode_id" class="block text-sm font-medium text-gray-700">Moyen de paiement</label>
                            <select name="payment_mode_id" id="payment_mode_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach($paymentModes as $mode)
                                    <option value="{{ $mode->id }}">{{ $mode->wording }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-button class="ml-4">
                                {{ __('Effectuer le paiement') }}
                            </x-button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const paymentModeSelect = document.getElementById('payment_mode');
                            const amountInput = document.getElementById('amount');
                            const totalAmount = {{ $registration->classroom->costs }};
                            const remainingAmount = {{ $remainingAmount }};
                            const paymentCount = {{ $registration->payments->count() }};
                    
                            function updateAmount() {
                                const mode = paymentModeSelect.value;
                                let amount = remainingAmount;
                    
                                if (mode === '2') {
                                    if (paymentCount === 0) {
                                        amount = Math.ceil(totalAmount / 3);
                                    } else if (paymentCount === 1) {
                                        amount = Math.ceil(remainingAmount / 2);
                                    } else {
                                        amount = remainingAmount;
                                    }
                    
                                    if (amount > remainingAmount) {
                                        amount = remainingAmount;
                                    }
                                }
                    
                                amountInput.value = new Intl.NumberFormat('fr-FR').format(amount);
                            }
                    
                            paymentModeSelect.addEventListener('change', updateAmount);
                            updateAmount(); // Calcul initial
                        });
                    </script>
                @else
                    <p>La scolarité a été entièrement payée. Aucun paiement supplémentaire n'est nécessaire.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>