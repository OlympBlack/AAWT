<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du semestre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <strong>Semestre:</strong> {{ $semester->wording }}
                </div>
                <div class="mb-4">
                    <strong>Années scolaires:</strong>
                    <ul>
                        @foreach($semester->schoolYears as $schoolYear)
                            <li>{{ $schoolYear->wording }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="mb-4">
                    <strong>Statut:</strong>
                    @php
                        $isActive = $semester->schoolYears->where('is_current', true)->first() && 
                                    $semester->schoolYears->where('is_current', true)->first()
                                            ->schoolYearSemesters->where('semester_id', $semester->id)
                                            ->first()->is_active;
                    @endphp
                    @if($isActive)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Courant
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Inactif
                        </span>
                    @endif
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        <a href="{{ route('semesters.edit', $semester->id) }}" class="flex items-center">
                            <span class="mdi mdi-pencil mr-2"></span>
                            {{ __('Modifier') }}
                        </a>
                    </x-button>
                    @foreach($semester->schoolYears as $schoolYear)
                        @if($schoolYear->is_current)
                            <form action="{{ route('semesters.toggle-active', $semester->id) }}" method="POST" class="ml-2">
                                @csrf
                                <input type="hidden" name="school_year_id" value="{{ $schoolYear->id }}">
                                <x-button type="submit" class="{{ $isActive ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-600 hover:bg-gray-700' }}">
                                    @if($isActive)
                                        <span class="mdi mdi-toggle-switch mr-2"></span>
                                        {{ __('Désactiver') }}
                                    @else
                                        <span class="mdi mdi-toggle-switch-off mr-2"></span>
                                        {{ __('Activer') }}
                                    @endif
                                </x-button>
                            </form>
                        @endif
                    @endforeach
                    <form id="delete-form-{{ $semester->id }}" action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <x-button type="button" class="bg-red-600 hover:bg-red-700" onclick="confirmDelete('{{ $semester->id }}')">
                            <span class="mdi mdi-delete mr-2"></span>
                            {{ __('Supprimer') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Inclure SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/delete-confirmation.js')}} "></script>  

</x-app-layout>
