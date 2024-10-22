<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MySchoolManager') }}</title>
        <link rel="icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="{{ asset('vendor/mdi/css/materialdesignicons.min.css') }}">

        <!-- Animate.css -->
        <link rel="stylesheet" href="{{ asset('vendor/animate/animate.css') }}">
        
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.all.min.css') }}">
        
        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <!-- SweetAlert2 -->
        <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

        <!-- Toastr -->
        <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
        
        <!-- Chart.js -->
        <script src="{{ asset('vendor/chartjs/chartjs.min.js') }}"></script>

    </body>
</html>
