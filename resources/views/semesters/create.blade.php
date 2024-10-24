<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouveau semestre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('semesters.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-label for="wording" value="{{ __('Semestre') }}" />
                        <x-input id="wording" class="block mt-1 w-full" type="text" name="wording" :value="old('wording')" required autofocus />
                    </div>
                    <div class="mb-4">
                        <x-label for="school_years" value="{{ __('Années scolaires') }}" />
                        <select id="school_years" name="school_years[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" multiple>
                            <option value="">Sélectionner une année scolaire</option>
                            @foreach($schoolYears as $schoolYear)
                                <option value="{{ $schoolYear->id }}">{{ $schoolYear->wording }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Créer') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

