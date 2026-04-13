<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password - Order Ready</title>
    @include('layouts.head')
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')


    <main class="flex-grow flex items-center justify-center p-4">

        <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="w-full p-8 md:p-10">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 text-blue-600 rounded-full mb-4">
                        <i class="fa-solid fa-key text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Forgot Password?</h2>
                    <p class="text-gray-500 mt-2 text-sm md:text-base">Enter your email address to reset your password.
                    </p>
                </div>

                @if (session('status'))
                    <div
                        class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-bold flex items-center">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('auth.password.email') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2 font-semibold px-1 text-sm">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="example@gmail.com"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white"
                                required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-2 px-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <span>Send Reset Link</span>
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('auth.login') }}"
                        class="text-gray-500 hover:text-blue-600 font-bold transition-colors inline-flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>

    </main>

    @include('layouts.footer')

</body>

</html>
