<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord de l\'enseignant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ $teacher->firstname }} {{ $teacher->lastname }}</h3>
                
                <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <!-- Card Classes -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Mes Classes</h6>
                                <h5 class="text-xl font-semibold">{{ $classrooms->count() }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-03.svg') }}" alt="classroom" class="h-12 w-12">
                            </div>
                        </div>
                    </div>

                    <!-- Card Étudiants -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Mes Étudiants</h6>
                                <h5 class="text-xl font-semibold">{{ $totalStudents }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-01.svg') }}" alt="student" class="h-12 w-12">
                            </div>
                        </div>
                    </div>

                    <!-- Card Matières -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Mes Matières</h6>
                                <h5 class="text-xl font-semibold">{{ $totalSubjects }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/books.svg') }}" alt="books" class="h-12 w-12">
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('teacher.classes') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Voir mes classes
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
