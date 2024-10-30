<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des semestres') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <x-button>
                        <a href="{{ route('semesters.create') }}" class="flex items-center">
                            <span class="mdi mdi-plus mr-2"></span>
                            Nouveau semestre
                        </a>
                    </x-button>
                </div>

                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semestres</th>
                                <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Années scolaires</th>
                                <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="py-3 px-6 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($semesters as $semester)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 whitespace-nowrap">{{ $semester->id }}</td>
                                    <td class="py-4 px-6 whitespace-nowrap">{{ $semester->wording }}</td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @foreach($semester->schoolYears as $schoolYear)
                                            {{ $schoolYear->wording }}
                                            @if($schoolYear->is_current)
                                         
                                            @endif
                                            @if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
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
                                    </td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap space-x-2">
                                        <a href="{{ route('semesters.show', $semester->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <span class="mdi mdi-eye bg-blue-100 p-1 rounded"></span>
                                        </a>
                                        <a href="{{ route('semesters.edit', $semester->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                            <span class="mdi mdi-pencil bg-yellow-100 p-1 rounded"></span>
                                        </a>
                                        @foreach($semester->schoolYears as $schoolYear)
                                            @if($schoolYear->is_current)
                                                <form action="{{ route('semesters.toggle-active', $semester->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="school_year_id" value="{{ $schoolYear->id }}">
                                                    <button type="submit" class="{{ $isActive ? 'text-green-600 hover:text-green-900' : 'text-gray-600 hover:text-gray-900' }}">
                                                        @if($isActive)
                                                            <span class="mdi mdi-toggle-switch bg-green-100 p-1 rounded"></span>
                                                        @else
                                                            <span class="mdi mdi-toggle-switch-off bg-gray-100 p-1 rounded"></span>
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                        @endforeach
                                        <form id="delete-form-{{ $semester->id }}" action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmDelete('{{ $semester->id }}')">
                                                <span class="mdi mdi-delete bg-red-100 p-1 rounded"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
