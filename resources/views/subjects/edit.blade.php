<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la matière') }}
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
                <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <x-label for="wording" value="{{ __('Libellé') }}" />
                        <x-input id="wording" class="block mt-1 w-full" type="text" name="wording"
                            :value="$subject->wording" required autofocus />
                    </div>
                    <div class="mb-4">
                        <x-label for="coefficient" value="{{ __('Coefficient') }}" />
                        <x-input id="coefficient" class="block mt-1 w-full" type="number" name="coefficient"
                            :value="$subject->coefficient" required step="0.1" min="0" />
                    </div>
                    <div class="mb-4">
                        <x-label for="classroom_id" value="{{ __('Classe') }}" />
                        <select id="classroom_id" name="classroom_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}"
                                    {{ $subject->classroom_id == $classroom->id ? 'selected' : '' }}>
                                    {{ $classroom->wording }} {{ $classroom->serie->wording }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <x-label for="teacher_id" value="{{ __('Professeur') }}" />
                        <select id="teacher_id" name="teacher_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="">Sélectionner un professeur</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ $subject->teachers->contains($teacher->id) ? 'selected' : '' }}>
                                    {{ $teacher->firstname }} {{ $teacher->lastname }}
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
