@php
    use App\Models\User;
    use App\Models\Subject;
    use App\Models\Classroom;
    $users = User::all();
    $subjects = Subject::all();
    $classrooms = Classroom::all();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
        <div class=" overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Cards Section -->
            <div class="py-8 my-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card Etudiants -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <div class="flex justify-between items-center">
                        <div class="info">
                            <h6 class="text-sm text-gray-400">Elèves</h6>
                            <h5 class="text-xl font-semibold">{{ count($users->where('role', 'student')) }}</h5>
                        </div>
                        <div class="card-img p-2">
                            <img src="{{ asset('images/dash-icon-01.svg') }}" alt="student" class="h-12 w-12">
                        </div>
                    </div>
                </div>

                <!-- Card Professeurs -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <div class="flex justify-between items-center">
                        <div class="info">
                            <h6 class="text-sm text-gray-400">Professeurs</h6>
                            <h5 class="text-xl font-semibold">{{ count($users->where('role', 'teacher')) }}</h5>
                        </div>
                        <div class="card-img p-2">
                            <img src="{{ asset('images/teacher.svg') }}" alt="teacher" class="h-12 w-12">
                        </div>
                    </div>
                </div>

                <!-- Card Cours -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <div class="flex justify-between items-center">
                        <div class="info">
                            <h6 class="text-sm text-gray-400">Cours</h6>
                            <h5 class="text-xl font-semibold">{{ count($subjects) }}</h5>
                        </div>
                        <div class="card-img p-2">
                            <img src="{{ asset('images/books.svg') }}" alt="books" class="h-12 w-12">
                        </div>
                    </div>
                </div>

                <!-- Card Salles -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <div class="flex justify-between items-center">
                        <div class="info">
                            <h6 class="text-sm text-gray-400">Classe</h6>
                            <h5 class="text-xl font-semibold">{{ count($classrooms) }}</h5>
                        </div>
                        <div class="card-img p-2">
                            <img src="{{ asset('images/dash-icon-03.svg') }}" alt="classroom" class="h-12 w-12">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graph and Social Media Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                <!-- Graph -->
                <div class="bg-white col-span-2 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg text-gray-500">Statistique</h5>
                    <canvas id="graph-viewer"></canvas>
                </div>

                <!-- Social Media Cards -->
                <div class="flex flex-col gap-4">
                    <h5 class="text-lg text-gray-500 mb-3">Les réseaux sociaux</h5>

                    <!-- Facebook -->
                    <div class="bg-blue-500 text-white p-4 rounded-lg shadow-lg flex justify-between items-center">
                        <div>
                            <h6>Like us on Facebook</h6>
                            <h5 class="text-2xl">3000</h5>
                        </div>
                        <div class="p-2">
                            <img src="  g') }}" alt="facebook" class="h-12 w-12">
                        </div>
                    </div>

                    <!-- Twitter -->
                    <div class="bg-blue-400 text-white p-4 rounded-lg shadow-lg flex justify-between items-center">
                        <div>
                            <h6>Follow us on Twitter</h6>
                            <h5 class="text-2xl">20+</h5>
                        </div>
                        <div class="p-2">
                            <img src="{{ asset('images/social-icon-02.svg') }}" alt="twitter" class="h-12 w-12">
                        </div>
                    </div>

                    <!-- LinkedIn -->
                    <div class="bg-blue-700 text-white p-4 rounded-lg shadow-lg flex justify-between items-center">
                        <div>
                            <h6>Connect with us on LinkedIn</h6>
                            <h5 class="text-2xl">45</h5>
                        </div>
                        <div class="p-2">
                            <img src="{{ asset('images/social-icon-04.svg') }}" alt="linkedin" class="h-12 w-12">
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="bg-orange-500 text-white p-4 rounded-lg shadow-lg flex justify-between items-center">
                        <div>
                            <h6>Follow us on Instagram</h6>
                            <h5 class="text-2xl">1000</h5>
                        </div>
                        <div class="p-2">
                            <img src="{{ asset('images/social-icon-03.svg') }}" alt="instagram" class="h-12 w-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
