<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/js/auth/login.js'])
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl overflow-hidden">

        <div id="form-alert"
            class="fixed top-6 left-1/2 -translate-x-1/2 hidden px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 transition-all duration-300">
        </div>

        <div class="w-full p-8 md:p-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
                <p class="text-gray-500 mt-2">Log in to your Order Ready account</p>
            </div>

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <form id="login-form" method="POST" action="#">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2 font-semibold">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold text-sm mb-2 px-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password-input" placeholder="••••••••"
                            class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all bg-slate-50 focus:bg-white font-semibold">

                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                            <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M17.94 17.94A10.94 10.94 0 0112 20C5 20 1 12 1 12a21.86 21.86 0 015.06-6.94M9.9 4.24A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.78 21.78 0 01-2.16 3.19M1 1l22 22">
                                </path>
                            </svg>
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

                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-bold transition-colors">
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

</body>

</html>
