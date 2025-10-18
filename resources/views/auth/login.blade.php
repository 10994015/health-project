<x-guest-layout>
    <div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('images/LOGO.webp') }}" class="h-16">
            </div>
            <!-- 標題 -->
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-center text-gray-900">
                114年健康體育週 團體衛教講座
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                系統登入
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-4 py-8 bg-white shadow-lg sm:rounded-lg sm:px-10">
                <!-- 錯誤訊息 -->
                <x-validation-errors class="p-4 mb-4 text-sm text-red-600 rounded-md bg-red-50" />

                @if (session('status'))
                    <div class="p-4 mb-4 text-sm font-medium text-green-600 rounded-md bg-green-50">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- 登入表單 -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-label for="username" value="帳號" class="block text-sm font-medium text-gray-700" />
                        <div class="mt-1">
                            <x-input id="username"
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                type="text"
                                name="username"
                                :value="old('username')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="請輸入帳號" />
                        </div>
                    </div>

                    <div>
                        <x-label for="password" value="密碼" class="block text-sm font-medium text-gray-700" />
                        <div class="mt-1">
                            <x-input id="password"
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="請輸入密碼" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label for="remember_me" class="block ml-2 text-sm text-gray-900">
                                記住我
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                    忘記密碼？
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            登入
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>
