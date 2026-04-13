<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Order Ready</title>
    @include('layouts.head')
    @vite(['resources/js/auth/login.js','resources/js/globalUtils/notifications.js'])
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')
    @include('layouts.notifications')


    <main class="flex-grow flex items-center justify-center p-4">

        <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl overflow-hidden">

            <div class="w-full p-8 md:p-10">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 text-blue-600 rounded-full mb-4">
                        <i class="fa-solid fa-user-lock text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
                    <p class="text-gray-500 mt-2">Log in to your Order Ready account</p>
                </div>

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-bold">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('status'))
                    <div
                        class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-bold flex items-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form id="login-form" method="POST" action="#">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-semibold">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="example@gmail.com"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold text-sm mb-2 px-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password-input" placeholder="••••••••"
                                class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white font-semibold">

                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                                <i id="eye-icon" class="fa-solid fa-eye w-5 h-5"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1 px-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-8 px-1">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                            <span
                                class="ml-2 text-sm text-gray-600 font-medium group-hover:text-gray-900 transition-colors">Remember
                                me</span>
                        </label>

                        <a href="{{ route('auth.password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 font-bold transition-colors">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-[0.98]">
                        Sign In
                    </button>
                </form>

                <p class="text-center text-gray-500 mt-8 text-sm">
                    Don't have an account?
                    <a href="{{ route('auth.register') }}"
                        class="text-blue-600 font-bold hover:underline transition duration-200">Create one</a>
                </p>
            </div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
