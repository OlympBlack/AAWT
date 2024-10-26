<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Classes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @foreach($classrooms as $classroom)
                    <div class="mb-4 p-4 border rounded">
                        <h3 class="text-lg font-semibold">{{ $classroom->wording }} {{ $classroom->serie->wording }}</h3>
                        <a href="{{ route('teacher.class.students', $classroom) }}" class="mt-2 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">
                            Voir les étudiants
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

