@php
    use App\Models\User;
    use App\Models\Subject;
    use App\Models\Classroom;
    use App\Models\Role;
    $user = Auth::user();
    $users = User::with('role')->get();	
    $role = $user->role->wording;
    $subjects = Subject::all();
    $classrooms = Classroom::all();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboardo') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
        <div class="overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Cards Section -->
            
                @if($role === 'admin')
                <div class="py-8 my-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Admin Cards -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Elèves</h6>
                                <h5 class="text-xl font-semibold">{{ $users->where('role.wording', 'student')->count() }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-01.svg') }}" alt="student" class="h-12 w-12">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Professeurs</h6>
                                <h5 class="text-xl font-semibold">{{ $users->where('role.wording', 'teacher')->count() }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/teacher.svg') }}" alt="teacher" class="h-12 w-12">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Cours</h6>
                                <h5 class="text-xl font-semibold">{{ ($subjects->count()) }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/books.svg') }}" alt="books" class="h-12 w-12">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Classes</h6>
                                <h5 class="text-xl font-semibold">{{ ($classrooms->count()) }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-03.svg') }}" alt="classroom" class="h-12 w-12">
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($role === 'teacher')
                <div class="py-8 my-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Teacher Cards -->
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Mes Classes</h6>
                                <h5 class="text-xl font-semibold">{{ $user->teachingSubjects->pluck('classroom')->unique()->count() }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-03.svg') }}" alt="classroom" class="h-12 w-12">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Mes Étudiants</h6>
                                <h5 class="text-xl font-semibold">{{ $user->teachingSubjects->flatMap->classroom->flatMap->students->unique()->count() }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/dash-icon-01.svg') }}" alt="student" class="h-12 w-12">
                            </div>
                        </div>
                    </div>
                
                    <div class="bg-white border rounded-lg p-4 shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="info">
                                <h6 class="text-sm text-gray-400">Mes Matières</h6>
                                <h5 class="text-xl font-semibold">{{ $user->teachingSubjects->count() }}</h5>
                            </div>
                            <div class="card-img p-2">
                                <img src="{{ asset('images/books.svg') }}" alt="books" class="h-12 w-12">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Additional Content Section -->
            @if($role === 'admin')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                    <!-- Graph -->
                    <div class="bg-white col-span-2 p-6 rounded-lg shadow-lg">
                        <h5 class="text-lg text-gray-500">Statistiques</h5>
                        <canvas id="graph-viewer"></canvas>
                    </div>

                    <!-- Social Media Cards -->
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-4">
                            <h5 class="text-lg text-gray-500 mb-3">Les réseaux sociaux</h5>
        
                            <!-- Facebook -->
                            <div class="bg-blue-500 text-white p-4 rounded-lg shadow-lg flex justify-between items-center">
                                <div>
                                    <h6>Like us on Facebook</h6>
                                    <h5 class="text-2xl">3000</h5>
                                </div>
                                <div class="p-2">
                                    <img src="{{ asset('images/social-icon-01.svg') }}" alt="facebook" class="h-12 w-12">
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
            @elseif($role === 'teacher')
                <div class="mt-8">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="mt-4">
                            <a href="{{ route('teacher.classes') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Voir mes classes
                            </a>
                        </div>
                    </div>
                    
                </div>
            @elseif($role === 'parent')
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h3>
                        
                        <div class="mb-6">
                            <h4 class="text-md font-semibold mb-2">Actions rapides</h4>
                            <a href="{{ route('parent.register-student') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                Inscrire un élève
                            </a>
                        </div>
        
                        <div class="mb-6">
                            <h4 class="text-md font-semibold mb-2">Mes enfants (élèves inscrits)</h4>
                            @forelse(auth()->user()->registrations as $registration)
                                <div class="mb-4 p-4 border rounded">
                                    <p><strong>Nom :</strong> {{ $registration->student->firstname }} {{ $registration->student->lastname }}</p>
                                    <p><strong>Classe :</strong> {{ $registration->classroom->wording }}</p>
                                    <p><strong>Année scolaire :</strong> {{ $registration->schoolYear->wording }}</p>
                                    <div class="mt-2">
                                        <a href="{{ route('parent.registration-form', $registration->id) }}" class="text-blue-600 hover:text-blue-800">Télécharger la fiche d'inscription</a>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('parent.payment-form', $registration->id) }}" class="text-green-600 hover:text-green-800">Effectuer un paiement</a>
                                    </div>
                                </div>
                            @empty
                                <p>Aucun élève inscrit pour le moment.</p>
                            @endforelse
                        </div>
        
                        <div>
                            <h4 class="text-md font-semibold mb-2">Notifications récentes</h4>
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="mb-2 p-2 bg-yellow-100 rounded">
                                    <p>{{ $notification->data['message'] }}</p>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">Marquer comme lu</button>
                                    </form>
                                </div>
                            @empty
                                <p>Aucune notification non lue.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
