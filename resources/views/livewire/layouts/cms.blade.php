<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>114年健康體育週 團體衛教講座</title>
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

     <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/css/style.scss', 'resources/js/app.js'])

     <!-- Styles -->
     @livewireStyles
</head>
<body>
    <header class="bg-white shadow-md">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="flex items-center justify-between h-16">
                <nav class="flex-1 ml-10">
                    <ul class="flex space-x-8">
                        <li>
                            <a href="{{ route('cms.lottery') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">首頁</a>
                        </li>
                        <li>
                            <a href="{{ route('cms.dashboard') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">統計圖表</a>
                        </li>
                        <li>
                            <a href="{{ route('cms.feedback') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">使用者統計</a>
                        </li>
                        <li>
                            <a href="{{ route('cms.comment') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">回饋統計</a>
                        </li>
                    </ul>
                </nav>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-600">
                        登出
                    </button>
                </form>
            </div>
        </div>
     </header>
    <main class="min-h-[80vh]">
        {{ $slot }}
    </main>
    <footer class="border-t bg-gray-50">
        <div class="px-4 py-8 mx-auto max-w-7xl">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="text-center">
                    <p class="text-sm text-gray-600">© 2024 健康體育週 團體衛教講座</p>
                </div>
            </div>
        </div>
    </footer>
    @livewireScripts
    @stack('scripts')
</body>
</html>
