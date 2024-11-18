<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <script>
            console.log(`%c
            ⚠️ 警告！
            ------------------
            如果有人告訴你在這裡複製/貼上任何東西，
            有 99.9% 的機率是在詐騙！

            除非你確切知道你在做什麼，
            否則請立即關閉這個視窗！

            `, 'color: red; font-size: 16px; font-weight: bold; text-shadow: 1px 1px 0 #000; background: #ffebee; padding: 10px; border-radius: 5px;');

        </script>

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
            background: url({{ asset('images/bg.webp') }}) no-repeat;
        }
    </style>

</html>
