<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouvel enseignant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('teacher.store') }}">
                    @csrf
                    <div class="mb-4">
                        <x-label for="firstname" value="{{ __('Prénom') }}" />
                        <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus />
                    </div>
                    <div class="mb-4">
                        <x-label for="lastname" value="{{ __('Nom') }}" />
                        <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="phone" value="{{ __('Téléphone') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Créer') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

