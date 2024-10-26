<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes de') }} {{ $student->firstname }} {{ $student->lastname }} - {{ $classroom->wording }}
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
                                            <input type="number" name="value" value="{{ $note->value }}" min="0" max="20" step="0.01">
                                            <button type="submit">Modifier</button>
                                        </form>
                                        <form action="{{ route('teacher.delete-note', $note) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</button>
                                        </form>
                                    @endforeach
                                @else
                                    <p>Pas de note</p>
                                @endif
                                <form action="{{ route('teacher.store-note') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <input type="hidden" name="note_type_id" value="{{ $noteType->id }}">
                                    <input type="hidden" name="school_year_semester_id" value="{{ $currentSemester->id }}">
                                    <input type="number" name="value" min="0" max="20" step="0.01" required>
                                    <button type="submit">Ajouter une note</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
