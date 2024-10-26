<nav x-data="{ open: false, notificationsOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->role->wording === 'admin')
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('series.index') }}" :active="request()->is('series*')">
                            {{ __('Séries') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('classrooms.index') }}" :active="request()->is('classrooms*')">
                            {{ __('Classes') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('subjects.index') }}" :active="request()->is('subjects*')">
                            {{ __('Matières') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('semesters.index') }}" :active="request()->is('semesters*')">
                            {{ __('Semestres') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('school-years.index') }}" :active="request()->is('school-years*')">
                            {{ __('Années Scolaires') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('admin.payment-settings') }}" :active="request()->routeIs('admin.payment-settings')">
                            {{ __('Paramètres de paiement') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('note-types.index') }}" :active="request()->routeIs('note-types.*')">
                            {{ __('Types de notes') }}
                        </x-nav-link>
                    @elseif(auth()->user()->role->wording === 'teacher')
                        <x-nav-link href="{{ route('teacher.dashboard') }}" :active="request()->routeIs('teacher.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('teacher.classes') }}" :active="request()->routeIs('teacher.classes')">
                            {{ __('Mes Classes') }}
                        </x-nav-link>
                    @elseif(auth()->user()->role->wording === 'parent')
                        <x-nav-link href="{{ route('parent.dashboard') }}" :active="request()->routeIs('parent.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('parent.register-student') }}" :active="request()->routeIs('parent.register-student')">
                            {{ __('Inscrire un élève') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Dropdown pour créer des utilisateurs (admin seulement) -->
                @if(auth()->user()->role->wording === 'admin')
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ __('Créer Utilisateur') }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('admin.create') }}">
                                    {{ __('Créer Admin') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('teacher.create') }}">
                                    {{ __('Créer Enseignant') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Notifications Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    <i class="mdi mdi-bell text-xl"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    @endif
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ $notification->data['message'] }}
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">Marquer comme lu</button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="block px-4 py-2 text-sm text-gray-700">Aucune notification non lue.</div>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Gérer le compte') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Notifications pour mobile -->
                <div class="mr-2 relative">
                    <button @click="notificationsOpen = !notificationsOpen" class="flex items-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <i class="mdi mdi-bell text-xl"></i>
                        @if(auth()->user()->unreadNotifications->isNotEmpty())
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
                        @endif
                    </button>
                    
                    <!-- Liste des notifications pour mobile -->
                    <div x-show="notificationsOpen" 
                         @click.away="notificationsOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50" 
                         style="display: none;">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ Str::limit($notification->data['message'], 50) }}
                            </a>
                        @empty
                            <p class="block px-4 py-2 text-sm text-gray-700">Aucune notification non lue</p>
                        @endforelse
                    </div>
                </div>

                <!-- Bouton hamburger -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role->wording === 'admin')
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('series.index') }}" :active="request()->is('series*')">
                    {{ __('Séries') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('classrooms.index') }}" :active="request()->is('classrooms*')">
                    {{ __('Classes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('subjects.index') }}" :active="request()->is('subjects*')">
                    {{ __('Matières') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('semesters.index') }}" :active="request()->is('semesters*')">
                    {{ __('Semestres') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('school-years.index') }}" :active="request()->is('school-years*')">
                    {{ __('Années Scolaires') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin.payment-settings') }}" :active="request()->routeIs('admin.payment-settings')">
                    {{ __('Paramètres de paiement') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('note-types.index') }}" :active="request()->routeIs('note-types.*')">
                    {{ __('Types de notes') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->role->wording === 'teacher')
                <x-responsive-nav-link href="{{ route('teacher.dashboard') }}" :active="request()->routeIs('teacher.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('teacher.classes') }}" :active="request()->routeIs('teacher.classes')">
                    {{ __('Mes Classes') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->role->wording === 'parent')
                <x-responsive-nav-link href="{{ route('parent.dashboard') }}" :active="request()->routeIs('parent.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('parent.register-student') }}" :active="request()->routeIs('parent.register-student')">
                    {{ __('Inscrire un élève') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Dropdown pour créer des utilisateurs (admin seulement) en version responsive -->
                @if(auth()->user()->role->wording === 'admin')
                    <div class="border-t border-gray-200"></div>
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Créer Utilisateur') }}
                    </div>
                    <x-responsive-nav-link href="{{ route('admin.create') }}">
                        {{ __('Créer Admin') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('teacher.create') }}">
                        {{ __('Créer Enseignant') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>
