<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->


        <!-- Scripts -->
        @vite(['resources/css/style.scss'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
        @livewireScripts
    </body>
    <style>
        .main{
            background: url({{ asset('images/bg.jpg') }}) no-repeat;
        }
    </style>
</html>
