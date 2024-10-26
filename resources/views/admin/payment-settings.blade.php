<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paramètres de paiement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Modes de paiement</h3>
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
                <form method="POST" action="{{ route('admin.payment-modes.store') }}" class="mb-4">
                    @csrf
                    <div class="flex items-center">
                        <input type="text" name="wording" placeholder="Nouveau mode de paiement" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 fd-bg border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-100 active:bg-blue-100 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Ajouter</button>
                    </div>
                </form>
                <ul>
                    @foreach($paymentModes as $mode)
                        <li class="flex justify-between items-center mb-2">
                            {{ $mode->wording }}
                            <form method="POST" action="{{ route('admin.payment-modes.destroy', $mode) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                <h3 class="text-lg font-semibold mb-4 mt-8">Types de paiement</h3>
                <form method="POST" action="{{ route('admin.payment-types.store') }}" class="mb-4">
                    @csrf
                    <div class="flex items-center">
                        <input type="text" name="wording" placeholder="Nouveau type de paiement" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        <select name="is_partial" class="form-select rounded-md shadow-sm mt-1 block ml-2" required>
                            <option value="0">Paiement total</option>
                            <option value="1">Paiement partiel</option>
                        </select>
                        <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 fd-bg border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Ajouter</button>
                    </div>
                </form>
                <ul>
                    @foreach($paymentTypes as $type)
                        <li class="flex justify-between items-center mb-2">
                            {{ $type->wording }}
                            <form method="POST" action="{{ route('admin.payment-types.destroy', $type) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
