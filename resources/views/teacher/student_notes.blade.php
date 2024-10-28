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

                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-semibold">
                            Semestre : {{ $currentSemester->semester->wording }}
                            @if(!$currentSemester->is_active)
                                <span class="text-red-600 ml-2">(Semestre clôturé)</span>
                            @endif
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($currentSemester->is_active)
                                Les notes peuvent être ajoutées, modifiées ou supprimées
                            @else
                                Les notes ne peuvent plus être modifiées
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <!-- Colonne des notes (2/3 de l'espace) -->
                    <div class="col-span-2">
                        @foreach ($subjects as $subject)
                            <div class="mb-8 p-4 border rounded">
                                <h3 class="text-lg font-semibold mb-4">{{ $subject->wording }}</h3>

                                @foreach ($noteTypes as $noteType)
                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="text-md font-semibold">{{ $noteType->wording }}</h4>
                                            @php
                                                $noteCount = isset($notes[$subject->id][$noteType->id]) ? count($notes[$subject->id][$noteType->id]) : 0;
                                                $maxNotes = $noteType->wording === 'Interrogation' ? 3 : 2;
                                                $remainingNotes = $maxNotes - $noteCount;
                                            @endphp
                                            <span class="text-sm {{ $noteCount === $maxNotes ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $noteCount }}/{{ $maxNotes }} notes
                                                @if($noteCount < $maxNotes && $currentSemester->is_active)
                                                    ({{ $remainingNotes }} note(s) restante(s))
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Affichage des notes existantes -->
                                        @if(isset($notes[$subject->id][$noteType->id]))
                                            <div class="space-y-2 mb-4">
                                                @foreach($notes[$subject->id][$noteType->id] as $index => $note)
                                                    <div class="flex items-center space-x-2 bg-gray-50 p-2 rounded">
                                                        <span class="text-gray-600 w-24">Note {{ $index + 1 }}:</span>
                                                        <form action="{{ route('teacher.update-note', $note) }}" method="POST" class="flex items-center space-x-2">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="number" 
                                                                   name="value" 
                                                                   value="{{ $note->value }}" 
                                                                   min="0" 
                                                                   max="20" 
                                                                   step="0.01" 
                                                                   class="border rounded px-2 py-1 w-20 {{ !$currentSemester->is_active ? 'bg-gray-100' : '' }}"
                                                                   {{ !$currentSemester->is_active ? 'disabled' : '' }}>
                                                            @if($currentSemester->is_active)
                                                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">
                                                                    Modifier
                                                                </button>
                                                                <button type="button" 
                                                                        onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette note ?')) document.getElementById('delete-note-{{ $note->id }}').submit();"
                                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                                                    Supprimer
                                                                </button>
                                                            @endif
                                                        </form>
                                                        <form id="delete-note-{{ $note->id }}" action="{{ route('teacher.delete-note', $note) }}" method="POST" class="hidden">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Formulaire d'ajout de note -->
                                        @if($currentSemester->is_active && $noteCount < $maxNotes)
                                            <form action="{{ route('teacher.store-note') }}" method="POST" class="mt-2">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                <input type="hidden" name="note_type_id" value="{{ $noteType->id }}">
                                                <input type="hidden" name="school_year_semester_id" value="{{ $currentSemester->id }}">
                                                <div class="flex items-center space-x-2">
                                                    <input type="number" 
                                                           name="value" 
                                                           min="0" 
                                                           max="20" 
                                                           step="0.01" 
                                                           required 
                                                           class="border rounded px-2 py-1 w-20"
                                                           placeholder="Note/20">
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                                        Ajouter la note {{ $noteCount + 1 }}
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <!-- Guide et récapitulatif (1/3 de l'espace) -->
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="mb-6">
                            <h4 class="font-bold text-lg mb-2">Guide d'ajout de notes</h4>
                            <ul class="list-disc list-inside space-y-2 text-sm">
                                <li>Les notes doivent être comprises entre 0 et 20</li>
                                <li class="font-semibold text-blue-600">Exactement 3 notes d'interrogation requises</li>
                                <li class="font-semibold text-blue-600">Exactement 2 notes de devoir requises</li>
                                <li>Utilisez le point (.) pour les décimales</li>
                                <li>Les modifications sont possibles uniquement pendant le semestre actif</li>
                                <li>Toutes les notes peuvent être modifiées tant que le semestre est actif</li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <h4 class="font-bold text-lg mb-2">Récapitulatif des notes par ordre d'ajout</h4>
                            @foreach ($subjects as $subject)
                                <div class="mb-4">
                                    <h5 class="font-semibold">{{ $subject->wording }}</h5>
                                    @foreach ($noteTypes as $noteType)
                                        <div class="ml-4 mb-2">
                                            <span class="font-medium">{{ $noteType->wording }} :</span>
                                            @if(isset($notes[$subject->id][$noteType->id]))
                                                <div class="ml-2">
                                                    @foreach($notes[$subject->id][$noteType->id] as $index => $note)
                                                        <span class="inline-block mr-2">
                                                            Note {{ $index + 1 }} : {{ $note->value }}/20
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-500 italic ml-2">Aucune note</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
