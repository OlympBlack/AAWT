<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Vérification de carte d'étudiant</h2>
                </div>

                <div class="border-2 border-green-500 rounded-lg p-6 max-w-2xl mx-auto">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-20 w-20 rounded-full overflow-hidden">
                            <img src="{{ Storage::url($currentRegistration->student_avatar) }}" 
                                 alt="Photo de l'étudiant" 
                                 class="h-full w-full object-cover">
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-xl font-semibold text-gray-800">
                            {{ $student->firstname }} {{ $student->lastname }}
                        </p>
                        <p class="text-gray-600">
                            Classe : {{ $currentRegistration->classroom->wording }}
                        </p>
                        <p class="text-gray-600">
                            Année scolaire : {{ $currentRegistration->schoolYear->wording }}
                        </p>
                        <div class="mt-4">
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full">
                                ✓ Carte valide
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>