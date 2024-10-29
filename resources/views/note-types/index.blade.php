{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Types de notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('note-types.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ajouter un type de note
                    </a>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Libellé</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($noteTypes as $noteType)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap">{{ $noteType->wording }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm font-medium">
                                    <a href="{{ route('note-types.edit', $noteType) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">
                                        <span class="mdi mdi-pencil text-lg bg-yellow-100 p-2 rounded"></span>
                                    </a>
                                    <form action="{{ route('note-types.destroy', $noteType) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type de note ?')">
                                            <span class="mdi mdi-delete text-lg bg-red-100 p-2 rounded"></span>
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
</x-app-layout> --}}