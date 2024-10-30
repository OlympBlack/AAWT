<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de l\'année scolaire') }}
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
                <div class="mb-4">
                    <strong>Libellé:</strong> {{ $schoolYear->wording }}
                </div>
                <div class="mb-4">
                    <strong>Statut:</strong> 
                    @if($schoolYear->is_current)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Courante
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Inactive
                        </span>
                    @endif
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        <a href="{{ route('school-years.edit', $schoolYear->id) }}" class="flex items-center">
                            <span class="mdi mdi-pencil mr-2"></span>
                            {{ __('Modifier') }}
                        </a>
                    </x-button>
                    <form id="delete-form-{{ $schoolYear->id }}"action="{{ route('school-years.destroy', $schoolYear->id) }}" method="POST" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <x-button type="button" class="bg-red-600 hover:bg-red-700" onclick="confirmDelete('{{ $schoolYear->id }}')">
                            <span class="mdi mdi-delete mr-2"></span>
                            {{ __('Supprimer') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Inclure SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/delete-confirmation.js')}} "></script>  

</x-app-layout>
