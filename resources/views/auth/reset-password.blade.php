<!DOCTYPE html>
<html lang="en">

<head>
    <title>Set New Password - Order Ready</title>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">New Password</h2>
                    <p class="text-gray-500 mt-2 font-medium">Please enter your new secure password below.</p>
                </div>

                <form method="POST" action="{{ route('auth.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request('email') }}">

                    <div class="mb-5">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">New Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white"
                                placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2 px-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">Confirm New Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-check-double"></i>
                            </span>
                            <input type="password" name="password_confirmation"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <span>Update Password</span>
                        <i class="fa-solid fa-circle-check"></i>
                    </button>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
