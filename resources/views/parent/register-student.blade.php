<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inscrire un élève') }}
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
                <form action="{{ route('parent.register-student.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-label for="firstname" value="{{ __('Prénom') }}" />
                            <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus />
                        </div>
                        <div>
                            <x-label for="lastname" value="{{ __('Nom') }}" />
                            <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required />
                        </div>
                        <div>
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>
                        <div>
                            <x-label for="phone" value="{{ __('Téléphone') }}" />
                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
                        </div>
                        <div>
                            <x-label for="classroom_id" value="{{ __('Classe') }}" />
                            <select id="classroom_id" name="classroom_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">{{ __('Sélectionner une classe') }}</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->wording }} ({{ $classroom->serie->wording }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="student_avatar"  >
                                {{ __("Photo de l'élève") }}
                            </x-label>
                            <input id="student_avatar" type="file" name="student_avatar" class="block mt-1 w-full" required />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Inscrire') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

