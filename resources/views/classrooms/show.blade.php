<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la salle de classe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <strong>Libellé:</strong> {{ $classroom->wording }}
                </div>
                <div class="mb-4">
                    <strong>Coûts:</strong> {{ number_format($classroom->costs, 0, '.', ' ') }} XOF
                </div>
                <div class="mb-4">
                    <strong>Série:</strong> {{ $classroom->serie->wording }}
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        <a href="{{ route('classrooms.edit', $classroom->id) }}" class="flex items-center">
                            <span class="mdi mdi-pencil mr-2"></span>
                            {{ __('Modifier') }}
                        </a>
                    </x-button>
                    <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" class="bg-red-600 hover:bg-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle de classe ?')">
                            <span class="mdi mdi-delete mr-2"></span>
                            {{ __('Supprimer') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
