<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la salle de classe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <x-label for="wording" value="{{ __('Libellé') }}" />
                        <x-input id="wording" class="block mt-1 w-full" type="text" name="wording" :value="$classroom->wording" required autofocus />
                    </div>
                    <div class="mb-4">
                        <x-label for="costs" value="{{ __('Coûts') }}" />
                        <x-input id="costs" class="block mt-1 w-full" type="number" name="costs" :value="$classroom->costs" required step="0.01" />
                    </div>
                    <div class="mb-4">
                        <x-label for="serie_id" value="{{ __('Série') }}" />
                        <select id="serie_id" name="serie_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            @foreach($series as $serie)
                                <option value="{{ $serie->id }}" {{ $classroom->serie_id == $serie->id ? 'selected' : '' }}>
                                    {{ $serie->wording }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Mettre à jour') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
