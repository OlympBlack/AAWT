<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes de') }} {{ $student->firstname }} {{ $student->lastname }} - {{ $classroom->wording }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Succès!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Erreur!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <h3 class="text-lg font-semibold mb-4">Semestre actif : {{ $currentSemester->semester->wording }}</h3>
                
                @foreach ($subjects as $subject)
                    <div class="mb-8 p-4 border rounded">
                        <h3 class="text-lg font-semibold mb-4">{{ $subject->wording }}</h3>

                        @foreach ($noteTypes as $noteType)
                            <div class="mb-4">
                                <h4 class="text-md font-semibold">{{ $noteType->wording }}</h4>
                                @if(isset($notes[$subject->id][$noteType->id]))
                                    @foreach($notes[$subject->id][$noteType->id] as $note)
                                        <form action="{{ route('teacher.update-note', $note) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="value" value="{{ $note->value }}" min="0" max="20" step="0.01" class="border rounded px-2 py-1">
                                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Modifier</button>
                                        </form>
                                        <form action="{{ route('teacher.delete-note', $note) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                                        </form>
                                    @endforeach
                                @else
                                    <p>Pas de note</p>
                                @endif
                                <form action="{{ route('teacher.store-note') }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <input type="hidden" name="note_type_id" value="{{ $noteType->id }}">
                                    <input type="hidden" name="school_year_semester_id" value="{{ $currentSemester->id }}">
                                    <input type="number" name="value" min="0" max="20" step="0.01" required class="border rounded px-2 py-1">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Ajouter une note</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
