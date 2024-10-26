<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Étudiants de la classe') }} {{ $classroom->wording }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @foreach($registrations as $registration)
                    <div class="mb-4 p-4 border rounded">
                        <h3 class="text-lg font-semibold">{{ $registration->student->firstname }} {{ $registration->student->lastname }}</h3>
                        <a href="{{ route('teacher.student.notes', ['classroom' => $classroom->id, 'student' => $registration->student->id]) }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                            Gérer les notes
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
